<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
            Log::info('TinyMCE Upload Request Headers:', $request->headers->all());
            Log::info('TinyMCE Upload Files:', $request->allFiles());

            if (!$request->hasFile('file')) {
                Log::error('TinyMCE: No file in request');
                return response()->json(['error' => 'No file uploaded'], 400);
            }

            $file = $request->file('file');

            // Basic file validation
            if (!$file->isValid()) {
                Log::error('TinyMCE: Invalid file upload');
                return response()->json(['error' => 'Invalid file upload'], 400);
            }

            // Validate file type and size
            $validator = Validator::make(['file' => $file], [
                'file' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);

            if ($validator->fails()) {
                Log::error('TinyMCE: File validation failed - ' . $validator->errors()->first());
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            // Prepare upload path in public directory
            $uploadPath = public_path('uploads/blog/content');
            
            try {
                if (!file_exists($uploadPath)) {
                    Log::info('TinyMCE: Creating upload directory: ' . $uploadPath);
                    if (!mkdir($uploadPath, 0755, true)) {
                        Log::error('TinyMCE: Failed to create upload directory');
                        return response()->json(['error' => 'Server configuration error'], 500);
                    }
                }
            } catch (\Exception $e) {
                Log::error('TinyMCE: Directory creation failed - ' . $e->getMessage());
                return response()->json(['error' => 'Server configuration error'], 500);
            }

            // Generate safe filename
            $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Store file directly in public/uploads
            try {
                $file->move($uploadPath, $filename);
                $relativePath = 'uploads/blog/content/' . $filename;
                
                if (!file_exists(public_path($relativePath))) {
                    Log::error('TinyMCE: File not found after upload: ' . $relativePath);
                    return response()->json(['error' => 'File upload verification failed'], 500);
                }
            } catch (\Exception $e) {
                Log::error('TinyMCE: File move failed - ' . $e->getMessage());
                return response()->json(['error' => 'Failed to store file'], 500);
            }

            // Generate full URL using the public path
            $fullUrl = asset($relativePath);
            
            Log::info('TinyMCE: File uploaded successfully', [
                'path' => $relativePath,
                'url' => $fullUrl,
                'exists' => file_exists(public_path($relativePath))
            ]);

            return response()->json([
                'location' => $fullUrl
            ])->header('Content-Type', 'application/json');

        } catch (\Exception $e) {
            Log::error('TinyMCE upload failed: ' . $e->getMessage());
            return response()->json([
                'error' => 'Upload failed: ' . $e->getMessage()
            ], 500);
        }
    }
}