<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use App\Models\Setting;
use App\Models\OurFeatureHeading;
use App\Models\OurFeature;
use App\Models\OurService;
use App\Models\OurServiceImage;
use App\Models\Testimonial;
use App\Services\OptimizedImageUpload;

class FrontSettingController extends Controller
{

    public function slider()
    {
        $sliders = Slider::orderByDesc('slider_id')->get();
        $heroSetting = Setting::first();
        return view('admin.front_setting.slider', compact('sliders', 'heroSetting'));
    }

    public function updateHeroMedia(Request $request)
    {
        $request->validate([
            'hero_media_type' => 'required|in:slider,video',
            'hero_video' => 'nullable|file|mimes:mp4,webm,ogg,mov|max:51200',
            'hero_video_thumbnail' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5000',
            'hero_video_heading' => 'required_if:hero_media_type,video|nullable|string|max:255',
            'hero_video_sub_heading' => 'nullable|string|max:255',
            'hero_video_btn_name' => 'nullable|string|max:100',
            'hero_video_btn_link' => 'nullable|url',
            'hero_video_text_direction' => 'required_if:hero_media_type,video|nullable|in:left,right,center',
        ]);

        $setting = Setting::firstOrFail();
        if ($request->hero_media_type === 'video' && !$request->hasFile('hero_video') && !$setting->hero_video) {
            return back()->withErrors(['hero_video' => 'Please choose a hero video before enabling video mode.'])->withInput();
        }

        if ($request->hasFile('hero_video')) {
            if ($setting->hero_video && file_exists(public_path($setting->hero_video))) {
                unlink(public_path($setting->hero_video));
            }
            $video = $request->file('hero_video');
            $videoName = 'hero_' . time() . '.' . $video->getClientOriginalExtension();
            $video->move(public_path('uploads'), $videoName);
            $setting->hero_video = 'uploads/' . $videoName;
        }
        if ($request->hasFile('hero_video_thumbnail')) {
            if ($setting->hero_video_thumbnail && file_exists(public_path($setting->hero_video_thumbnail))) {
                unlink(public_path($setting->hero_video_thumbnail));
            }
            $setting->hero_video_thumbnail = app(OptimizedImageUpload::class)->store($request->file('hero_video_thumbnail'));
        }

        $setting->hero_media_type = $request->hero_media_type;
        $setting->hero_video_title = $request->filled('hero_video_heading') ? $request->hero_video_heading : null;
        $setting->hero_video_description = $request->filled('hero_video_sub_heading') ? $request->hero_video_sub_heading : null;
        $setting->hero_video_heading = $request->filled('hero_video_heading') ? $request->hero_video_heading : null;
        $setting->hero_video_sub_heading = $request->filled('hero_video_sub_heading') ? $request->hero_video_sub_heading : null;
        $setting->hero_video_btn_name = $request->filled('hero_video_btn_name') ? $request->hero_video_btn_name : null;
        $setting->hero_video_btn_link = $request->filled('hero_video_btn_link') ? $request->hero_video_btn_link : null;
        $setting->hero_video_text_direction = $request->hero_video_text_direction ?: 'left';
        $setting->save();

        return back()->with('success', $request->hero_media_type === 'video' ? 'Hero video enabled successfully.' : 'Image slider enabled successfully.');
    }

    public function section2()
    {
        $service_heading = OurServiceImage::where('os_image_id', 1)->first();
        $our_service = OurService::all();
        return view('admin.front_setting.section_2', compact('service_heading', 'our_service'));
    }

    public function section3()
    {
        return view('admin.front_setting.section_3', ['setting' => Setting::firstOrFail()]);
    }

