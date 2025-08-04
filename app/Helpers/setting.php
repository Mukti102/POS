<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, $default = null): mixed
    {
        // Cache untuk menghindari query berulang
        static $settings = [];

        // Ambil dari cache lokal jika sudah pernah diambil
        if (array_key_exists($key, $settings)) {
            return $settings[$key];
        }

        // Ambil dari database
        $value = Setting::where('key', $key)->first()?->value ?? $default;

        // Simpan ke cache lokal
        $settings[$key] = $value;

        return $value;
    }
}
