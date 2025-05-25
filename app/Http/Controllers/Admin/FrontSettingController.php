<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FrontSettingController extends Controller
{
    
    public function section2()
    {
        $service_heading = DB::table('our_service_image')->where('os_image_id', 1)->first();
        $our_service = DB::table('our_service')->get();

        return view('admin.front_setting.section_2', compact('service_heading', 'our_service'));
    }

    public function updateServiceHeading(Request $request)
    {
        $data = $request->only(['os_image_heading', 'os_image_sub_heading', 'os_image_description']);

        if ($request->hasFile('os_image_image')) {
            $file = $request->file('os_image_image');
            $filename = 'uploads/' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['os_image_image'] = $filename;
        }

        DB::table('our_service_image')->where('os_image_id', 1)->update($data);

        return redirect()->back()->with('success', 'Service heading updated.');
    }

    public function storeService(Request $request)
    {
        $data = $request->only(['os_heading']);

        if ($request->hasFile('os_image')) {
            $file = $request->file('os_image');
            $filename = 'uploads/' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['os_image'] = $filename;
        }

        DB::table('our_service')->insert($data);

        return redirect()->back()->with('success', 'New service added.');
    }

    public function editService($id)
    {
        $service = DB::table('our_service')->where('os_id', $id)->first();

        return view('admin.front_setting.edit_service', compact('service'));
    }

    public function updateService(Request $request, $id)
    {
        $data = $request->only(['os_heading']);

        if ($request->hasFile('os_image')) {
            $file = $request->file('os_image');
            $filename = 'uploads/' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);
            $data['os_image'] = $filename;
        }

        DB::table('our_service')->where('os_id', $id)->update($data);

        return redirect()->route('admin.front_setting.section_2')->with('success', 'Service updated.');
    }

    public function deleteService($id)
    {
        $service = DB::table('our_service')->where('os_id', $id)->first();

        if ($service && $service->os_image && file_exists(public_path($service->os_image))) {
            unlink(public_path($service->os_image));
        }

        DB::table('our_service')->where('os_id', $id)->delete();

        return redirect()->back()->with('success', 'Service deleted.');
    }
}
