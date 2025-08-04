@extends('layouts.main')
@section('content')
    <div>
        <x-layout.page-header title="Tambah Product" subtitle="Tambah  Product" />
        <x-form.form title="Tambah  Product" subtitle="Tambah  Product" route="{{ route('product.store') }}">
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Kategory</label>
                    <select class="select" name="category_id">
                        <option value="" selected disabled>Pilih Kategory</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <x-form.input-text label="Nama Product" name="name" placeholder="Masukkan Nama Produck" />
            <x-form.input-text label="SKU" name="sku" placeholder="Masukkan SKU" />
            <x-form.input-text label="Stock Awal" name="initial_stock" type="number" placeholder="100" />
            <x-form.input-group label="Harga Beli" prefix="Rp" name="cost_price" type="number" placeholder="100000" />
            <x-form.input-group label="Harga Jual" prefix="Rp" name="selling_price" type="number" placeholder="100000" />
            <div class="col-lg-12">
                <div class="form-group">
                    <label> Product Image</label>
                    <div class="image-upload">
                        <input type="file" name="image" />
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
