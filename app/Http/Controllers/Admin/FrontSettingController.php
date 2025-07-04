<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Slider;
use App\Models\OurServiceImage;
use App\Models\OurService;

class FrontSettingController extends Controller
{

    public function slider()
    {
        $sliders = Slider::orderByDesc('slider_id')->get();
        return view('admin.front_setting.slider', compact('sliders'));
    }

    public function section2()
    {
        $service_image = OurServiceImage::first();
        $services = OurService::all();
        return view('admin.front_setting.section2', compact('service_image', 'services'));
    }

    public function updateServiceImage(Request $request)
    {
        $request->validate([
            'os_image_heading' => 'required|string',
            'os_image_sub_heading' => 'nullable|string',
            'os_image_description' => 'nullable|string',
            'os_image_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5000'
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
            'os_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5000'
        ]);

        $service = new OurService();
        $service->os_heading = $request->os_heading;

        if ($request->hasFile('os_image')) {
            $path = $request->file('os_image')->store('uploads', 'public');
            $service->os_image = 'storage/' . $path;
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
            'os_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5000'
        ]);

        $service = OurService::findOrFail($id);
        $service->os_heading = $request->os_heading;

        if ($request->hasFile('os_image')) {
            if ($service->os_image && file_exists(public_path($service->os_image))) {
                unlink(public_path($service->os_image));
            }
            $path = $request->file('os_image')->store('uploads', 'public');
            $service->os_image = 'storage/' . $path;
        }

        $service->save();

        return back()->with('success', 'Service updated successfully');
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
            'slider_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5000',
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

            $path = $request->file('slider_image')->store('uploads', 'public');
            $slider->slider_image = 'storage/' . $path;
        }

        $slider->save();

        return redirect()->back()->with('success', 'Slider updated successfully');
    }

    public function editSlider($slider_id)
    {
        $slider = Slider::findOrFail($slider_id);
        return view('admin.front_setting.edit_slider', compact('slider'));
    }

}
