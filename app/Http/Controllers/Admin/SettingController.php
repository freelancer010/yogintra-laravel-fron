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

    public function updateApplicationSetting(Request $request, $type = null)
    {
        $appSetting = ApplicationSetting::find(1);
        $data = [];

        switch ($type) {
            case 'general':
                $data = $request->only([
                    'app_name', 'app_meta_title', 'app_meta_description',
                    'app_keywords', 'footer_about_us'
                ]);
                $message = 'General settings updated successfully';
                break;

            case 'contact':
                $data = $request->only([
                    'app_address', 'app_mobile', 'app_email', 'map_iframe'
                ]);
                $message = 'Contact settings updated successfully';
                break;

            case 'logo':
                // Handle logo uploads
                foreach (['app_sticky_logo', 'app_footer_logo', 'fevicon'] as $field) {
                    if ($request->hasFile($field)) {
                        if ($appSetting->$field && file_exists(public_path($appSetting->$field))) {
                            unlink(public_path($appSetting->$field));
                        }
                        $file = $request->file($field);
                        $filename = 'uploads/' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads'), basename($filename));
                        $data[$field] = $filename;
                    }
                }
                $message = 'Logo settings updated successfully';
                break;

            case 'payment':
                $data = $request->only([
                    'rozar_key_id', 'rozar_key_secret'
                ]);
                $message = 'Payment settings updated successfully';
                break;

            case 'htmlhead':
                $data = $request->only([
                    'head_code'
                ]);
                $message = 'HTML Head settings updated successfully';
                break;

            case 'social':
                $data = $request->only([
                    'facebook', 'twitter', 'youtube', 'instagram',
                    'telegram', 'linkedin'
                ]);
                $message = 'Social media settings updated successfully';
                break;

            default:
                // If no type specified, handle all fields
                $data = $request->only([
                    'app_name', 'app_keywords', 'app_meta_title', 'app_meta_description',
                    'footer_about_us', 'app_address', 'app_mobile', 'app_email',
                    'rozar_key_id', 'rozar_key_secret', 'head_code', 'facebook', 'twitter',
                    'youtube', 'instagram', 'telegram', 'linkedin', 'map_iframe'
                ]);
                
                // Handle file uploads
                foreach (['app_sticky_logo', 'app_footer_logo', 'fevicon'] as $field) {
                    if ($request->hasFile($field)) {
                        if ($appSetting->$field && file_exists(public_path($appSetting->$field))) {
                            unlink(public_path($appSetting->$field));
                        }
                        $file = $request->file($field);
                        $filename = 'uploads/' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move(public_path('uploads'), basename($filename));
                        $data[$field] = $filename;
                    }
                }
                $message = 'All settings updated successfully';
        }

        $appSetting->update($data);

        return redirect()->back()->with('success', $message)
            ->with('updated', true)
            ->with('activeTab', $type);
    }
}
