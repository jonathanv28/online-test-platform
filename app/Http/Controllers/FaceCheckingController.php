<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\Rekognition\RekognitionClient;
use App\Models\CheckingLog;
use App\Models\Test;
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
        $testId = $request->input('test_id');
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

        $tempImagePath = storage_path('app/public/temp_image_monitoring.jpg');
        file_put_contents($tempImagePath, $image);

        $userPhotoUrl = $user->photo;
        $userPhotoPath = ltrim(parse_url($userPhotoUrl, PHP_URL_PATH), '/');
        $userPhoto = Storage::disk('s3')->get($userPhotoPath);

        $result = $this->rekognition->detectFaces([
            'Image' => [
                'Bytes' => $image,
            ],
            'Attributes' => ['ALL'],
        ]);

        $faceDetails = $result['FaceDetails'];

        if (count($faceDetails) > 1) {
            $this->logCheating($user->id, $testId, $tempImagePath, 'Multiple faces detected.');
        } elseif (count($faceDetails) === 0) {
            $this->logCheating($user->id, $testId, $tempImagePath, 'No face detected.');
        } else {
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
                $this->logCheating($user->id, $testId, $tempImagePath, 'Face does not match the registered photo.');
            }
        }

        unlink($tempImagePath);
        return response()->json(['success' => true]);
}

    private function logCheating($userId, $testId, $imagePath, $reason)
    {
        $imageName = 'checking_logs/' . time() . '_' . $userId . '.jpg';
        Storage::disk('s3')->put($imageName, file_get_contents($imagePath), 'public');

        CheckingLog::create([
            'user_id' => $userId,
            'test_id' => $testId,
            'image' => Storage::disk('s3')->url($imageName),
            'reason' => $reason,
        ]);
    }

    public function getLatestLogs(Test $test)
    {
        $user = Auth::user();
        $userId = $user->id;
        $latestLog = CheckingLog::where('user_id', $userId)
            ->where('test_id', $test->id)
            ->orderBy('created_at', 'desc')
            ->first();
    
        return response()->json(['reason' => $latestLog->reason, 'timestamp' => $latestLog->created_at]);
    }    
}
