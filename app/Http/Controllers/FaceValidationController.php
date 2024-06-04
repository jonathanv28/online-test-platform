<?php

namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Aws\Credentials\Credentials;

class FaceValidationController extends Controller
{
    public function validateFace(Request $request)
    {
        Log::info('Received face validation request');

        $request->validate([
            'image' => 'required',
            'test_id' => 'required|exists:tests,id'
        ]);

        $user = auth()->user();
        $testId = $request->input('test_id');
        $test = Test::find($testId);

        if (!$user) {
            Log::error('No authenticated user found.');
            return response()->json(['error' => 'Authentication required'], 401);
        }

        if (!$test) {
            Log::error('Test not found.');
            return response()->json(['error' => 'The test does not exist.'], 404);
        }

        try {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
            $filename = 'webcam_captures/' . uniqid() . '.jpg';

            Storage::disk('s3')->put($filename, $imageData);
            $sourceImageUrl = Storage::disk('s3')->url($filename);
            $sourceImagePath = ltrim(parse_url($sourceImageUrl, PHP_URL_PATH), '/');

            $targetImageUrl = $user->photo;
            $targetImagePath = ltrim(parse_url($targetImageUrl, PHP_URL_PATH), '/');

            $targetImage = Storage::disk('s3')->get($targetImagePath);
            $sourceImage = Storage::disk('s3')->get($sourceImagePath);

            $isMatch = $this->compareFaces($sourceImage, $targetImage);

            $faceDetails = $this->detectFaces($sourceImage);

            if (isset($isMatch['FaceMatches']) && $isMatch['FaceMatches'][0]['Similarity'] >= 98) {
                if ($this->isLive($faceDetails)) {
                    $result = Result::where('user_id', $user->id)->where('test_id', $test->id)->first();
                    if (!$result) {
                        Result::create([
                            'user_id' => $user->id,
                            'test_id' => $test->id,
                        ]);
                    }
                    return response()->json(['success' => true, 'testId' => $test->id]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Liveness check failed']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Faces do not match']);
            }
        } catch (\Exception $e) {
            Log::error("Error in face validation: " . $e->getMessage());
            return response()->json(['error' => 'Error processing face validation', 'details' => $e->getMessage()], 500);
        }
    }

    protected function compareFaces($sourceImage, $targetImage)
    {
        $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));

        $rekognition = new RekognitionClient([
            'version' => 'latest',
            'region' => 'ap-southeast-2',
            'credentials' => $credentials
        ]);

        $result = $rekognition->compareFaces([
            'SimilarityThreshold' => 98,
            'SourceImage' => ['Bytes' => $sourceImage],
            'TargetImage' => ['Bytes' => $targetImage],
        ]);

        return $result;
    }
    protected function detectFaces($image)
    {
        $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));

        $rekognition = new RekognitionClient([
            'version' => 'latest',
            'region' => 'ap-southeast-2',
            'credentials' => $credentials
        ]);

        $result = $rekognition->detectFaces([
            'Image' => ['Bytes' => $image],
            'Attributes' => ['ALL']
        ]);

        return $result;
    }

    protected function isLive($faceDetails)
    {
        if (isset($faceDetails['FaceDetails'][0])) {
            $face = $faceDetails['FaceDetails'][0];

            return $face['EyesOpen']['Value'] && $face['MouthOpen']['Value'] && !$face['Sunglasses']['Value'];
        }

        return false;
    }
}
