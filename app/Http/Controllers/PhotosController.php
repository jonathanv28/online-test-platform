<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Aws\Rekognition\RekognitionClient;

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
        $image2 = fopen($request->file('photo2')->getPathName(), 'r');
        $bytes2 = fread($image2, $request->file('photo2')->getSize());
    
            // $results = $client->detectFaces([
            //     'Image' => [
            //         'Bytes' => $bytes],
            //         'MinConfidence' => intval($request->input('confidence'))
            //     ]);

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
