<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use Aws\Rekognition\RekognitionClient;
use Aws\Credentials\Credentials;

class UsersController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        return view('register', [
            'title' => 'Register | Online Test Platform',
            'active' => 'register'
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        
        $idcardPath = $this->storeTempFile($request, 'idcard');
        $photoPath = $this->storeTempFile($request, 'photo');

        if (!$idcardPath || !$photoPath) {
            return back()->withErrors('File upload failed. Please try again.')->withInput();
        }

        $idcardImage = file_get_contents($idcardPath);
        $photoImage = file_get_contents($photoPath);

        $rekognition = $this->getRekognitionClient();

        if (!$this->hasSingleFace($idcardImage, $rekognition)) {
            unlink($idcardPath);
            unlink($photoPath);
            return back()->withErrors('ID Card image must contain exactly one face.')->withInput();
        }

        if (!$this->hasSingleFace($photoImage, $rekognition)) {
            unlink($idcardPath);
            unlink($photoPath);
            return back()->withErrors('Photo image must contain exactly one face.')->withInput();
        }

        $facesMatch = $this->compareFaces($idcardImage, $photoImage, $rekognition);

        if (!$facesMatch) {
            unlink($idcardPath);
            unlink($photoPath);
            return back()->withErrors('ID Card and Photo verification failed. Face did not match.')->withInput();
        }

        $idcardUrl = $this->storeFileToS3($idcardPath, 'users');
        $photoUrl = $this->storeFileToS3($photoPath, 'users');

        if ($idcardUrl && $photoUrl) {
            unlink($idcardPath);
            unlink($photoPath);
        }

        $validatedData['idcard'] = $idcardUrl;
        $validatedData['photo'] = $photoUrl;

        User::create($validatedData);

        return redirect('/login')->with('success', 'Account successfully created');
    }

    private function storeTempFile($request, $field)
    {
        if ($request->file($field)) {
            $file = $request->file($field);
            $tempPath = storage_path('app/temp/' . uniqid() . '.jpg');
            $file->move(dirname($tempPath), basename($tempPath));
            return $tempPath;
        }
        return null;
    }

    private function storeFileToS3($filePath, $directory)
    {
        try {
            $fileName = uniqid() . '.jpg';
            $path = Storage::disk('s3')->putFileAs($directory, new \Illuminate\Http\File($filePath), $fileName, 'public');
            return Storage::disk('s3')->url($path);
        } catch (\Exception $e) {
            Log::error("Failed to upload file to S3: " . $e->getMessage());
            return null;
        }
    }

    private function getRekognitionClient()
    {
        $credentials = new Credentials(env('AWS_ACCESS_KEY_ID'), env('AWS_SECRET_ACCESS_KEY'));

        return new RekognitionClient([
            'version' => 'latest',
            'region' => env('AWS_DEFAULT_REGION'),
            'credentials' => $credentials
        ]);
    }

    private function hasSingleFace($image, $rekognition)
    {
        $result = $rekognition->detectFaces([
            'Image' => ['Bytes' => $image],
            'Attributes' => ['ALL']
        ]);

        return count($result['FaceDetails']) === 1;
    }

    private function compareFaces($idCardImage, $photoImage, $rekognition)
    {
        $result = $rekognition->compareFaces([
            'SourceImage' => ['Bytes' => $idCardImage],
            'TargetImage' => ['Bytes' => $photoImage],
            'SimilarityThreshold' => 98
        ]);

        return !empty($result['FaceMatches']);
    }

    public function show(User $users)
    {
        return view('profile', [
            'title' => 'Profile | Online Test Platform',
            'active' => 'Profile'
        ]);
    }

    public function edit(User $users)
    {
        //
    }

    public function update(Request $request, User $user)
    {
        //
    }

    public function destroy(User $users)
    {
        //
    }
}
