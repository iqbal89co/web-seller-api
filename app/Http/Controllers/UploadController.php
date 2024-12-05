<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $filename = time() . '-' . $request->file->getClientOriginalName();
        $path = $request->file->storeAs('public/images', $filename);
        $url = Storage::url($path);

        // Return a JSON response with the URL
        return response()->json([
            'message' => 'File uploaded successfully',
            'data' => [
                'url' => url($url)
            ]
        ]);
    }
}
