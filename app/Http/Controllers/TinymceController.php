<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TinymceController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = 'uploads/' . Str::random(10) . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), basename($filename));

            return response()->json(['location' => asset($filename)]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}