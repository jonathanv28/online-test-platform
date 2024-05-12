<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    public function getFile(Request $request, $filename)
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized access.');
        }
    
        // Assuming the filename is stored in the user's `photo` field
        $user = auth()->user();
        if ($user->photo !== $filename) {
            abort(403, 'Unauthorized access.');
        }
    
        $filePath = 'users/' . $filename; // Construct the path
        $disk = Storage::disk('s3');
    
        if ($disk->exists($filePath)) {
            $fileContents = $disk->get($filePath);
            $mimeType = $disk->mimeType($filePath);
            return response($fileContents, 200)->header('Content-Type', $mimeType);
        } else {
            abort(404, 'File not found.');
        }
    }
    
}
