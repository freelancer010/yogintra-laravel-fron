<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class LandingPageController extends Controller
{
    public function index()
    {
        $pages = DB::table('new_landing_page')->get();
        return view('admin.landing_page.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.landing_page.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'page_title' => 'nullable|string',
            'page_meta_description' => 'nullable|string',
            'page_meta_title' => 'nullable|string',
            'page_keywords' => 'nullable|string',
            'page_head_code' => 'nullable|string',
            'page_image_title' => 'nullable|string',
            'page_image_description' => 'nullable|string',
            'page_content' => 'nullable|string',
            'page_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5000',
        ]);

        $data = $request->only([
            'page_name', 'page_title', 'page_meta_description', 'page_meta_title',
            'page_keywords', 'page_head_code', 'page_image_title', 'page_image_description', 'page_content'
        ]);

        $data['page_slug'] = Str::slug($request->page_name);

        if ($request->hasFile('page_image')) {
            $image = $request->file('page_image');
            $filename = 'uploads/' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), basename($filename));
            $data['page_image'] = $filename;
        }

        DB::table('new_landing_page')->insert($data);

        return redirect()->route('admin.landing-pages.index')->with('success', 'Page added successfully.');
    }

    public function edit($id)
    {
        $page = DB::table('new_landing_page')->where('page_id', $id)->first();
        return view('admin.landing_page.edit', compact('page'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'page_title' => 'required|string|max:255',
            'page_meta_description' => 'nullable|string',
            'page_meta_title' => 'nullable|string',
            'page_keywords' => 'nullable|string',
            'page_image_title' => 'required|string|max:255',
            'page_image_description' => 'required|string|max:255',
            'page_head_code' => 'nullable|string',
            'page_content' => 'nullable|string',
            'page_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5000',
        ]);

        $page = DB::table('new_landing_page')->where('page_id', $id)->first();

        $data = [
            'page_name' => $request->page_name,
            'page_title' => $request->page_title,
            'page_slug' => Str::slug($request->page_name),
            'page_meta_description' => $request->page_meta_description ?? '',
            'page_meta_title' => $request->page_meta_title ?? '',
            'page_keywords' => $request->page_keywords ?? '',
            'page_image_title' => $request->page_image_title,
            'page_image_description' => $request->page_image_description,
            'page_head_code' => $request->page_head_code ?? '',
            'page_content' => $request->page_content ?? '',
        ];

        // Handle Image Upload
        if ($request->hasFile('page_image')) {
            if ($page && file_exists(public_path($page->page_image))) {
                unlink(public_path($page->page_image));
            }

            $image = $request->file('page_image');
            $filename = 'uploads/' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), basename($filename));
            $data['page_image'] = $filename;
        }

        DB::table('new_landing_page')->where('page_id', $id)->update($data);

        return redirect()->route('admin.landing-pages.index')->with('success', 'Landing page updated successfully.');
    }



    public function destroy($id)
    {
        $page = DB::table('new_landing_page')->where('page_id', $id)->first();

        if ($page && File::exists(public_path($page->page_image))) {
            File::delete(public_path($page->page_image));
        }

        DB::table('new_landing_page')->where('page_id', $id)->delete();

        return redirect()->route('admin.landing-pages.index')->with('success', 'Page deleted successfully.');
    }
}
