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
            $imageData = base64_decode($request->image);
            Log::info('Image data decoded');
    
            $userImageUrl = $user->photo;
            $userImagePath = parse_url($userImageUrl, PHP_URL_PATH);
            $userImagePath = ltrim($userImagePath, '/');
    
            Log::info('Extracted S3 path:', ['path' => $userImagePath]);
    
            if (Storage::disk('s3')->exists($userImagePath)) {
                $userImage = Storage::disk('s3')->get($userImagePath);
                Log::info('Image retrieved successfully from S3.');
                $isMatch = $this->compareFaces($imageData, $userImage);
                Log::info('AWS Rekognition compareFaces called');
    
                if (isset($isMatch['FaceMatches']) && $isMatch['FaceMatches'][0]['Similarity'] >= 98) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Faces do not match']);
                }
            } else {
                Log::error('Image not found in S3.', ['path' => $userImagePath]);
                return response()->json(['error' => 'User image not found'], 404);
            }
        } catch (\Exception $e) {
            Log::error("Error in face validation: " . $e->getMessage());
            return response()->json(['error' => 'Error processing face validation', 'details' => $e->getMessage()], 500);
        }
    }
    

    protected function compareFaces($sourceImage, $targetImage)
    {
        $rekognition = new RekognitionClient([
            'version'     => 'latest',
            'region'      => 'ap-southeast-2', // Ensure the region is correct
            'credentials' => [
                'key'    => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);

        $result = $rekognition->compareFaces([
            'SimilarityThreshold' => 98,
            'SourceImage' => [
                'Bytes' => $sourceImage,
            ],
            'TargetImage' => [
                'Bytes' => $targetImage,
            ],
        ]);

        return $result;
    }
}