    public function updateSection3(Request $request)
    {
        $request->validate([
            'section3_heading' => 'required|string|max:255',
            'section3_description' => 'required|string|max:1000',
            'section3_background_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5000',
            'section3_padding_y' => 'required|integer|min:20|max:180',
        ]);
        $setting = Setting::firstOrFail();
        if ($request->hasFile('section3_background_image')) {
            $setting->section3_background_image = app(OptimizedImageUpload::class)->store($request->file('section3_background_image'));
        }
        $setting->section3_heading = $request->section3_heading;
        $setting->section3_description = $request->section3_description;
        $setting->section3_padding_y = $request->section3_padding_y;
        $setting->save();
        return back()->with('success', 'Section 3 updated successfully.');
    }

    public function updateServiceImage(Request $request)
    {
        $request->validate([
            'os_image_heading'     => 'required|string',
            'os_image_sub_heading' => 'nullable|string',
            'os_image_description' => 'nullable|string',
            'os_image_image'       => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5000'
        ]);

        $image = OurServiceImage::first();
        $image->os_image_heading = $request->os_image_heading;
        $image->os_image_sub_heading = $request->os_image_sub_heading;
        $image->os_image_description = $request->os_image_description;

        if ($request->hasFile('os_image_image')) {
            if ($image->os_image_image && file_exists(public_path($image->os_image_image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $image->os_image_image));
            }   
            $path = $request->file('os_image_image')->store('uploads', 'public');
            $image->os_image_image = 'storage/' . $path;
        }

        $image->save();

        return back()->with('success', 'Service image section updated successfully');
    }

    public function storeService(Request $request)
    {
        $request->validate([
            'os_heading' => 'required|string',
            'os_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5000'
        ]);

        $service = new OurService();
        $service->os_heading = $request->os_heading;

        if ($request->hasFile('os_image')) {
            $service->os_image = app(OptimizedImageUpload::class)->store($request->file('os_image'));
        }

        $service->save();

        return back()->with('success', 'Service added successfully');
    }

    public function editService($id)
    {
        $service = OurService::findOrFail($id);
        return view('admin.front_setting.edit_service', compact('service'));
    }

    public function updateService(Request $request, $id)
    {
        $request->validate([
            'os_heading' => 'required|string',
            'os_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5000'
        ]);

        $service = OurService::findOrFail($id);
        $service->os_heading = $request->os_heading;

        if ($request->hasFile('os_image')) {
            if ($service->os_image && file_exists(public_path($service->os_image))) {
                unlink(public_path($service->os_image));
            }
            $service->os_image = app(OptimizedImageUpload::class)->store($request->file('os_image'));
        }

        $service->save();

        return redirect()->route('admin.front.section2')->with('success', 'Service updated successfully');
    }

    public function deleteService($id)
    {
        $service = OurService::findOrFail($id);
        if ($service->os_image && file_exists(public_path($service->os_image))) {
            unlink(public_path($service->os_image));
        }
        $service->delete();

        return back()->with('success', 'Service deleted successfully');
    }

    public function updateSlider(Request $request, $id)
    {
        $request->validate([
            'slider_heading' => 'required|string|max:255',
            'slider_sub_heading' => 'nullable|string|max:255',
            'slider_btn_name' => 'nullable|string|max:100',
            'slider_btn_link' => 'nullable|url',
            'slider_text_direction' => 'required|in:left,right,center',
            'slider_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:5000',
        ]);

        $slider = Slider::findOrFail($id);
        $slider->slider_heading = $request->slider_heading;
        $slider->slider_sub_heading = $request->slider_sub_heading;
        $slider->slider_btn_name = $request->slider_btn_name;
        $slider->slider_btn_link = $request->slider_btn_link;
        $slider->slider_text_direction = $request->slider_text_direction;

        if ($request->hasFile('slider_image')) {
            if ($slider->slider_image && file_exists(public_path($slider->slider_image))) {
                unlink(public_path($slider->slider_image));
            }

            $slider->slider_image = app(OptimizedImageUpload::class)->store($request->file('slider_image'));
        }

        $slider->save();

        return redirect()->route('admin.front.slider')->with('success', 'Slider updated successfully');
    }

