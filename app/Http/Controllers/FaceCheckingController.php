<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Aws\Rekognition\RekognitionClient;
use App\Models\CheckingLog;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
        try {
            $user = Auth::user();
            if (!$user) {
                Log::error('Monitor Frame: User not authenticated');
                return response()->json(['success' => false, 'message' => 'User not authenticated'], 401);
            }

            $imageData = $request->input('image');
            $testId = $request->input('test_id');
            Log::info('Monitor Frame: Request received', ['user_id' => $user->id, 'test_id' => $testId]);

            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
            $tempImagePath = storage_path('app/public/temp_image_monitoring.jpg');
            file_put_contents($tempImagePath, $image);
            Log::info('Monitor Frame: Image saved to temporary path', ['path' => $tempImagePath]);

            $userPhotoUrl = $user->photo;
            $userPhotoPath = ltrim(parse_url($userPhotoUrl, PHP_URL_PATH), '/');
            $userPhoto = Storage::disk('s3')->get($userPhotoPath);
            Log::info('Monitor Frame: User photo retrieved from S3', ['path' => $userPhotoPath]);

            $result = $this->rekognition->detectFaces([
                'Image' => [
                    'Bytes' => $image,
                ],
                'Attributes' => ['ALL'],
            ]);

            $faceDetails = $result['FaceDetails'];
            Log::info('Monitor Frame: Face detection result', ['face_details' => $faceDetails]);

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
                Log::info('Monitor Frame: Face comparison result', ['face_matches' => $faceMatches]);

                if (count($faceMatches) === 0) {
                    $this->logCheating($user->id, $testId, $tempImagePath, 'Face does not match the registered photo.');
                }
            }

            unlink($tempImagePath);
            Log::info('Monitor Frame: Temporary image file deleted', ['path' => $tempImagePath]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Monitor Frame: An error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'An error occurred during face monitoring.'], 500);
        }
    }


    private function logCheating($userId, $testId, $imagePath, $reason)
    {
        try {
            $imageName = 'checking_logs/' . time() . '_' . $userId . '.jpg';
            Storage::disk('s3')->put($imageName, file_get_contents($imagePath), 'public');
            Log::info('Monitor Frame: Cheating log image uploaded to S3', ['path' => $imageName]);

            CheckingLog::create([
                'user_id' => $userId,
                'test_id' => $testId,
                'image' => Storage::disk('s3')->url($imageName),
                'reason' => $reason,
            ]);
            Log::info('Monitor Frame: Cheating log created', ['user_id' => $userId, 'test_id' => $testId, 'reason' => $reason]);
        } catch (\Exception $e) {
            Log::error('Monitor Frame: An error occurred while logging cheating', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        }
    }

    public function getLatestLogs(Test $test)
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $latestLog = CheckingLog::where('user_id', $userId)
                ->where('test_id', $test->id)
                ->orderBy('created_at', 'desc')
                ->first();

            return response()->json(['reason' => $latestLog->reason, 'timestamp' => $latestLog->created_at]);
        } catch (\Exception $e) {
            Log::error('Get Latest Logs: An error occurred', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return response()->json(['success' => false, 'message' => 'An error occurred while retrieving the logs.'], 500);
        }
    }  
}
