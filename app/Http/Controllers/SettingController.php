<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {   
        $settings = Setting::all();
        
        return view('pages.setting.index',compact('settings'));
    }

    public function update(Request $request)
    {
        // ========== HANDLE LOGO ==========
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');

            // Hapus file lama jika ada
            $oldLogo = Setting::get('logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            // Upload file baru
            $logoPath = $logoFile->store('settings', 'public');
            Setting::set('logo', $logoPath);
        }

        // ========== HANDLE FAVICON ==========
        if ($request->hasFile('favicon')) {
            $faviconFile = $request->file('favicon');

            // Hapus file lama jika ada
            $oldFavicon = Setting::get('favicon');
            if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                Storage::disk('public')->delete($oldFavicon);
            }

            // Upload file baru
            $faviconPath = $faviconFile->store('settings', 'public');
            Setting::set('favicon', $faviconPath);
        }

        // ========== HANDLE SETTING LAIN ==========
        $excludedKeys = ['_token', 'logo', 'favicon'];

        foreach ($request->except($excludedKeys) as $key => $value) {
            Setting::set($key, $value);
        }


        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
