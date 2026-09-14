<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
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
            'use_classic_layout' => 'nullable|boolean',
            'page_image_title' => 'nullable|string',
            'page_image_description' => 'nullable|string',
            'page_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:5000',
            'sections' => 'nullable|array',
            'sections.*.section_type' => 'required|in:text,image,image_text,feature_grid,custom_columns,cta,testimonial,faq',
            'sections.*.heading' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
            'sections.*.button_text' => 'nullable|string|max:100',
            'sections.*.button_url' => 'nullable|url|max:500',
            'sections.*.background_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.background_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
            'sections.*.background_position' => 'nullable|in:left,center,right,top,bottom',
            'sections.*.background_parallax' => 'nullable|boolean',
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
        $sections = LandingPageSection::where('landing_page_id', $id)->orderBy('sort_order')->get();
        abort_unless($page, 404);

        return view('admin.landing_page.edit', compact('page', 'sections'));
    }

    /** Toggle whether this city page is accessible on the public site. */
    public function togglePublished(Request $request, $id)
    {
        $request->validate(['is_published' => 'required|boolean']);
        abort_unless(DB::table('new_landing_page')->where('page_id', $id)->exists(), 404);

        $isPublished = $request->boolean('is_published');
        DB::table('new_landing_page')->where('page_id', $id)->update(['is_published' => $isPublished]);

        return back()->with('success', $isPublished ? 'Landing page is now visible on the public site.' : 'Landing page is now hidden from the public site.');
    }

    /**
     * Convert the previously shared city-page fallback into independent builder
     * sections. The generated copy uses the current page name so editors begin
     * with a city-relevant page instead of the same generic text everywhere.
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

        return redirect()->route('admin.landing-pages.edit', $id)->with(
            'success',
            'Classic page converted to editable sections. Review the city-specific copy before publishing.'
        );
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
            'use_classic_layout' => 'nullable|boolean',
            'page_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5000',
            'sections' => 'nullable|array',
            'sections.*.section_type' => 'required|in:text,image,image_text,feature_grid,custom_columns,cta,testimonial,faq',
            'sections.*.heading' => 'nullable|string|max:255',
            'sections.*.content' => 'nullable|string',
            'sections.*.image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
            'sections.*.button_text' => 'nullable|string|max:100',
            'sections.*.button_url' => 'nullable|url|max:500',
            'sections.*.background_color' => 'nullable|regex:/^#[0-9A-Fa-f]{6}$/',
            'sections.*.background_image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5000',
            'sections.*.background_position' => 'nullable|in:left,center,right,top,bottom',
            'sections.*.background_parallax' => 'nullable|boolean',
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

        return redirect()->route('admin.landing-pages.edit', $id)->with('success', 'Page updated successfully.');
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
            $backgroundImagePath = $section['existing_background_image'] ?? null;

            if ($request->hasFile("sections.$order.image")) {
                $imagePath = app(OptimizedImageUpload::class)->store($request->file("sections.$order.image"), 'uploads/landing-pages');
            }
            if ($request->hasFile("sections.$order.background_image")) {
                $backgroundImagePath = app(OptimizedImageUpload::class)->store($request->file("sections.$order.background_image"), 'uploads/landing-pages');
            }

            $blocks = json_decode($section['blocks'] ?? '[]', true);
            $blocks = is_array($blocks) ? $blocks : [];
            foreach ($request->file("sections.$order.block_images", []) as $blockIndex => $blockImage) {
                $blocks[$blockIndex] = $blocks[$blockIndex] ?? [];
                $blocks[$blockIndex]['image'] = app(OptimizedImageUpload::class)->store($blockImage, 'uploads/landing-pages');
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
                'background_image' => $backgroundImagePath,
                'background_position' => $section['background_position'] ?? 'center',
                'background_parallax' => !empty($section['background_parallax']),
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
            ]);
        }
    }

    private function createClassicSections(int $pageId, string $city, string $legacyContent = ''): void
    {
        $serviceBlocks = DB::table('our_service')->get()->map(fn ($item) => [
            'image' => $item->os_image ?? null,
            'title' => $item->os_heading ?? 'Yoga service',
            'text' => '',
        ])->filter(fn ($item) => filled($item['title']))->values()->all();

        if (empty($serviceBlocks)) {
            $serviceBlocks = [
                ['image' => 'assets/front/images/6503db8d98529icon-1.png', 'title' => 'Alternative Medicines', 'text' => 'Holistic support for your wellbeing.'],
                ['image' => 'assets/front/images/6503dbc7b2fc5icon-2.png', 'title' => 'For Good Health', 'text' => 'Build sustainable healthy habits.'],
                ['image' => 'assets/front/images/6503dbe5edf47icon-3.png', 'title' => 'Healthy Mind & Body', 'text' => 'Balance movement, breath and mindfulness.'],
            ];
        }

        $benefitBlocks = DB::table('our_feature')->get()->map(fn ($item) => [
            'image' => $item->of_image ?? null,
            'title' => $item->of_heading ?? 'Yoga benefit',
            'text' => $item->of_description ?? '',
        ])->filter(fn ($item) => filled($item['title']))->values()->all();

        $yogaServiceBlocks = [
            ['image' => 'uploads/home_visit_yoga.webp', 'title' => 'Home Visit Yoga', 'text' => "Personal yoga sessions in {$city}.", 'url' => url('service/home-visit-yoga')],
            ['image' => 'uploads/private_online_yoga.webp', 'title' => 'Private Online Yoga', 'text' => 'One-to-one online guidance from home.', 'url' => url('service/private-online-yoga')],
            ['image' => 'uploads/group_online_yoga.webp', 'title' => 'Group Online Yoga', 'text' => 'Practice together from anywhere.', 'url' => url('service/group-online-yoga')],
            ['image' => 'uploads/65057356cad36images-150x150.webp', 'title' => 'Corporate Yoga', 'text' => "Wellbeing programmes for teams in {$city}.", 'url' => url('service/corporate-yoga')],
            ['image' => 'uploads/yog_center.webp', 'title' => 'Yoga Center', 'text' => 'Explore guided classes and programmes.', 'url' => url('yoga-center')],
            ['image' => 'uploads/ttc.webp', 'title' => 'Teacher Training', 'text' => 'Deepen your yoga knowledge and practice.', 'url' => url('teacher-training-course')],
        ];

        $intro = $legacyContent !== ''
            ? $legacyContent
            : "<p class=\"landing-sanskrit\">|| योग: कर्मसु कौशलम् ||</p><p>Looking for yoga classes in <strong>{$city}</strong>? YogIntra offers personalised practice for mobility, strength, stress relief and everyday wellbeing.</p><p>Choose from flexible formats and guidance that can fit naturally into your routine.</p>";

        $galleryBlocks = [
            ['image' => 'uploads/yoga-pose1.jpeg', 'title' => 'Yoga practice', 'text' => 'A moment of movement and balance.', 'url' => url('gallery')],
            ['image' => 'uploads/yoga-pose2.jpeg', 'title' => 'Mindful practice', 'text' => 'Find calm through consistent practice.', 'url' => url('gallery')],
            ['image' => 'uploads/yoga-pose3.jpeg', 'title' => 'Strength and serenity', 'text' => 'Explore more moments from YogIntra.', 'url' => url('gallery')],
        ];

        $sections = [
            ['section_type' => 'text', 'heading' => "Yoga Classes in {$city}", 'content' => $intro, 'text_align' => 'center', 'padding_y' => 42],
            ['section_type' => 'feature_grid', 'heading' => 'Life in Divine Yoga', 'content' => "<p>Choose a practice that suits your goals and routine in {$city}.</p>", 'elements' => [['type' => 'subheading', 'text' => '|| योग: कर्मसु कौशलम् ||', 'color' => '#0f7a84', 'size' => 26, 'padding' => 0, 'margin' => 0]], 'blocks' => $serviceBlocks, 'grid_columns' => 3, 'card_layout' => 'stacked', 'card_alignment' => 'center', 'text_align' => 'center', 'padding_y' => 42],
            ['section_type' => 'image', 'heading' => null, 'content' => null, 'image' => 'uploads/download.webp', 'image_alt' => "Yoga and wellbeing in {$city}", 'image_size' => 80, 'padding_y' => 28],
            ['section_type' => 'feature_grid', 'heading' => 'The main reasons to practise yoga', 'content' => "<p>Build a calmer, stronger and more balanced daily routine with guidance tailored to you in {$city}.</p>", 'elements' => [['type' => 'subheading', 'text' => '|| योगश्चित्तवृत्तिनिरोधः ||', 'color' => '#0f7a84', 'size' => 26, 'padding' => 0, 'margin' => 0]], 'blocks' => $benefitBlocks, 'grid_columns' => 2, 'card_layout' => 'icon_left', 'card_alignment' => 'left', 'text_align' => 'center', 'padding_y' => 42],
            ['section_type' => 'feature_grid', 'heading' => 'A brief description of the types of yoga services', 'content' => "<p>Explore flexible ways to practise, from private sessions to group and workplace programmes in {$city}.</p>", 'elements' => [['type' => 'subheading', 'text' => '|| तत्र स्थितौ यत्नोऽभ्यासः ||', 'color' => '#0f7a84', 'size' => 26, 'padding' => 0, 'margin' => 0]], 'blocks' => $yogaServiceBlocks, 'grid_columns' => 3, 'card_layout' => 'stacked', 'card_alignment' => 'center', 'text_align' => 'center', 'padding_y' => 42],
            ['section_type' => 'image_text', 'heading' => 'About YogIntra', 'content' => "<p>YogIntra brings experienced yoga professionals and practical wellness support together for people in {$city} and beyond. Our focus is making yoga approachable, consistent and relevant to your goals.</p>", 'image' => 'assets/Square-Logo-with-Name-2-povy7zr4loqk9maa9hbtvdrc77dpfngjngf3wrmp40.webp', 'image_alt' => 'YogIntra', 'image_position' => 'left', 'image_size' => 35, 'padding_y' => 42],
            ['section_type' => 'image_text', 'heading' => 'About our founder', 'content' => '<p>YogIntra was founded to make yoga easier to include in everyday life. Add founder information, local instructor experience and credentials here so visitors can understand who will guide their practice.</p>', 'image' => 'assets/image0-1-e1652675710448-povumdsa83b7dajv3gfs2377ei7o24wz5y0tn7sz34.webp', 'image_alt' => 'YogIntra founder', 'image_position' => 'right', 'image_size' => 42, 'padding_y' => 42],
            ['section_type' => 'cta', 'heading' => 'Meet our instructors', 'content' => "<p>Discover the experienced YogIntra instructors available to guide your practice in {$city}.</p>", 'button_text' => 'View instructors', 'button_url' => url('trainers'), 'text_align' => 'center', 'padding_y' => 42],
            ['section_type' => 'feature_grid', 'heading' => 'Gallery', 'content' => '<p>Discover tranquility through moments of yoga, movement and stillness.</p>', 'blocks' => $galleryBlocks, 'grid_columns' => 3, 'card_layout' => 'stacked', 'card_alignment' => 'center', 'text_align' => 'center', 'padding_y' => 42],
            ['section_type' => 'text', 'heading' => "Yoga classes in {$city}: frequently asked questions", 'content' => "<h3>Are classes suitable for beginners?</h3><p>Yes. Sessions can be adapted to your current flexibility, fitness and confidence.</p><h3>Can I book a class in {$city}?</h3><p>Use the enquiry form to share your preferred area, timing and goals. The team will help you choose a suitable option.</p><h3>What should I bring to my first session?</h3><p>Wear comfortable clothing and bring water. Your instructor will guide you on everything else.</p>", 'text_align' => 'left', 'padding_y' => 42],
            ['section_type' => 'cta', 'heading' => "Begin your yoga journey in {$city}", 'content' => "<p>Tell us what you are looking for and we will help you find the right yoga option.</p>", 'button_text' => 'Enquire now', 'button_url' => url('contact'), 'text_align' => 'center', 'background_color' => '#eef8f7', 'padding_y' => 48],
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
