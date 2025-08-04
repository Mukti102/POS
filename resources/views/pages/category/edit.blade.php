@extends('layouts.main')
@section('content')
    <div>
        <x-layout.page-header title="Edit Category" subtitle="Edit Category Product" />
        <x-form.form title="Edit Category Product" subtitle="Edit Category Product"
            route="{{ route('category.update', $category->id) }}" method="PUT">

            <x-form.input-text label="Category Name" value="{{ $category->name }}" name="name"
                placeholder="Masukkan category name" />
            <x-form.input-text label="Category Kode" value="{{ $category->code }}" name="code"
                placeholder="Masukkan Kategory Kode" />
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control">{{ $category->description }}</textarea>
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
