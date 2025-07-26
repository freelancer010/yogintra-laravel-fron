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

            // Prepare upload path
            $uploadPath = 'uploads/blog/content';
            
            try {
                if (!Storage::disk('public')->exists($uploadPath)) {
                    Log::info('TinyMCE: Creating upload directory: ' . $uploadPath);
                    $created = Storage::disk('public')->makeDirectory($uploadPath, 0755, true);
                    if (!$created) {
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
            
            // Store file
            try {
                $path = $file->storeAs($uploadPath, $filename, 'public');
            } catch (\Exception $e) {
                Log::error('TinyMCE: File storage failed - ' . $e->getMessage());
                return response()->json(['error' => 'Failed to store file'], 500);
            }

            if (!$path) {
                Log::error('TinyMCE: File path empty after storage attempt');
                return response()->json(['error' => 'Failed to store file'], 500);
            }

            // Verify file exists after upload
            if (!Storage::disk('public')->exists($path)) {
                Log::error('TinyMCE: File not found after upload: ' . $path);
                return response()->json(['error' => 'File upload verification failed'], 500);
            }

            // Generate full URL
            $fullUrl = asset('storage/' . $path);
            
            // Verify storage link exists
            $publicPath = public_path('storage');
            if (!file_exists($publicPath)) {
                Log::error('TinyMCE: Storage symlink not found at: ' . $publicPath);
                try {
                    \Artisan::call('storage:link');
                    Log::info('TinyMCE: Created storage symlink');
                } catch (\Exception $e) {
                    Log::error('TinyMCE: Failed to create storage symlink - ' . $e->getMessage());
                    return response()->json(['error' => 'Server configuration error'], 500);
                }
            }
            
            Log::info('TinyMCE: File uploaded successfully', [
                'path' => $path,
                'url' => $fullUrl,
                'exists' => Storage::disk('public')->exists($path),
                'symlink' => file_exists($publicPath)
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