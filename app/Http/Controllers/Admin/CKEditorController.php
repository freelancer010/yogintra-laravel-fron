<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CKEditorController extends Controller
{
    /**
     * Handle image upload for CKEditor
     */
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                
                // Generate unique filename
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                $uploadPath = 'uploads/blog/content';
                if (!Storage::disk('public')->exists($uploadPath)) {
                    Storage::disk('public')->makeDirectory($uploadPath);
                }
                
                // Store the file
                $path = $file->storeAs($uploadPath, $filename, 'public');
                
                // Return JSON response for CKEditor
                return response()->json([
                    'url' => Storage::url($path),
                    'uploaded' => true,
                    'fileName' => $filename
                ]);
            }

            return response()->json([
                'error' => [
                    'message' => 'No file was uploaded'
                ]
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'error' => [
                    'message' => 'File upload failed: ' . $e->getMessage()
                ]
            ], 500);
        }
    }
}