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

    /**
     * Handle image upload for TinyMCE
     */
    public function tinymceUpload(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                // Generate unique filename
                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                
                // Create directory if it doesn't exist
                $uploadPath = 'uploads/blog/content';
                if (!Storage::disk('public')->exists($uploadPath)) {
                    Storage::disk('public')->makeDirectory($uploadPath);
                }
                
                // Store the file
                $path = $file->storeAs($uploadPath, $filename, 'public');
                
                // Return JSON response for TinyMCE with proper structure
                return response()->json([
                    'location' => asset('storage/' . $path),  // Use asset helper for full URL
                    'size' => $file->getSize(),
                    'name' => $filename,
                    'type' => $file->getMimeType()
                ], 200, [
                    'Content-Type' => 'application/json'
                ]);
            }

            return response()->json([
                'error' => 'No file was uploaded'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'File upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}