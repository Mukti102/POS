@extends('layouts.main')
@section('content')
    <div>
        <x-layout.page-header title="Tambah Category" subtitle="Tambah Category Product" />
        <x-form.form title="Tambah Category Product" subtitle="Tambah Category Product" route="{{ route('category.store') }}">
            <x-form.input-text label="Category Name" name="name" placeholder="Masukkan category name" />
            <x-form.input-text label="Category Kode" name="code" placeholder="Masukkan Kategory Kode" />
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control"></textarea>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="form-group">
                    <label> Product Image</label>
                    <div class="image-upload">
                        <input type="file" name="photo" />
                        <div class="image-uploads">
                            <img src="{{ asset('assets/img/icons/upload.svg') }}" alt="img" />
                            <h4>Drag and drop a file to upload</h4>
                        </div>
                    </div>
                </div>
            </div>
        </x-form.form>
    </div>
@endsection
