<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{

    public function index()
    {
        $services = DB::table('service')
            ->join('service_category', 'service_category.service_cat_id', '=', 'service.service_category')
            ->select('service.*', 'service_category.service_cat_name')
            ->get();

        return view('admin.service.all_service', compact('services'));
    }

    public function serviceCategory()
    {
        $data['title'] = 'Service Category';
        $data['categories'] = DB::table('service_category')->get();

        return view('admin.service.service_category', $data);
    }

    public function addCategory(Request $request)
    {
        $request->validate([
            'service_cat_name' => 'required|string|max:255',
            'service_cat_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('service_cat_image')) {
            $file = $request->file('service_cat_image');
            $imagePath = 'uploads/' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), basename($imagePath));
        }

        DB::table('service_category')->insert([
            'service_cat_name' => $request->service_cat_name,
            'service_cat_slug' => Str::slug($request->service_cat_name),
            'page_title' => $request->page_title,
            'page_meta_title' => $request->page_meta_title,
            'page_Slug' => $request->page_Slug,
            'page_keywords' => $request->page_keywords,
            'page_meta_description' => $request->page_meta_description,
            'service_cat_image' => $imagePath,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    public function editCategory($id)
    {
        $category = DB::table('service_category')->where('service_cat_id', $id)->first();
        return view('admin.service.edit_category', compact('category'));
    }

    public function deleteCategory($id)
    {
        $category = DB::table('service_category')->where('service_cat_id', $id)->first();
        if ($category && file_exists(public_path($category->service_cat_image))) {
            unlink(public_path($category->service_cat_image));
        }

        DB::table('service_category')->where('service_cat_id', $id)->delete();

        return redirect()->back()->with('success', 'Category deleted successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_price' => 'nullable|numeric',
            'service_capacity' => 'nullable|integer',
            'service_duration' => 'nullable|integer',
            'service_category' => 'required|integer',
        ]);

        $service = DB::table('service')->where('service_id', $id)->first();

        if (!$service) {
            return redirect()->route('admin.service.index')->with('error', 'Service not found');
        }

        $data = [
            'service_name' => $request->service_name,
            'service_price' => $request->service_price,
            'service_capacity' => $request->service_capacity,
            'service_duration' => $request->service_duration,
            'service_description' => $request->service_description,
            'service_category' => $request->service_category,
            'service_slug' => strtolower(str_replace(' ', '-', $request->service_name)),
        ];

        // Handle image upload
        if ($request->hasFile('service_image')) {
            $image = $request->file('service_image');
            $filename = 'uploads/' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), basename($filename));

            // Remove old image
            if (!empty($service->service_image) && file_exists(public_path($service->service_image))) {
                unlink(public_path($service->service_image));
            }

            $data['service_image'] = $filename;
        }

        DB::table('service')->where('service_id', $id)->update($data);

        return redirect()->route('admin.service.index')->with('success', 'Service updated successfully');
    }


    public function create()
    {
        $categories = DB::table('service_category')->get();

        return view('admin.service.add_service', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'service_category' => 'required|integer',
            'service_price' => 'nullable|numeric',
            'service_capacity' => 'nullable|integer',
            'service_duration' => 'nullable|integer',
            'service_description' => 'nullable|string',
            'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $data = [
            'service_name' => $request->service_name,
            'service_slug' => Str::slug($request->service_name),
            'service_category' => $request->service_category,
            'service_price' => $request->service_price,
            'service_capacity' => $request->service_capacity,
            'service_duration' => $request->service_duration,
            'service_description' => $request->service_description,
        ];

        // Handle file upload
        if ($request->hasFile('service_image')) {
            $image = $request->file('service_image');
            $filename = 'uploads/' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), basename($filename));
            $data['service_image'] = $filename;
        }

        DB::table('service')->insert($data);

        return redirect()->route('admin.service.index')->with('success', 'Service added successfully!');
    }

    public function edit($id)
    {
        $service = DB::table('service')->where('service_id', $id)->first();
        $categories = DB::table('service_category')->get();

        if (!$service) {
            return redirect()->route('admin.service.index')->with('error', 'Service not found');
        }

        return view('admin.service.edit_service', compact('service', 'categories'));
    }

}