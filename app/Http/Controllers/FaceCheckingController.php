<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\Rekognition\RekognitionClient;
use App\Models\CheckingLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FaceCheckingController extends Controller
{
    private $rekognition;

    public function __construct()
    {
        $this->rekognition = new RekognitionClient([
            'region' => env('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ]
        ]);
    }

    public function monitorFrame(Request $request)
    {
        $user = Auth::user();
        $imageData = $request->input('image');
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

        // Save the frame temporarily
        $tempImagePath = storage_path('app/public/temp_image.jpg');
        file_put_contents($tempImagePath, $image);

        // Load the user's registered photo from S3
        $userPhotoUrl = $user->photo;
        $userPhotoPath = ltrim(parse_url($userPhotoUrl, PHP_URL_PATH), '/');
        $userPhoto = Storage::disk('s3')->get($userPhotoPath);

        // Detect faces in the frame
        $result = $this->rekognition->detectFaces([
            'Image' => [
                'Bytes' => $image,
            ],
            'Attributes' => ['ALL'],
        ]);

        $faceDetails = $result['FaceDetails'];

        // Check for cheating
        if (count($faceDetails) > 1) {
            $this->logCheating($user->id, $tempImagePath, 'Multiple faces detected.');
        } elseif (count($faceDetails) === 0) {
            $this->logCheating($user->id, $tempImagePath, 'No face detected.');
        } else {
            // Compare the detected face with the registered photo
            $faceComparison = $this->rekognition->compareFaces([
                'SourceImage' => [
                    'Bytes' => $userPhoto,
                ],
                'TargetImage' => [
                    'Bytes' => $image,
                ],
                'SimilarityThreshold' => 98,
            ]);

            $faceMatches = $faceComparison['FaceMatches'];

            if (count($faceMatches) === 0) {
                $this->logCheating($user->id, $tempImagePath, 'Face does not match registered photo.');
            }
        }

        return response()->json(['success' => true]);
    }

    private function logCheating($userId, $imagePath, $reason)
    {
        // Upload the image to S3
        $imageName = 'checking_logs/' . time() . '_' . $userId . '.jpg';
        Storage::disk('s3')->put($imageName, file_get_contents($imagePath), 'public');

        // Log the cheating incident
        CheckingLog::create([
            'user_id' => $userId,
            'image' => Storage::disk('s3')->url($imageName),
            'reason' => $reason,
        ]);
    }
}
