<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class YogaCenterController extends Controller
{
    public function index()
    {
        $centers = DB::table('yoga_center')->get();
        return view('admin.yoga_center.index', compact('centers'));
    }

    public function create()
    {
        return view('admin.yoga_center.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'center_name' => 'required|string|max:255',
            'center_description' => 'nullable|string',
            'center_country' => 'required|string',
            'center_state' => 'required|string',
            'center_city' => 'required|string',
            'center_address' => 'required|string',
            'map_link' => 'nullable|string',
            'page_title' => 'nullable|string|max:255',
            'page_meta_title' => 'nullable|string|max:255',
            'page_Slug' => 'nullable|string|max:255',
            'page_keywords' => 'nullable|string',
            'page_meta_description' => 'nullable|string',
            'mobile_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',
            'center_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
        ]);

        $data = $request->only([
            'center_name', 'center_description', 'center_country', 'center_state',
            'center_city', 'center_address', 'page_title', 'page_meta_title',
            'page_Slug', 'page_keywords', 'page_meta_description',
            'mobile_number', 'email_address'
        ]);

        $data['center_slug'] = Str::slug($request->center_name);
        $data['map_link'] = str_replace('width="600" height="450"', 'width="440" height="200"', $request->map_link);

        if ($request->hasFile('center_image')) {
            $image = $request->file('center_image');
            $filename = 'uploads/' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), basename($filename));
            $data['center_image'] = $filename;
        }

        DB::table('yoga_center')->insert($data);

        return redirect()->route('admin.yoga_center.index')->with('success', 'Center added successfully');
    }

    public function edit($id)
    {
        $center = DB::table('yoga_center')->where('center_id', $id)->first();
        return view('admin.yoga_center.edit', compact('center'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'center_name' => 'required|string|max:255',
            'center_description' => 'nullable|string',
            'center_country' => 'required|string',
            'center_state' => 'required|string',
            'center_city' => 'required|string',
            'center_address' => 'required|string',
            'map_link' => 'nullable|string',
            'page_title' => 'nullable|string|max:255',
            'page_meta_title' => 'nullable|string|max:255',
            'page_Slug' => 'nullable|string|max:255',
            'page_keywords' => 'nullable|string',
            'page_meta_description' => 'nullable|string',
            'mobile_number' => 'nullable|string|max:20',
            'email_address' => 'nullable|email|max:255',
            'center_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5000',
        ]);

        $data = $request->only([
            'center_name', 'center_description', 'center_country', 'center_state',
            'center_city', 'center_address', 'page_title', 'page_meta_title',
            'page_Slug', 'page_keywords', 'page_meta_description',
            'mobile_number', 'email_address'
        ]);

        $data['center_slug'] = Str::slug($request->center_name);
        $data['map_link'] = str_replace('width="600" height="450"', 'width="440" height="200"', $request->map_link);

        if ($request->hasFile('center_image')) {
            $center = DB::table('yoga_center')->where('center_id', $id)->first();
            if ($center && file_exists(public_path($center->center_image))) {
                unlink(public_path($center->center_image));
            }

            $image = $request->file('center_image');
            $filename = 'uploads/' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), basename($filename));
            $data['center_image'] = $filename;
        }

        DB::table('yoga_center')->where('center_id', $id)->update($data);

        return redirect()->route('admin.yoga_center.index')->with('success', 'Center updated successfully');
    }

    public function destroy($id)
    {
        $center = DB::table('yoga_center')->where('center_id', $id)->first();
        if ($center && file_exists(public_path($center->center_image))) {
            unlink(public_path($center->center_image));
        }

        DB::table('yoga_center')->where('center_id', $id)->delete();

        return redirect()->route('admin.yoga_center.index')->with('success', 'Center deleted successfully');
    }
}