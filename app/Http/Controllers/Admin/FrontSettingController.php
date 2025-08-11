<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Slider;
use App\Models\OurFeatureHeading;
use App\Models\OurFeature;
use App\Models\OurService;
use App\Models\OurServiceImage;

class FrontSettingController extends Controller
{

    public function slider()
    {
        $sliders = Slider::orderByDesc('slider_id')->get();
        return view('admin.front_setting.slider', compact('sliders'));
    }

    public function section2()
    {
        $service_heading = OurServiceImage::where('os_image_id', 1)->first();
        $our_service = OurService::all();
        return view('admin.front_setting.section_2', compact('service_heading', 'our_service'));
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
            $image = $request->file('os_image');
            $filename = 'uploads/' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), basename($filename));
            $service->os_image = $filename;
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
            $image = $request->file('os_image');
            $filename = 'uploads/' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), basename($filename));
            $service->os_image = $filename;
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

            $image = $request->file('slider_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $slider->slider_image = 'uploads/' . $imageName;
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
            $image = $request->file('of_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads'), $imageName);
            $feature->of_image = 'uploads/' . $imageName;
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
            $file = $request->file('of_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/our-features'), $filename);
            $heading->of_image = 'uploads/our-features/' . $filename;
        }

        $heading->save();

        return redirect()->back()->with('success', 'Heading section updated successfully.');
    }


}
