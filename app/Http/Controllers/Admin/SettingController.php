<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicationSetting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function applicationSetting()
    {
        $data['setting'] = ApplicationSetting::find(1); // Assuming app_id = 1
        return view('admin.settings.application_setting', $data);
    }

    public function updateApplicationSetting(Request $request)
    {
        $appSetting = ApplicationSetting::find(1);

        $data = $request->only([
            'app_name', 'app_keywords', 'app_meta_title', 'app_meta_description',
            'footer_about_us', 'app_address', 'app_mobile', 'app_email',
            'rozar_key_id', 'rozar_key_secret', 'head_code', 'facebook', 'twitter',
            'youtube', 'instagram', 'telegram', 'linkedin', 'map_iframe'
        ]);

        // File uploads
        foreach (['app_sticky_logo', 'app_footer_logo', 'fevicon'] as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists
                if ($appSetting->$field && file_exists(public_path($appSetting->$field))) {
                    unlink(public_path($appSetting->$field));
                }

                $file = $request->file($field);
                $filename = 'uploads/' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), basename($filename));
                $data[$field] = $filename;
            }
        }

        $appSetting->update($data);

        return redirect()->back()->with('success', 'Data Successfully Updated');
    }
}
