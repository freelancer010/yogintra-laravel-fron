<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BlogCategory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Models\Setting;

class BlogController extends Controller
{
    // Show all blog categories
    public function blogCategory()
    {
        $data['title'] = "Blog Category";
        $data['app_setting'] = Setting::first();
        $data['get_all_blog_category'] = BlogCategory::all();

        return view('admin.blog.blog_category', $data);
    }

    // Store a new category
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        BlogCategory::create([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name),
            'category_keyword' => $request->category_keyword,
            'category_description' => $request->category_description,
        ]);

        Session::flash('success', 'Category Successfully Added');
        return redirect()->route('admin.blog.category');
    }

    // Show edit form
    public function edit(BlogCategory $blog_category)
    {
        $data['title'] = "Edit Blog Category";
        $data['app_setting'] = Setting::first();
        $data['category'] = $blog_category;

        return view('admin.blog.edit_blog_category', $data);
    }

    // Update the category
    public function update(Request $request, BlogCategory $blog_category)
    {
        $request->validate([
            'category_name' => 'required',
        ]);

        $blog_category->update([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name),
            'category_keyword' => $request->category_keyword,
            'category_description' => $request->category_description,
        ]);

        Session::flash('success', 'Category Successfully Updated');
        return redirect()->route('admin.blog.category');
    }

    // Delete a category
    public function destroy(BlogCategory $blog_category)
    {
        $blog_category->delete();

        Session::flash('success', 'Category Successfully Deleted');
        return redirect()->route('admin.blog.category');
    }
}
