<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    // View all categories
    public function index()
    {
        $all_category = DB::table('gallery_category')->get();
        return view('admin.gallery.all_category', compact('all_category'));
    }

    // Store new category
    public function store(Request $request)
    {
        DB::table('gallery_category')->insert([
            'g_cat_name' => $request->g_cat_name
        ]);

        return back()->with('success', 'Category added successfully.');
    }

    // Update category
    public function update(Request $request, $id)
    {
        DB::table('gallery_category')->where('g_cat_id', $id)->update([
            'g_cat_name' => $request->g_cat_name
        ]);

        return back()->with('success', 'Category updated successfully.');
    }

    // Delete category only if not used in gallery
    public function destroy($id)
    {
        $count = DB::table('gallery')->where('gallery_category', $id)->count();

        if ($count > 0) {
            return back()->with('error', 'Cannot delete category in use.');
        }

        DB::table('gallery_category')->where('g_cat_id', $id)->delete();

        return back()->with('success', 'Category deleted successfully.');
    }

    // View all gallery
    public function viewAllGallery()
    {
        $all_data = DB::table('gallery as a')
            ->join('gallery_category as b', 'b.g_cat_id', '=', 'a.gallery_category')
            ->select('a.*', 'b.g_cat_name')
            ->get();

        $all_category = DB::table('gallery_category')->get();

        return view('admin.gallery.view_all_gallery', compact('all_data', 'all_category'));
    }

    // Store new gallery
    public function storeGallery(Request $request)
    {
        $data = [
            'gallery_category' => $request->gallery_category,
            'gallery_video' => $request->gallery_video,
            'gallery_is_video_or_image' => $request->gallery_is_video_or_image,
        ];

        if ($request->hasFile('gallery_image')) {
            $file = $request->file('gallery_image');
            $filename = 'uploads/' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['gallery_image'] = $filename;
        }

        DB::table('gallery')->insert($data);
        return back()->with('success', 'Gallery added successfully.');
    }

    // Edit gallery view
    public function editGallery($id)
    {
        $gallery = DB::table('gallery')->where('gallery_id', $id)->first();
        $all_category = DB::table('gallery_category')->get();

        return view('admin.gallery.edit_gallery', compact('gallery', 'all_category'));
    }

    // Update gallery
    public function updateGallery(Request $request, $id)
    {
        $data = [
            'gallery_category' => $request->gallery_category,
            'gallery_video' => $request->gallery_video,
            'gallery_is_video_or_image' => $request->gallery_is_video_or_image,
        ];

        if ($request->hasFile('gallery_image')) {
            $old = DB::table('gallery')->where('gallery_id', $id)->first();
            if ($old && file_exists(public_path($old->gallery_image))) {
                unlink(public_path($old->gallery_image));
            }
            $file = $request->file('gallery_image');
            $filename = 'uploads/' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['gallery_image'] = $filename;
        }

        DB::table('gallery')->where('gallery_id', $id)->update($data);
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery updated successfully.');
    }

    // Delete gallery
    public function deleteGallery($id)
    {
        $gallery = DB::table('gallery')->where('gallery_id', $id)->first();

        if ($gallery && file_exists(public_path($gallery->gallery_image))) {
            unlink(public_path($gallery->gallery_image));
        }

        DB::table('gallery')->where('gallery_id', $id)->delete();

        return back()->with('success', 'Gallery deleted successfully.');
    }
}
