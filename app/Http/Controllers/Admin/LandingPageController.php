<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use App\Models\LandingPageSection;
use App\Services\OptimizedImageUpload;
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
            ->with('success', 'Draft created with the editable Default layout.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'page_slug' => ['nullable', 'string', 'max:500', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', 'unique:new_landing_page,page_slug'],
            'page_meta_description' => 'nullable|string|max:150',
            'page_meta_title' => 'nullable|string',
            'page_keywords' => 'nullable|string',
            'page_head_code' => 'nullable|string',
            'use_classic_layout' => 'nullable|boolean',
            'page_image_title' => 'nullable|string',
            'page_image_description' => 'nullable|string',
            'page_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5000',
            'sections' => 'nullable|array',
            'sections.*.section_type' => 'required|in:text,image,image_text,feature_grid,trainer_slider,custom_columns,cta,testimonial,faq',
            'sections.*.heading' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
            'sections.*.image_alt' => 'nullable|string|max:255',
            'sections.*.image_crop' => 'nullable|in:original,1:1,4:3,16:9,3:4',
            'sections.*.image_focal_x' => 'nullable|integer|min:0|max:100',
            'sections.*.image_focal_y' => 'nullable|integer|min:0|max:100',
            'sections.*.button_text' => 'nullable|string|max:100',
            'sections.*.button_url' => 'nullable|url|max:500',
            'sections.*.background_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.background_mode' => 'nullable|in:color,image',
            'sections.*.background_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
            'sections.*.background_position' => 'nullable|in:left,center,right,top,bottom',
            'sections.*.background_parallax' => 'nullable|boolean',
            'sections.*.background_overlay_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.background_overlay_opacity' => 'nullable|integer|min:0|max:90',
            'sections.*.image_position' => 'nullable|in:left,right',
            'sections.*.image_size' => 'nullable|integer|min:20|max:100',
            'sections.*.padding_x' => 'nullable|integer|min:0|max:160',
            'sections.*.padding_y' => 'nullable|integer|min:0|max:160',
            'sections.*.margin_x' => 'nullable|integer|min:0|max:120',
            'sections.*.margin_y' => 'nullable|integer|min:0|max:120',
            'sections.*.text_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.heading_size' => 'nullable|integer|min:16|max:72',
            'sections.*.description_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.description_size' => 'nullable|integer|min:12|max:36',
            'sections.*.text_align' => 'nullable|in:left,center,right',
            'sections.*.element_styles' => 'nullable|json',
            'sections.*.blocks' => 'nullable|json',
            'sections.*.elements' => 'nullable|json',
            'sections.*.grid_columns' => 'nullable|integer|min:1|max:4',
            'sections.*.card_layout' => 'nullable|in:stacked,icon_left',
            'sections.*.card_alignment' => 'nullable|in:left,center,right',
            'sections.*.grid_gap' => 'nullable|integer|min:0|max:100',
            'sections.*.block_images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
        ], [
            'sections.*.background_image.max' => 'Background image size limit exceeded. Please choose an image smaller than 5 MB, then upload again.',
        ]);

        $data = $request->only([
            'page_name', 'page_meta_description', 'page_meta_title',
            'page_keywords', 'page_head_code', 'page_image_title', 'page_image_description'
        ]);

        // Legacy column: sections are the new content source for builder pages.
        $data['page_content'] = '';

        $data['page_slug'] = $request->page_slug ?: Str::slug($request->page_name);
        $data['page_title'] = $request->page_name;
        // The legacy table requires an image even when a builder page starts as
        // text-only. A real hero image can still be added later in settings.
        $data['page_image'] = 'uploads/1681071409default-profile.png';

        if ($request->hasFile('page_image')) {
            $data['page_image'] = app(OptimizedImageUpload::class)->store($request->file('page_image'));
        }

        $pageId = DB::table('new_landing_page')->insertGetId($data);
        $this->saveSections($request, $pageId);

        return redirect()->route('admin.landing-pages.edit', $pageId)->with('success', 'Page published successfully.');
    }

    public function edit($id)
    {
        $page = DB::table('new_landing_page')->where('page_id', $id)->first();
        abort_unless($page, 404);

        $sections = LandingPageSection::where('landing_page_id', $id)->orderBy('sort_order')->get();

        // An empty canvas is not a useful starting point. Seed every new or
        // legacy empty builder page with the same Classic template used on the
        // public landing pages, so the canvas opens with real editable content.
        if ($sections->isEmpty()) {
            $city = trim((string) ($page->page_name ?: $page->page_slug));
            $this->createClassicSections($id, $city !== '' ? $city : 'your city', (string) ($page->page_content ?? ''));
            DB::table('new_landing_page')->where('page_id', $id)->update(['use_classic_layout' => true]);
            $this->forgetPublicPageCache($page->page_slug);

            $page = DB::table('new_landing_page')->where('page_id', $id)->first();
            $sections = LandingPageSection::where('landing_page_id', $id)->orderBy('sort_order')->get();
        } elseif ($page->use_classic_layout && $this->upgradeClassicTemplateSections($id)) {
            $this->forgetPublicPageCache($page->page_slug);
            $sections = LandingPageSection::where('landing_page_id', $id)->orderBy('sort_order')->get();
        }

        $adminServices = DB::table('our_service')->orderBy('os_id')->get(['os_heading', 'os_image']);

        return view('admin.landing_page.edit', compact('page', 'sections', 'adminServices'));
    }

    /** Toggle whether this city page is accessible on the public site. */
    public function togglePublished(Request $request, $id)
    {
        $request->validate(['is_published' => 'required|boolean']);
        $page = DB::table('new_landing_page')->where('page_id', $id)->first();
        abort_unless($page, 404);

        $isPublished = $request->boolean('is_published');
        DB::table('new_landing_page')->where('page_id', $id)->update(['is_published' => $isPublished]);
        $this->forgetPublicPageCache($page->page_slug);

        return back()->with('success', $isPublished ? 'Landing page is now visible on the public site.' : 'Landing page is now hidden from the public site.');
    }

    /**
     * Turn the fixed Classic template into editable visual-builder sections.
     */
    public function convertClassic($id)
    {
        $page = DB::table('new_landing_page')->where('page_id', $id)->first();
        abort_unless($page, 404);

        if (LandingPageSection::where('landing_page_id', $id)->exists()) {
            return redirect()->route('admin.landing-pages.edit', $id)
                ->with('success', 'This page already has editable sections.');
        }

        $city = trim((string) ($page->page_name ?: $page->page_slug));
        $city = $city !== '' ? $city : 'your city';

        // Do not overwrite an editor's existing SEO work. For old pages that
        // had empty metadata, start with location-specific defaults rather
        // than the same title and description used by every city URL.
        $seoDefaults = [];
        if (blank($page->page_meta_title ?? null)) {
            $seoDefaults['page_meta_title'] = "Yoga Classes in {$city} | YogIntra";
        }
        if (blank($page->page_meta_description ?? null)) {
            $seoDefaults['page_meta_description'] = "Explore personalised yoga classes in {$city} with YogIntra. Find home, online and wellness-focused yoga options for your goals.";
        }
        if (blank($page->page_keywords ?? null)) {
            $seoDefaults['page_keywords'] = "yoga classes {$city}, yoga in {$city}, home yoga {$city}, online yoga {$city}";
        }
        if ($seoDefaults) {
            DB::table('new_landing_page')->where('page_id', $id)->update($seoDefaults);
        }

        $this->createClassicSections($id, $city, (string) ($page->page_content ?? ''));
        DB::table('new_landing_page')->where('page_id', $id)->update(['use_classic_layout' => true]);
        $this->forgetPublicPageCache($page->page_slug);

        return redirect()->route('admin.landing-pages.edit', $id)->with(
            'success',
            'The default Classic layout is now editable in the page builder. Review the content and update the page to publish your changes.'
        );
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'page_name' => 'required|string|max:255',
            'page_slug' => ['required', 'string', 'max:500', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('new_landing_page', 'page_slug')->ignore($id, 'page_id')],
            'page_meta_description' => 'nullable|string|max:150',
            'page_meta_title' => 'nullable|string',
            'page_keywords' => 'nullable|string',
            'page_image_title' => 'nullable|string|max:255',
            'page_image_description' => 'nullable|string',
            'page_head_code' => 'nullable|string',
            'use_classic_layout' => 'nullable|boolean',
            'page_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5000',
            'sections' => 'nullable|array',
            'sections.*.section_type' => 'required|in:text,image,image_text,feature_grid,trainer_slider,custom_columns,cta,testimonial,faq',
            'sections.*.heading' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
            'sections.*.image_alt' => 'nullable|string|max:255',
            'sections.*.image_crop' => 'nullable|in:original,1:1,4:3,16:9,3:4',
            'sections.*.image_focal_x' => 'nullable|integer|min:0|max:100',
            'sections.*.image_focal_y' => 'nullable|integer|min:0|max:100',
            'sections.*.button_text' => 'nullable|string|max:100',
            'sections.*.button_url' => 'nullable|url|max:500',
            'sections.*.background_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.background_mode' => 'nullable|in:color,image',
            'sections.*.background_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
            'sections.*.background_position' => 'nullable|in:left,center,right,top,bottom',
            'sections.*.background_parallax' => 'nullable|boolean',
            'sections.*.background_overlay_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.background_overlay_opacity' => 'nullable|integer|min:0|max:90',
            'sections.*.image_position' => 'nullable|in:left,right',
            'sections.*.image_size' => 'nullable|integer|min:20|max:100',
            'sections.*.padding_x' => 'nullable|integer|min:0|max:160',
            'sections.*.padding_y' => 'nullable|integer|min:0|max:160',
            'sections.*.margin_x' => 'nullable|integer|min:0|max:120',
            'sections.*.margin_y' => 'nullable|integer|min:0|max:120',
            'sections.*.text_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.heading_size' => 'nullable|integer|min:16|max:72',
            'sections.*.description_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.description_size' => 'nullable|integer|min:12|max:36',
            'sections.*.text_align' => 'nullable|in:left,center,right',
            'sections.*.element_styles' => 'nullable|json',
            'sections.*.blocks' => 'nullable|json',
            'sections.*.elements' => 'nullable|json',
            'sections.*.grid_columns' => 'nullable|integer|min:1|max:4',
            'sections.*.card_layout' => 'nullable|in:stacked,icon_left',
            'sections.*.card_alignment' => 'nullable|in:left,center,right',
            'sections.*.grid_gap' => 'nullable|integer|min:0|max:100',
            'sections.*.block_images.*' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
        ], [
            'sections.*.background_image.max' => 'Background image size limit exceeded. Please choose an image smaller than 5 MB, then upload again.',
        ]);

        $page = DB::table('new_landing_page')->where('page_id', $id)->first();

        $data = [
            'page_name' => $request->page_name,
            'page_title' => $request->page_name,
            'page_slug' => $request->page_slug,
            'page_meta_description' => $request->page_meta_description ?? '',
            'page_meta_title' => $request->page_meta_title ?? '',
            'page_keywords' => $request->page_keywords ?? '',
            // These legacy fields are NOT NULL, but are optional in the visual
            // builder settings modal.
            'page_image_title' => $request->page_image_title ?? '',
            'page_image_description' => $request->page_image_description ?? '',
            'page_head_code' => $request->page_head_code ?? '',
            'use_classic_layout' => $request->boolean('use_classic_layout'),
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

            $data['page_image'] = app(OptimizedImageUpload::class)->store($request->file('page_image'));
        }

        DB::table('new_landing_page')->where('page_id', $id)->update($data);
        LandingPageSection::where('landing_page_id', $id)->delete();
        $this->saveSections($request, $id);
        $this->forgetPublicPageCache($page->page_slug);
        $this->forgetPublicPageCache($data['page_slug']);

        return redirect()->route('admin.landing-pages.edit', $id)->with('success', 'Page updated successfully.');
    }



    public function destroy($id)
    {
        $page = DB::table('new_landing_page')->where('page_id', $id)->first();

        if ($page && File::exists(public_path($page->page_image))) {
            File::delete(public_path($page->page_image));
        }

        DB::table('new_landing_page')->where('page_id', $id)->delete();
        if ($page) {
            $this->forgetPublicPageCache($page->page_slug);
        }

        return redirect()->route('admin.landing-pages.index')->with('success', 'Page deleted successfully.');
    }

    private function saveSections(Request $request, int $pageId): void
    {
        foreach ($request->input('sections', []) as $order => $section) {
            $imagePath = $section['existing_image'] ?? null;
            $backgroundImagePath = $section['existing_background_image'] ?? null;

            if ($request->hasFile("sections.$order.image")) {
                $imagePath = app(OptimizedImageUpload::class)->store($request->file("sections.$order.image"), 'uploads/landing-pages');
            }
            if ($request->hasFile("sections.$order.background_image")) {
                $backgroundImagePath = app(OptimizedImageUpload::class)->store($request->file("sections.$order.background_image"), 'uploads/landing-pages');
            }

            $blocks = json_decode($section['blocks'] ?? '[]', true);
            $blocks = is_array($blocks) ? $blocks : [];
            $blockUploads = data_get($request->allFiles(), "sections.$order.block_images", []);
            foreach (is_array($blockUploads) ? $blockUploads : [] as $blockIndex => $blockImage) {
                if (!$blockImage || !$blockImage->isValid()) {
                    continue;
                }
                $blocks[$blockIndex] = $blocks[$blockIndex] ?? [];
                $blocks[$blockIndex]['image'] = app(OptimizedImageUpload::class)->store($blockImage, 'uploads/landing-pages');
            }

            $sectionPayload = [
                'landing_page_id' => $pageId,
                'section_type' => $section['section_type'],
                'heading' => $section['heading'] ?? null,
                'content' => $section['content'] ?? null,
                'image' => $imagePath,
                'image_alt' => $section['image_alt'] ?? null,
                'image_crop' => $section['image_crop'] ?? 'original',
                'image_focal_x' => $section['image_focal_x'] ?? 50,
                'image_focal_y' => $section['image_focal_y'] ?? 50,
                'button_text' => $section['button_text'] ?? null,
                'button_url' => $section['button_url'] ?? null,
                'background_color' => $section['background_color'] ?? null,
                'background_mode' => $section['background_mode'] ?? 'color',
                'background_image' => $backgroundImagePath,
                'background_position' => $section['background_position'] ?? 'center',
                'background_parallax' => !empty($section['background_parallax']),
                'background_overlay_color' => $section['background_overlay_color'] ?? '#000000',
                'background_overlay_opacity' => $section['background_overlay_opacity'] ?? 0,
                'image_position' => $section['image_position'] ?? 'left',
                'image_size' => $section['image_size'] ?? ($section['section_type'] === 'image' ? 100 : 42),
                'padding_x' => $section['padding_x'] ?? 0,
                'padding_y' => $section['padding_y'] ?? 48,
                'margin_x' => $section['margin_x'] ?? 0,
                'margin_y' => $section['margin_y'] ?? 0,
                'text_color' => $section['text_color'] ?? '#183c45',
                'heading_size' => $section['heading_size'] ?? 32,
                'description_color' => $section['description_color'] ?? '#647b82',
                'description_size' => $section['description_size'] ?? 16,
                'text_align' => $section['text_align'] ?? 'left',
                'element_styles' => $section['element_styles'] ?? null,
                'blocks' => $blocks ? json_encode(array_values($blocks)) : ($section['blocks'] ?? null),
                'elements' => $section['elements'] ?? null,
                'grid_columns' => $section['grid_columns'] ?? 3,
                'card_layout' => $section['card_layout'] ?? 'stacked',
                'card_alignment' => $section['card_alignment'] ?? 'center',
                'grid_gap' => $section['grid_gap'] ?? 24,
                'sort_order' => $order,
            ];

            // Deployments can briefly run newer application code before all
            // database migrations have been applied. Keep existing page edits
            // saveable while ignoring only fields absent from that older schema.
            $availableColumns = array_flip(Schema::getColumnListing('landing_page_sections'));
            LandingPageSection::create(array_intersect_key($sectionPayload, $availableColumns));
        }
    }

    private function forgetPublicPageCache(?string $slug): void
    {
        if (filled($slug)) {
            Cache::forget('landing-page.data.' . sha1($slug));
        }
    }

    /** Keep previously seeded Classic canvases aligned with the current editable template. */
    private function upgradeClassicTemplateSections(int $pageId): bool
    {
        $changed = false;
        $aboutHeading = 'About YogIntra';

        if (!LandingPageSection::where('landing_page_id', $pageId)->where('heading', $aboutHeading)->exists()) {
            // Place the About section just after the introduction without
            // disturbing an editor's other section order.
            LandingPageSection::where('landing_page_id', $pageId)->where('sort_order', '>=', 2)->increment('sort_order');
            LandingPageSection::create([
                'landing_page_id' => $pageId,
                'section_type' => 'image_text',
                'heading' => $aboutHeading,
                'content' => '<p>Back in 2011, YogIntra started with a simple thought: to make yoga accessible to everyday people, even with busy schedules. Today, YogIntra is building a community nationally and internationally, helping people of all ages and genders stay healthy, active and connected through yoga.</p><p>The name YogIntra comes from “Yog” and “Intra.” Yog comes from the Sanskrit word “Yuj,” meaning connection or union. Intra refers to something within. Together, YogIntra represents the connection between the soul and the divine within oneself, bringing yoga into everyday life with balance, wellness and inner connection.</p>',
                'image' => 'assets/Square-Logo-with-Name-2-povy7zr4loqk9maa9hbtvdrc77dpfngjngf3wrmp40.webp',
                'image_alt' => 'YogIntra logo',
                'image_position' => 'left',
                'image_size' => 34,
                'background_color' => '#fff7ed',
                'padding_x' => 0,
                'padding_y' => 72,
                'margin_x' => 0,
                'margin_y' => 0,
                'text_color' => '#183c45',
                'heading_size' => 32,
                'description_color' => '#647b82',
                'description_size' => 16,
                'text_align' => 'left',
                'grid_columns' => 3,
                'card_layout' => 'stacked',
                'card_alignment' => 'center',
                'grid_gap' => 24,
                'sort_order' => 2,
            ]);
            $changed = true;
        }

        $faq = LandingPageSection::where('landing_page_id', $pageId)
            ->whereIn('heading', ['Frequently Asked Questions About Yoga Classes in India', 'Frequently Asked Questions'])
            ->orderBy('sort_order')
            ->first();
        $faqPayload = [
            'section_type' => 'custom_columns',
            'heading' => 'Frequently Asked Questions',
            'content' => '',
            'blocks' => json_encode($this->homepageFaqBlocks()),
            'grid_columns' => 1,
            'text_align' => 'center',
            'background_color' => '#f0f7f7',
            'padding_y' => 72,
        ];
        if ($faq && $faq->blocks !== $faqPayload['blocks']) {
            $faq->update($faqPayload);
            $changed = true;
        }

        // Earlier template versions gave the two CTA sections 72–80px of
        // padding above and below. A 64px rhythm keeps the copy and action
        // together while leaving the padding slider fully editable.
        $ctaHeadings = [
            'Yoga Classes in India for a Healthier, More Balanced Life',
            'Ready to Start Your Yoga Journey?',
        ];
        $ctaSections = LandingPageSection::where('landing_page_id', $pageId)->whereIn('heading', $ctaHeadings)->get();
        foreach ($ctaSections as $ctaSection) {
            if (in_array((int) $ctaSection->padding_y, [72, 80], true)) {
                $ctaSection->update(['padding_y' => 64]);
                $changed = true;
            }
        }

        // Apply the Classic template's colour palette only to untouched default
        // headings. Editors can still select any colour in the visual builder.
        $headingPalette = [
            'Yoga Classes in India for a Healthier, More Balanced Life' => '#0d6772',
            'Start where you are. Practice at your pace.' => '#24537f',
            $aboutHeading => '#a75d20',
            'Yoga Services Available Across India' => '#1d63a5',
            'Yoga Classes for Different Needs, Ages & Experience Levels' => '#63469a',
            'Start Your Yoga Journey in 3 Simple Steps' => '#9a6510',
            'Yoga Plans for Different Needs' => '#087560',
            'Frequently Asked Questions' => '#11706e',
            'Ready to Start Your Yoga Journey?' => '#285ca3',
        ];
        foreach (LandingPageSection::where('landing_page_id', $pageId)->whereIn('heading', array_keys($headingPalette))->get() as $section) {
            if (($section->text_color ?: '#183c45') === '#183c45') {
                $section->update(['text_color' => $headingPalette[$section->heading]]);
                $changed = true;
            }
        }

        // Feature-card icons are persisted with their cards, so they are easy
        // to replace from the builder's existing Icon input.
        $sectionIcons = [
            'Yoga Services Available Across India' => ['⌂', '◎', '☘', '↔', '☾', '◷', '♧', '☀'],
            'Yoga Classes for Different Needs, Ages & Experience Levels' => ['☘', '◌'],
            'Benefits of Regular Yoga Practice' => ['♧', '☾', '∞'],
            'Yoga Plans for Different Needs' => ['◇', '◫', '◎'],
        ];
        foreach (LandingPageSection::where('landing_page_id', $pageId)->whereIn('heading', array_keys($sectionIcons))->get() as $section) {
            $blocks = json_decode($section->blocks ?: '[]', true) ?: [];
            $updated = false;
            foreach ($blocks as $index => $block) {
                if (empty($block['image']) && empty($block['icon']) && isset($sectionIcons[$section->heading][$index])) {
                    $blocks[$index]['icon'] = $sectionIcons[$section->heading][$index];
                    $updated = true;
                }
            }
            if ($updated) {
                $section->update(['blocks' => json_encode($blocks)]);
                $changed = true;
            }
        }

        return $changed;
    }

    private function homepageFaqBlocks(): array
    {
        return [
            ['type' => 'empty'],
            ['type' => 'faq', 'question' => 'What is YogIntra?', 'answer' => 'YogIntra offers guided classes, wellness programmes and community events. Each option supports movement, rest and everyday wellbeing.'],
            ['type' => 'faq', 'question' => 'What services does YogIntra provide?', 'answer' => 'Choose from group classes, online and at-home classes, private one-on-one sessions, meditation and breathwork, corporate wellness programmes, and mindfulness workshops.'],
            ['type' => 'faq', 'question' => 'Do YogIntra offer trial classes?', 'answer' => 'Many locations offer trial or introductory packages. Check the current options before you book.'],
            ['type' => 'faq', 'question' => 'Do YogIntra trainers offer personalized programs?', 'answer' => 'Yes. Instructors can tailor a plan around flexibility and strength goals, stress reduction, non-medical recovery support, and lifestyle or mindfulness routines.'],
            ['type' => 'faq', 'question' => 'How can I contact YogIntra?', 'answer' => 'You can contact our team through the website contact form, email, phone, or our social media channels.'],
        ];
    }

    private function createClassicSections(int $pageId, string $city, string $legacyContent = ''): void
    {
        $serviceBlocks = [
            ['icon' => '⌂', 'title' => 'Online Yoga Classes', 'text' => 'Live, instructor-led yoga sessions from the comfort of home.'],
            ['icon' => '◎', 'title' => 'Personalized Yoga Classes', 'text' => 'Practice adapted to your experience, goals, schedule and comfort level.'],
            ['icon' => '☘', 'title' => 'Yoga for Beginners', 'text' => 'Learn foundational poses, breathing, alignment and relaxation progressively.'],
            ['icon' => '↔', 'title' => 'Flexibility & Mobility', 'text' => 'Build body awareness and comfortable movement through a consistent practice.'],
            ['icon' => '☾', 'title' => 'Stress Management', 'text' => 'Make dedicated time for mindful movement, breathing and relaxation.'],
            ['icon' => '◷', 'title' => 'Yoga for Professionals', 'text' => 'Flexible sessions that fit around work, sitting and everyday demands.'],
            ['icon' => '♧', 'title' => 'Yoga for Seniors', 'text' => 'Gentle, adaptable practices for mobility, balance and comfortable movement.'],
            ['icon' => '☀', 'title' => "Women's Yoga & Wellness", 'text' => 'Personalized practices that can adapt to individual needs and life stages.'],
        ];

        $audienceBlocks = [
            ['icon' => '☘', 'title' => 'Who can begin', 'text' => 'Yoga beginners learning from the basics\nWorking professionals seeking convenient sessions\nStudents exploring movement, mindfulness and relaxation\nSeniors looking for gentle, adaptable movement\nPeople working on flexibility and mobility'],
            ['icon' => '◌', 'title' => 'What a practice can support', 'text' => 'Complementing an active lifestyle\nMore relaxation and mindful movement\nStructured guidance for experienced practitioners\nA home-based online yoga routine\nA pace that feels realistic and sustainable'],
        ];

        $benefitBlocks = [
            ['icon' => '♧', 'title' => 'Physical benefits', 'text' => 'Supports flexibility and mobility\nHelps develop functional strength\nEncourages body awareness\nSupports balance and coordination'],
            ['icon' => '☾', 'title' => 'Mental & lifestyle benefits', 'text' => 'Creates time for relaxation\nSupports everyday stress management\nEncourages conscious breathing\nPromotes mindfulness'],
            ['icon' => '∞', 'title' => 'The power of consistency', 'text' => 'You do not need hours of practice every day. Finding a realistic routine you can maintain is the most important step towards a long-term yoga practice.'],
        ];

        $planBlocks = [
            ['icon' => '◇', 'title' => 'Trial Yoga Session', 'text' => 'A simple way to experience YogIntra before choosing a routine.\n\nDiscuss your yoga goals\nUnderstand the class format\nMeet your instructor\nExplore suitable options'],
            ['icon' => '◫', 'title' => 'Monthly Yoga Plan', 'text' => 'Build consistency with regular instructor-guided yoga sessions.\n\nScheduled yoga classes\nInstructor guidance\nFlexible session options\nSuitable for regular practice'],
            ['icon' => '◎', 'title' => 'Personalized Yoga Plan', 'text' => 'Individual guidance shaped around your requirements.\n\nGoal-oriented practice\nFlexible scheduling\nIndividual attention\nPractice adapted to you'],
        ];

        // These FAQ blocks match the homepage and are editable individually
        // through the visual builder's FAQ editor.
        $homepageFaqBlocks = $this->homepageFaqBlocks();

        $sections = [
            ['section_type' => 'cta', 'heading' => 'Yoga Classes in India for a Healthier, More Balanced Life', 'content' => '<p>Practice yoga with experienced instructors through personalized and online yoga classes across India.</p><p>Whether you are a beginner, a busy professional, a senior, or an experienced practitioner, YogIntra makes it easier to build a consistent practice around your goals, schedule and lifestyle.</p>', 'button_text' => 'Book Your Yoga Session', 'button_url' => url('contact'), 'text_align' => 'center', 'background_color' => '#e4f4f2', 'padding_y' => 64],
            ['section_type' => 'text', 'heading' => 'Start where you are. Practice at your pace.', 'content' => '<p>Yoga has been part of India’s wellness traditions for centuries. YogIntra brings that practice into modern everyday life with convenient, personalized yoga sessions.</p><p>You do not need to be flexible, experienced, or ready to change your whole routine. With thoughtful guidance and a practice that fits your day, yoga can become a sustainable part of your wellbeing journey.</p>', 'text_align' => 'center', 'background_color' => '#ffffff', 'padding_y' => 72],
            ['section_type' => 'image_text', 'heading' => 'About YogIntra', 'content' => '<p>Back in 2011, YogIntra started with a simple thought: to make yoga accessible to everyday people, even with busy schedules. Today, YogIntra is building a community nationally and internationally, helping people of all ages and genders stay healthy, active and connected through yoga.</p><p>The name YogIntra comes from “Yog” and “Intra.” Yog comes from the Sanskrit word “Yuj,” meaning connection or union. Intra refers to something within. Together, YogIntra represents the connection between the soul and the divine within oneself, bringing yoga into everyday life with balance, wellness and inner connection.</p>', 'image' => 'assets/Square-Logo-with-Name-2-povy7zr4loqk9maa9hbtvdrc77dpfngjngf3wrmp40.webp', 'image_alt' => 'YogIntra logo', 'image_position' => 'left', 'image_size' => 34, 'text_align' => 'left', 'background_color' => '#fff7ed', 'padding_y' => 72],
            ['section_type' => 'feature_grid', 'heading' => 'Yoga Services Available Across India', 'content' => '<p>Choose a practice that meets you where you are, from live online guidance to sessions designed around your personal goals.</p>', 'blocks' => $serviceBlocks, 'grid_columns' => 4, 'card_layout' => 'stacked', 'card_alignment' => 'center', 'text_align' => 'center', 'background_color' => '#eef6ff', 'padding_y' => 72],
            ['section_type' => 'feature_grid', 'heading' => 'Yoga Classes for Different Needs, Ages & Experience Levels', 'content' => '<p>You do not have to fit a particular fitness level to begin. Your practice can evolve as your experience and requirements change.</p>', 'blocks' => $audienceBlocks, 'grid_columns' => 2, 'card_layout' => 'stacked', 'card_alignment' => 'left', 'text_align' => 'center', 'background_color' => '#f8f4ff', 'padding_y' => 72],
            ['section_type' => 'feature_grid', 'heading' => 'Benefits of Regular Yoga Practice', 'content' => '<p>When practiced appropriately and consistently, yoga can support movement, mindfulness, relaxation and overall wellbeing.</p>', 'blocks' => $benefitBlocks, 'grid_columns' => 3, 'card_layout' => 'stacked', 'card_alignment' => 'left', 'text_align' => 'center', 'background_color' => '#0d6c75', 'text_color' => '#ffffff', 'description_color' => '#ffffff', 'padding_y' => 64],
            ['section_type' => 'text', 'heading' => 'Start Your Yoga Journey in 3 Simple Steps', 'content' => '<h3>1. Share your requirements</h3><p>Tell us about your experience, preferred schedule, lifestyle and what you want from your practice.</p><h3>2. Choose your format</h3><p>Explore a suitable option such as online yoga classes or personalized yoga sessions.</p><h3>3. Start practicing</h3><p>Attend your sessions, follow instructor guidance and gradually build a consistent routine.</p>', 'text_align' => 'center', 'background_color' => '#fff9e8', 'padding_y' => 72],
            ['section_type' => 'feature_grid', 'heading' => 'Yoga Plans for Different Needs', 'content' => '<p>Choose a package based on your preferred schedule, class format and practice goals. Contact YogIntra for current pricing and availability.</p>', 'blocks' => $planBlocks, 'grid_columns' => 3, 'card_layout' => 'stacked', 'card_alignment' => 'left', 'text_align' => 'center', 'background_color' => '#eef8f4', 'padding_y' => 72],
            ['section_type' => 'custom_columns', 'heading' => 'Frequently Asked Questions', 'content' => '', 'blocks' => $homepageFaqBlocks, 'grid_columns' => 1, 'text_align' => 'center', 'background_color' => '#f0f7f7', 'padding_y' => 72],
            ['section_type' => 'cta', 'heading' => 'Ready to Start Your Yoga Journey?', 'content' => '<p>Whether you are taking your first class or looking for a more consistent practice, YogIntra makes it easier to find yoga sessions that fit your lifestyle.</p>', 'button_text' => 'Book Your Yoga Session', 'button_url' => url('contact'), 'text_align' => 'center', 'background_color' => '#e6f0ff', 'padding_y' => 64],
        ];

        foreach ($sections as $order => $section) {
            LandingPageSection::create(array_merge([
                'landing_page_id' => $pageId,
                'background_color' => '#ffffff',
                'image_position' => 'left',
                'image_size' => 42,
                'padding_x' => 0,
                'padding_y' => 48,
                'margin_x' => 0,
                'margin_y' => 0,
                'text_color' => '#183c45',
                'heading_size' => 32,
                'description_color' => '#647b82',
                'description_size' => 16,
                'text_align' => 'left',
                'grid_columns' => 3,
                'card_layout' => 'stacked',
                'card_alignment' => 'center',
                'grid_gap' => 24,
                'sort_order' => $order,
            ], $section, [
                'blocks' => isset($section['blocks']) ? json_encode($section['blocks']) : null,
                'elements' => isset($section['elements']) ? json_encode($section['elements']) : null,
            ]));
        }
    }
}
