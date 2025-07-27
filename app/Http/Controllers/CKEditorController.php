<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $path = $file->store('uploads/ckeditor', 'public');

            return response()->json([
                'url' => asset('storage/'.$path),
            ]);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }
}
