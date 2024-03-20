<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\Rekognition\RekognitionClient;
use Illuminate\Support\Facades\Storage;
use Validator;

class PhotosController extends Controller
{
    public function showForm()
    {
        return view('form');
    }
    
    public function submitForm(Request $request)
    {
        $client = new RekognitionClient([
            'region'    => 'ap-southeast-2',
            'version'   => 'latest'
        ]);
    
        $image1 = fopen($request->file('photo1')->getPathName(), 'r');
        $bytes1 = fread($image1, $request->file('photo1')->getSize());
    
        $validator = Validator::make($request->all(), [
            'image' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Decode the base64-encoded image data
        $imageData = base64_decode($request->input('image'));

        // Save the image data to a file
        $imageName = time() . '.jpg'; // Assume JPEG format
        $imagePath = 'public/' . $imageName;

        Storage::put($imagePath, $imageData);
        
        $image2 = fopen(public_path('storage/'. $imageName), 'r');
        $bytes2 = fread($image2, filesize(public_path('storage/'. $imageName)));
 
            $results = $client->compareFaces([
                'SimilarityThreshold' => 98,
                'SourceImage' => [
                    'Bytes' => $bytes1
                ],
                'TargetImage' => [
                    'Bytes' => $bytes2
                ],
                ]);
    
        return view('form', ['results' => $results]);
        
    }
}