    public function editSlider($slider_id)
    {
        $slider = Slider::findOrFail($slider_id);
        return view('admin.front_setting.edit_slider', compact('slider'));
    }

    public function section1()
    {
        $data['feature_heading'] = OurFeatureHeading::find(1);
        $data['our_feature'] = OurFeature::all();
        return view('admin.front_setting.section_1', $data);
    }


    public function editOurFeature($id)
    {
        $data['features'] = OurFeature::findOrFail($id);
        return view('admin.front_setting.edit_section_1', $data);
    }

    public function updateOurFeature(Request $request, $id)
    {
        $feature = OurFeature::findOrFail($id);

        $request->validate([
            'of_heading' => 'required|string|max:255',
            'of_description' => 'required|string',
            'of_image' => 'nullable|image|max:2048',
        ]);

        $feature->of_heading = $request->of_heading;
        $feature->of_description = $request->of_description;

        if ($request->hasFile('of_image')) {
            $feature->of_image = app(OptimizedImageUpload::class)->store($request->file('of_image'));
        }

        $feature->save();

        return redirect()->route('admin.front.our_features.edit', $id)->with('success', 'Feature updated successfully');
    }

    public function updateOurFeaturesHeading(Request $request)
    {
        $heading = OurFeatureHeading::find(1); // Or your actual logic
        $heading->of_heading = $request->of_heading;
        $heading->of_sub_heading = $request->of_sub_heading;

        if ($request->hasFile('of_image')) {
            $heading->of_image = app(OptimizedImageUpload::class)->store($request->file('of_image'), 'uploads/our-features');
        }

        $heading->save();

        return redirect()->back()->with('success', 'Heading section updated successfully.');
    }

    // ==================== Testimonials Section ====================
    
    public function testimonial()
    {
        $testimonials = Testimonial::orderByDesc('test_id')->get();
        return view('admin.front_setting.testimonial', compact('testimonials'));
    }

    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'test_name' => 'required|string|max:255',
            'test_position' => 'nullable|string|max:255',
            'test_review' => 'required|integer|min:1|max:5',
            'test_description' => 'required|string',
            'test_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $testimonial = new Testimonial();
        $testimonial->test_name = $request->test_name;
        $testimonial->test_position = $request->test_position ?? '';
        $testimonial->test_review = $request->test_review;
        $testimonial->test_description = $request->test_description;

        if ($request->hasFile('test_image')) {
            $testimonial->test_image = app(OptimizedImageUpload::class)->store($request->file('test_image'));
        }

        $testimonial->save();

        return back()->with('success', 'Testimonial added successfully');
    }

    public function editTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.front_setting.edit_testimonial', compact('testimonial'));
    }

    public function updateTestimonial(Request $request, $id)
    {
        $request->validate([
            'test_name' => 'required|string|max:255',
            'test_position' => 'nullable|string|max:255',
            'test_review' => 'required|integer|min:1|max:5',
            'test_description' => 'required|string',
            'test_image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $testimonial = Testimonial::findOrFail($id);
        $testimonial->test_name = $request->test_name;
        $testimonial->test_position = $request->test_position ?? '';
        $testimonial->test_review = $request->test_review;
        $testimonial->test_description = $request->test_description;

        if ($request->hasFile('test_image')) {
            if ($testimonial->test_image && file_exists(public_path($testimonial->test_image))) {
                unlink(public_path($testimonial->test_image));
            }
            $testimonial->test_image = app(OptimizedImageUpload::class)->store($request->file('test_image'));
        }

        $testimonial->save();

        return redirect()->route('admin.front.testimonial')->with('success', 'Testimonial updated successfully');
    }

    public function deleteTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        if ($testimonial->test_image && file_exists(public_path($testimonial->test_image))) {
            unlink(public_path($testimonial->test_image));
        }
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted successfully');
    }


}
