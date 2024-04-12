<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PhotosController extends Controller
{
    public function showForm()
    {
        return view('facevalidate', [
            'title' => 'Validate Face | Online Test Platform',
            'active' => 'home',
        ]);
    }
    
    public function submitForm(Request $request)
    {
        $client = new RekognitionClient([
            'region'    => 'ap-southeast-2',
            'version'   => 'latest'
        ]);
    
        $user = auth()->user();

        $imagePath = storage_path('app/public/' . $user->photo); // Get the full path to the user's photo in storage
        $bytes1 = Storage::get($imagePath);

        $validator = Validator::make($request->all(), [
            'image' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $imageData = base64_decode($request->input('image'));
        $imageName =  uniqid() . '.jpg';
        $imagePath = 'public/users/' . $imageName;

        Storage::put($imagePath, $imageData);

        $image2 = Storage::get($imagePath);

    $results = $client->compareFaces([
            'SimilarityThreshold' => 98,
            'SourceImage' => [
                'Bytes' => $bytes1
            ],
            'TargetImage' => [
                'Bytes' => $image2
            ],
        ]);
    
        Storage::delete($imagePath);
        
        return view('facevalidate', ['results' => $results]);
        
    }
}
