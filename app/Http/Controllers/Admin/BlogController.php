<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Models\BlogCategory;
use App\Models\Blog;
use App\Models\Setting;


class BlogController extends Controller
{
    public function index()
    {
        $data['get_all_blog'] = Blog::with('category')->orderBy('blog_id', 'desc')->get();

        return view('admin.blog.view', $data);
    }

    // Show all blog categories
    public function blogCategory()
    {
        $data['title'] = "Blog Category";
        $data['app_setting'] = Setting::first();
        $data['get_all_blog_category'] = BlogCategory::all();

        return view('admin.blog.blog_category', $data);
    }

    // Store a new category
    public function storeCategory(Request $request)
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
    public function editCategory(BlogCategory $blog_category)
    {
        $data['category'] = $blog_category;

        return view('admin.blog.edit_blog_category', $data);
    }

    // Update the category
    public function updateCategory(Request $request, BlogCategory $blog_category)
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
    public function destroyCategory(BlogCategory $blog_category)
    {
        $blog_category->delete();

        Session::flash('success', 'Category Successfully Deleted');
        return redirect()->route('admin.blog.category');
    }

    public function create()
    {
        $data['get_all_blog_category'] = BlogCategory::all();
        return view('admin.blog.add_new_post', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'blog_title' => 'required|string|max:255',
            'blog_author' => 'nullable|string|max:255',
            'blog_short_description' => 'nullable|string',
            'blog_meta_keywords' => 'nullable|string',
            'blog_meta_description' => 'nullable|string|max:160',
            'blog_content' => 'nullable|string',
            'blog_category' => 'required|exists:blog_category,id',
            'blog_image' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:20480',
        ]);

        $imagePath = null;
        if ($request->hasFile('blog_image')) {
            $image = $request->file('blog_image');
            $filename = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/blogs'), $filename);
            $imagePath = 'uploads/blogs/' . $filename;
        }

        Blog::create([
            'blog_title' => $request->blog_title,
            'blog_slug' => \Str::slug($request->blog_title),
            'blog_meta_keywords' => $request->blog_meta_keywords,
            'blog_meta_description' => $request->blog_meta_description,
            'blog_short_description' => $request->blog_short_description,
            'blog_author' => $request->blog_author,
            'blog_content' => $request->blog_content,
            'blog_category' => $request->blog_category,
            'blog_image' => $imagePath,
            'created_at' => now(),
            'status' => 1,
            'blog_view' => 0,
            'blog_like' => 0,
            'blog_dislike' => 0,
            'blog_love' => 0,
            'blog_wow' => 0,
            'blog_funny' => 0,
            'blog_angry' => 0,
        ]);

        \Session::flash('success', 'Post Successfully Added');
        return redirect()->route('admin.blog.index');
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return redirect()->back()->with('error', 'Blog post not found.');
        }

        $blog->delete();

        return redirect()->back()->with('success', 'Blog post deleted successfully.');
    }

    
    public function edit($id)
    {
        $data['blog'] = Blog::findOrFail($id);
        $data['get_all_blog_category'] = BlogCategory::all();

        return view('admin.blog.edit', $data);
    }

    public function update(Request $request, $id)
    {


        $request->validate([
            'blog_title' => 'required|string|max:255',
            'blog_author' => 'nullable|string|max:255',
            'blog_short_description' => 'nullable|string',
            'blog_meta_keywords' => 'nullable|string',
            'blog_meta_description' => 'nullable|string|max:160',
            'blog_content' => 'nullable|string',
            'blog_category' => 'required|exists:blog_category,id',
            'blog_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:20480',
        ]);

        $blog = Blog::findOrFail($id);

        if ($request->hasFile('blog_image')) {
            if ($blog->blog_image && file_exists(public_path($blog->blog_image))) {
                @unlink(public_path($blog->blog_image));
            }

            $image = $request->file('blog_image');
            $filename = uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/blogs'), $filename);
            $blog->blog_image = 'uploads/blogs/' . $filename;
        }

        $blog->blog_title = $request->blog_title;
        $blog->blog_slug = \Str::slug($request->blog_title);
        $blog->blog_author = $request->blog_author;
        $blog->blog_short_description = $request->blog_short_description;
        $blog->blog_meta_keywords = $request->blog_meta_keywords;
        $blog->blog_meta_description = $request->blog_meta_description;
        $blog->blog_content = $request->blog_content;
        $blog->blog_category = $request->blog_category;
        // $blog->updated_at = now();

        $blog->save();

        return redirect()->route('admin.blog.index')->with('success', 'Blog updated successfully!');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/uploads', $filename);

            return response()->json([
                'url' => asset('storage/uploads/' . $filename)
            ]);
        }

        return response()->json(['error' => 'No file uploaded.'], 400);
    }

}
