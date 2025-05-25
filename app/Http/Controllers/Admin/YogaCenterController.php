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
            'center_country' => 'required|string',
            'center_state' => 'required|string',
            'center_city' => 'required|string',
            'center_address' => 'required|string',
            'center_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5000',
        ]);

        $originalString = $request->map_link;
        $modifiedString = str_replace('width="600" height="450"', 'width="440" height="200"', $originalString);

        $data = [
            'center_name' => $request->center_name,
            'center_slug' => Str::slug($request->center_name),
            'center_description' => $request->center_description,
            'center_country' => $request->center_country,
            'center_state' => $request->center_state,
            'center_city' => $request->center_city,
            'center_address' => $request->center_address,
            'map_link' => $modifiedString,
            'page_title' => $request->page_title,
            'page_meta_title' => $request->page_meta_title,
            'page_Slug' => $request->page_Slug,
            'page_keywords' => $request->page_keywords,
            'page_meta_description' => $request->page_meta_description,
            'mobile_number' => $request->mobile_number,
            'email_address' => $request->email_address,
        ];

        if ($request->hasFile('center_image')) {
            $image = $request->file('center_image');
            $filename = 'uploads/' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), basename($filename));
            $data['center_image'] = $filename;
        }
        
        $data['center_sec_pdf'] = '';

        DB::table('yoga_center')->insert($data);

        return redirect()->route('admin.yoga_centers.index')->with('success', 'Yoga center added successfully.');
    }

    public function edit($id)
    {
        $center = DB::table('yoga_center')->where('center_id', $id)->first();

        if (!$center) {
            return redirect()->route('admin.yoga_center.index')->with('error', 'Center not found.');
        }

        return view('admin.yoga_center.edit_center', compact('center'));
    }

    public function destroy($id)
    {
        $center = DB::table('yoga_center')->where('center_id', $id)->first();

        if ($center) {
            // Delete image if exists
            if ($center->center_image && file_exists(public_path($center->center_image))) {
                unlink(public_path($center->center_image));
            }

            DB::table('yoga_center')->where('center_id', $id)->delete();

            return redirect()->route('admin.yoga_centers.index')->with('success', 'Yoga Center deleted successfully.');
        }

        return redirect()->back()->with('error', 'Yoga Center not found.');
    }

}