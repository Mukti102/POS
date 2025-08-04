@php
    use App\Models\Setting;

@endphp
@extends('layouts.main')

@section('content')
    <x-layout.page-header title="Setting" subtitle="Setting for costum the application" />

    <form class="card" enctype="multipart/form-data" method="POST" action="{{ route('setting.update') }}">
        @csrf

        <div class="card-header">
            <div class="card-title">
                Setting
            </div>
        </div>

        <div class="card-body row">
            {{-- Nama Situs --}}
            <x-form.input-text label="Nama Situs" name="site_name" placeholder="Masukkan Nama Perusahaan Anda"
                value="{{ Setting::get('site_name') ?? '' }}" />

            {{-- Deskripsi --}}
            <x-form.input-text label="Deskripsi Situs" name="site_description" placeholder="Deskripsi singkat"
                value="{{ Setting::get('site_description') ?? '' }}" />

            {{-- Email --}}
            <x-form.input-text label="Email" name="site_email" type="email" placeholder="contoh@email.com"
                value="{{ Setting::get('site_email') ?? '' }}" />

            {{-- Telepon --}}
            <x-form.input-text label="Telepon" name="site_phone" placeholder="+62xxxxxxxxxx"
                value="{{ Setting::get('site_phone') ?? '' }}" />

            {{-- Alamat --}}
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" name="address">{{ Setting::get('address') ?? '' }}</textarea>
                </div>
            </div>

            {{-- Logo --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Logo</label>
                    <div class="image-upload">
                        <input type="file" name="logo" />
                        <div class="image-uploads">
                            <img src="{{ asset('/assets/img/icons/upload.svg') }}" alt="img" />
                            <h4>Drag and drop a file to upload</h4>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Favicon --}}
            <div class="col-lg-6">
                <div class="form-group">
                    <label>Favicon</label>
                    <div class="image-upload">
                        <input type="file" name="favicon" />
                        <div class="image-uploads">
                            <img src="{{ asset('/assets/img/icons/upload.svg') }}" alt="img" />
                            <h4>Drag and drop a file to upload</h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Pengaturan</button>
        </div>

    </form>
@endsection
