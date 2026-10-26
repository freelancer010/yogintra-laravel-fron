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
                $request->validate($this->generalValidationRules());
                $data = $request->only([
                    'app_name', 'app_meta_title', 'app_meta_description',
                    'app_keywords', 'footer_about_us'
                ]);
                $message = 'General settings updated successfully';
                break;

            case 'contact':
                $request->validate($this->contactValidationRules());
                $data = $request->only([
                    'app_address', 'app_address_locality', 'app_address_region',
                    'app_postal_code', 'app_address_country', 'app_mobile',
                    'app_email', 'map_iframe'
                ]);
                $data = collect($data)
                    ->map(fn ($value) => is_string($value) ? trim($value) : $value)
                    ->all();
                $data['app_address_country'] = strtoupper((string) ($data['app_address_country'] ?? ''));
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
                $socialFields = [
                    'facebook', 'twitter', 'youtube', 'instagram',
                    'telegram', 'linkedin',
                ];
                $request->validate(array_fill_keys(
                    $socialFields,
                    ['nullable', 'url:http,https', 'max:500']
                ));
                $data = collect($request->only($socialFields))
                    ->map(fn ($value) => filled($value) ? trim($value) : null)
                    ->all();
                $message = 'Social media settings updated successfully';
                break;

            default:
                // If no type specified, handle all fields
                $request->validate(array_merge(
                    $this->generalValidationRules(),
                    $this->contactValidationRules()
                ));
                $data = $request->only([
                    'app_name', 'app_keywords', 'app_meta_title', 'app_meta_description',
                    'footer_about_us', 'app_address', 'app_address_locality',
                    'app_address_region', 'app_postal_code', 'app_address_country',
                    'app_mobile', 'app_email',
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

        if (array_key_exists('app_address_country', $data)) {
            $data['app_address_country'] = strtoupper(trim((string) $data['app_address_country']));
        }

        $appSetting->update($data);

        return redirect()->back()->with('success', $message)
            ->with('updated', true)
            ->with('activeTab', $type);
    }

    private function generalValidationRules(): array
    {
        return [
            'app_name' => ['required', 'string', 'max:100'],
            'app_meta_title' => ['nullable', 'string', 'max:60'],
            'app_meta_description' => ['nullable', 'string', 'max:160'],
            'app_keywords' => ['nullable', 'string', 'max:255'],
            'footer_about_us' => ['nullable', 'string', 'max:200'],
        ];
    }

    private function contactValidationRules(): array
    {
        return [
            'app_address' => ['nullable', 'string', 'max:500'],
            'app_address_locality' => ['nullable', 'string', 'max:120'],
            'app_address_region' => ['nullable', 'string', 'max:120'],
            'app_postal_code' => ['nullable', 'string', 'max:20'],
            'app_address_country' => ['nullable', 'alpha', 'size:2'],
            'app_mobile' => ['nullable', 'string', 'max:30'],
            'app_email' => ['nullable', 'email', 'max:255'],
            'map_iframe' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
