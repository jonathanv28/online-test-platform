<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Support\Facades\Storage;

class FaceValidationController extends Controller
{
    public function validateFace(Request $request)
    {
        Log::info('Received face validation request');

        $request->validate([
            'image' => 'required'
        ]);

        $user = auth()->user();

        if (!$user) {
            Log::error('No authenticated user found.');
            return response()->json(['error' => 'Authentication required'], 401);
        }

        try {
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
            $filename = 'webcam_captures/' . uniqid() . '.jpg'; // Save in a specific folder with a unique ID

            // Save to S3 and get URL
            Storage::disk('s3')->put($filename, $imageData);
            $sourceImageUrl = Storage::disk('s3')->url($filename);
            $sourceImagePath = parse_url($sourceImageUrl, PHP_URL_PATH);
            $sourceImagePath = ltrim($sourceImagePath, '/');
            
            Log::info('Webcam image name: ' . $sourceImagePath);

            Log::info('Webcam image uploaded to S3', ['url' => $sourceImageUrl]);

            $targetImageUrl = $user->photo;
            $targetImagePath = parse_url($targetImageUrl, PHP_URL_PATH);
            $targetImagePath = ltrim($targetImagePath, '/');

            if (Storage::disk('s3')->exists($targetImagePath) && (Storage::disk('s3')->exists($sourceImagePath))) {
                $targetImage = Storage::disk('s3')->get($targetImagePath);
                $sourceImage = Storage::disk('s3')->get($sourceImagePath);
                
                $isMatch = $this->compareFaces($sourceImage, $targetImage);
                Log::info('AWS Rekognition compareFaces called');

                if (isset($isMatch['FaceMatches']) && $isMatch['FaceMatches'][0]['Similarity'] >= 98) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Faces do not match']);
                }
            } else {
                Log::error('Target image not found in S3.', ['path' => $targetImagePath]);
                return response()->json(['error' => 'Target image not found'], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error in face validation: " . $e->getMessage());
            return response()->json(['error' => 'Error processing face validation', 'details' => $e->getMessage()], 500);
        }
    }

    protected function compareFaces($sourceImage, $targetImage)
    {
        $rekognition = new RekognitionClient([
            'version' => 'latest',
            'region' => 'ap-southeast-2', // Ensure the region is correct
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $result = $rekognition->compareFaces([
            'SimilarityThreshold' => 98,
            'SourceImage' => ['Bytes' => $sourceImage],
            'TargetImage' => ['Bytes' => $targetImage],
        ]);

        return $result;
    }
}
