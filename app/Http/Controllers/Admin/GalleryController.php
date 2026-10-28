<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\OptimizedImageUpload;

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
        $request->validate([
            'gallery_category' => 'required|integer',
            'gallery_is_video_or_image' => 'required|in:1,2',
            'gallery_image' => 'required_if:gallery_is_video_or_image,1|nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'gallery_video' => 'required_if:gallery_is_video_or_image,2|nullable|string|max:1000',
            'gallery_image_alt' => 'nullable|string|max:255',
            'gallery_image_title' => 'nullable|string|max:255',
        ]);

        $data = [
            'gallery_category' => $request->gallery_category,
            'gallery_is_video_or_image' => $request->gallery_is_video_or_image,
            'gallery_video' => '', // Default empty string
            'gallery_image' => '', // Default empty string
            'gallery_image_alt' => $request->filled('gallery_image_alt') ? trim($request->gallery_image_alt) : null,
            'gallery_image_title' => $request->filled('gallery_image_title') ? trim($request->gallery_image_title) : null,
        ];

        if ($request->gallery_is_video_or_image == '1') { // Image
            if ($request->hasFile('gallery_image')) {
                $data['gallery_image'] = app(OptimizedImageUpload::class)->store($request->file('gallery_image'));
            }
        } else if ($request->gallery_is_video_or_image == '2') { // Video
            $data['gallery_video'] = $request->gallery_video;
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
        $request->validate([
            'gallery_category' => 'required|integer',
            'gallery_is_video_or_image' => 'required|in:1,2',
            'gallery_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'gallery_video' => 'required_if:gallery_is_video_or_image,2|nullable|string|max:1000',
            'gallery_image_alt' => 'nullable|string|max:255',
            'gallery_image_title' => 'nullable|string|max:255',
        ]);

        $data = [
            'gallery_category' => $request->gallery_category,
            'gallery_is_video_or_image' => $request->gallery_is_video_or_image,
            'gallery_image_alt' => $request->filled('gallery_image_alt') ? trim($request->gallery_image_alt) : null,
            'gallery_image_title' => $request->filled('gallery_image_title') ? trim($request->gallery_image_title) : null,
        ];

        if ($request->gallery_is_video_or_image == 1) { // Image mode
            $data['gallery_video'] = '';
            // handle image upload...
            if ($request->hasFile('gallery_image')) {
                $data['gallery_image'] = app(OptimizedImageUpload::class)->store($request->file('gallery_image'));
            }
        } else { // Video mode
            $data['gallery_video'] = $request->gallery_video;
            // Optionally clear image if needed
            // $data['gallery_image'] = '';
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
