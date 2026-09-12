<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use App\Models\LandingPageSection;
use Illuminate\Validation\Rule;

class LandingPageController extends Controller
{
    public function index()
    {
        $pages = DB::table('new_landing_page')->get();
        return view('admin.landing_page.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.landing_page.create', ['sections' => collect()]);
    }

    /** Create a minimal draft from the listing modal, then open the full builder. */
    public function start(Request $request)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'page_slug' => ['nullable', 'string', 'max:500', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'unique:new_landing_page,page_slug'],
            'page_meta_title' => 'nullable|string|max:500',
        ]);

        $slug = $request->page_slug ?: Str::slug($request->page_name);
        $pageId = DB::table('new_landing_page')->insertGetId([
            'page_name' => $request->page_name,
            'page_title' => $request->page_name,
            'page_slug' => $slug,
            'page_meta_description' => '',
            'page_meta_title' => $request->page_meta_title ?: $request->page_name,
            'page_keywords' => '',
            'page_head_code' => '',
            'page_image' => 'uploads/1681071409default-profile.png',
            'page_image_title' => $request->page_name,
            'page_image_description' => '',
            'page_content' => '',
        ]);

        return redirect()->route('admin.landing-pages.edit', $pageId)
            ->with('success', 'Draft created. Add sections to build the page.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'page_slug' => ['nullable', 'string', 'max:500', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'unique:new_landing_page,page_slug'],
            'page_meta_description' => 'nullable|string',
            'page_meta_title' => 'nullable|string',
            'page_keywords' => 'nullable|string',
            'page_head_code' => 'nullable|string',
            'page_image_title' => 'nullable|string',
            'page_image_description' => 'nullable|string',
            'page_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5000',
            'sections' => 'nullable|array',
            'sections.*.section_type' => 'required|in:text,image_text,cta',
            'sections.*.heading' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
            'sections.*.button_text' => 'nullable|string|max:100',
            'sections.*.button_url' => 'nullable|url|max:500',
            'sections.*.background_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.image_position' => 'nullable|in:left,right',
            'sections.*.padding_y' => 'nullable|integer|min:0|max:160',
            'sections.*.margin_y' => 'nullable|integer|min:0|max:120',
        ]);

        $data = $request->only([
            'page_name', 'page_meta_description', 'page_meta_title',
            'page_keywords', 'page_head_code', 'page_image_title', 'page_image_description'
        ]);

        // Legacy column: sections are the new content source for builder pages.
        $data['page_content'] = '';

        $data['page_slug'] = $request->page_slug ?: Str::slug($request->page_name);
        $data['page_title'] = $request->page_name;

        if ($request->hasFile('page_image')) {
            $image = $request->file('page_image');
            $filename = 'uploads/' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), basename($filename));
            $data['page_image'] = $filename;
        }

        $pageId = DB::table('new_landing_page')->insertGetId($data);
        $this->saveSections($request, $pageId);

        return redirect()->route('admin.landing-pages.index')->with('success', 'Page added successfully.');
    }

    public function edit($id)
    {
        $page = DB::table('new_landing_page')->where('page_id', $id)->first();
        $sections = LandingPageSection::where('landing_page_id', $id)->orderBy('sort_order')->get();
        return view('admin.landing_page.edit', compact('page', 'sections'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'page_slug' => ['required', 'string', 'max:500', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('new_landing_page', 'page_slug')->ignore($id, 'page_id')],
            'page_meta_description' => 'nullable|string',
            'page_meta_title' => 'nullable|string',
            'page_keywords' => 'nullable|string',
            'page_image_title' => 'nullable|string|max:255',
            'page_image_description' => 'nullable|string',
            'page_head_code' => 'nullable|string',
            'page_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5000',
            'sections' => 'nullable|array',
            'sections.*.section_type' => 'required|in:text,image_text,cta',
            'sections.*.heading' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
            'sections.*.button_text' => 'nullable|string|max:100',
            'sections.*.button_url' => 'nullable|url|max:500',
            'sections.*.background_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.image_position' => 'nullable|in:left,right',
            'sections.*.padding_y' => 'nullable|integer|min:0|max:160',
            'sections.*.margin_y' => 'nullable|integer|min:0|max:120',
        ]);

        $page = DB::table('new_landing_page')->where('page_id', $id)->first();

        $data = [
            'page_name' => $request->page_name,
            'page_title' => $request->page_name,
            'page_slug' => $request->page_slug,
            'page_meta_description' => $request->page_meta_description ?? '',
            'page_meta_title' => $request->page_meta_title ?? '',
            'page_keywords' => $request->page_keywords ?? '',
            'page_image_title' => $request->page_image_title,
            'page_image_description' => $request->page_image_description,
            'page_head_code' => $request->page_head_code ?? '',
        ];

        // Do not erase content created with the legacy editor when editing an old page.
        if ($request->has('page_content')) {
            $data['page_content'] = $request->page_content ?? '';
        }

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
        LandingPageSection::where('landing_page_id', $id)->delete();
        $this->saveSections($request, $id);

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

    private function saveSections(Request $request, int $pageId): void
    {
        foreach ($request->input('sections', []) as $order => $section) {
            $imagePath = $section['existing_image'] ?? null;

            if ($request->hasFile("sections.$order.image")) {
                $image = $request->file("sections.$order.image");
                File::ensureDirectoryExists(public_path('uploads/landing-pages'));
                $filename = uniqid().'_'.$image->getClientOriginalName();
                $image->move(public_path('uploads/landing-pages'), $filename);
                $imagePath = 'uploads/landing-pages/'.$filename;
            }

            LandingPageSection::create([
                'landing_page_id' => $pageId,
                'section_type' => $section['section_type'],
                'heading' => $section['heading'] ?? null,
                'content' => $section['content'] ?? null,
                'image' => $imagePath,
                'image_alt' => $section['image_alt'] ?? null,
                'button_text' => $section['button_text'] ?? null,
                'button_url' => $section['button_url'] ?? null,
                'background_color' => $section['background_color'] ?? null,
                'image_position' => $section['image_position'] ?? 'left',
                'padding_y' => $section['padding_y'] ?? 48,
                'margin_y' => $section['margin_y'] ?? 0,
                'sort_order' => $order,
            ]);
        }
    }
}
