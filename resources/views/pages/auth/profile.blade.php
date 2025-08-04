@extends('layouts.main')
@section('content')
    <x-alert />
    <div class="card">
        <div class="card-body">
            <form class="profile-set" enctype="multipart/form-data" action="{{ route('update.avatar') }}" method="POST">
                @csrf
                @method('patch')
                <div class="profile-head"></div>
                <div class="profile-top">
                    <div class="profile-content">
                        <div class="profile-contentimg" style="overflow: hidden;">
                            <img src="{{asset('storage/'.auth()->user()->avatar)}}" style="width: 100%;height:100%;object-fit:cover" alt="img" id="blah" />
                            <div class="profileupload">
                                <input type="file" name="avatar" id="imgInp" />
                                <a href="javascript:void(0);"><img
                                        src="/assets/img/icons/edit-set.svg"
                                        alt="img" /></a>
                            </div>
                        </div>
                        <div class="profile-contentname">
                            <h2>{{ auth()->user()->name }}</h2>
                            <h4>Updates Your Photo and Personal Details.</h4>
                        </div>
                    </div>
                    <div class="ms-auto">
                        <button type="submit" href="javascript:void(0);" class="btn btn-submit me-2">Save</button>
                        <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                    </div>
                </div>
            </form>
            <form action="{{ route('profile.update') }}" method="POST" class="row">
                @csrf
                @method('patch')
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input name="name" value="{{$user->name}}" type="text" placeholder="William" />
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>Email</label>
                        <input name="email" value="{{$user->email}}" type="text" placeholder="william@example.com" />
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>Nomor Telphone</label>
                        <input name="phone" value="{{$user->phone}}" type="text" placeholder="08**" />
                    </div>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="address" id="" cols="30" rows="10">
                            {{$user->address}}
                        </textarea>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" href="javascript:void(0);" class="btn btn-submit me-2">Submit</button>
                    <a href="javascript:void(0);" class="btn btn-cancel">Cancel</a>
                </div>
            </form>
        </div>
    </div>
    <form method="POST" action="{{ route('password.update') }}" class="card">
        @csrf
        @method('put')
        <div class="card-header">
            <div class="card-title">
                Ubah Password
            </div>
            <div class="card-text">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, earum!
            </div>
        </div>
        <div class="card-body">
            <x-form.input-text label="Password Saat Ini" name="current_password" type="password" />
            <x-form.input-text label="Password Baru" name="password" type="password" />
            <x-form.input-text label="Konfirmasi Password" name="password_confirmation" type="password" />
        </div>
        <div class="card-footer">
            <button class="btn btn-info">Simpan</button>
        </div>
    </form>
@endsection
