<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    public function index()
    {
        $all_category = DB::table('gallery_category')->get();
        return view('admin.gallery.all_category', compact('all_category'));
    }
}
