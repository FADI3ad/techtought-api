<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Cache::rememberForever('app_settings', function () {
            $settingsData = Setting::first();
            
            if ($settingsData) {
                $settingsData->logo = $settingsData->logo_path ? asset('storage/' . $settingsData->logo_path) : null;
                $settingsData->favicon = $settingsData->favicon_path ? asset('storage/' . $settingsData->favicon_path) : null;
            }
            return $settingsData;
        });

        return response()->json([
            'status' => 'success',
            'data' => $settings
        ]);
    }

    public function update(Request $request)
    {
        $settings = Setting::firstOrCreate(['id' => 1]);

        $data = $request->all();

        // Handle JSON fields (if they come as strings from FormData)
        if (is_string($request->team_members)) {
            $data['team_members'] = json_decode($request->team_members, true);
        }
        if (is_string($request->payment_methods)) {
            $data['payment_methods'] = json_decode($request->payment_methods, true);
        }
        if (is_string($request->social_links)) {
            $data['social_links'] = json_decode($request->social_links, true);
        }
        if (is_string($request->theme_settings)) {
            $data['theme_settings'] = json_decode($request->theme_settings, true);
        }

        // Handle File Uploads
        if ($request->hasFile('logo')) {
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($settings->favicon_path) {
                Storage::disk('public')->delete($settings->favicon_path);
            }
            $data['favicon_path'] = $request->file('favicon')->store('settings', 'public');
        }

        $settings->update($data);

        Cache::forget('app_settings');

        return response()->json([
            'status' => 'success',
            'message' => 'Settings updated successfully',
            'data' => $settings
        ]);
    }
}
