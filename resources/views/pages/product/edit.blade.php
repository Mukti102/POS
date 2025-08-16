@extends('layouts.main')
@section('content')
    <div>
        <x-layout.page-header title="Edit Product {{ $product->name }}" subtitle="Edit Product" />

        <x-form.form title="Edit Product" subtitle="Edit Product" method="PUT"
            route="{{ route('product.update', $product->id) }}">
            {{-- Pilih Kategori --}}
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Kategori</label>
                    <select class="select" name="category_id" required>
                        <option value="" selected disabled>Pilih Kategori</option>
                        @foreach ($categories as $category)
                            <option {{ $category->id == $product->category_id ? 'selected' : '' }}
                                value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Nama & SKU --}}
            <x-form.input-text value="{{ $product->name }}" label="Nama Product" name="name"
                placeholder="Masukkan Nama Produk" />
            <x-form.input-text value="{{ $product->sku }}" label="SKU" name="sku" placeholder="Masukkan SKU" />

            <div class="col-lg-10">
                {{-- Input per Cabang --}}
                <h5 class="mt-4 mb-2">Stok & Harga Per Cabang</h5>
                @foreach ($branches as $index => $branch)
                    @php
                        // Cari data pivot untuk branch ini
                        $pivot = $product->branches->firstWhere('id', $branch->id)?->pivot;
                    @endphp

                    <div class="border rounded p-3 mb-3">
                        <h6 class="mb-3">{{ $branch->name }}</h6>
                        <input type="hidden" name="branches[{{ $index }}][branch_id]" value="{{ $branch->id }}">
                        <div class="row">
                            <x-form.input-text value="{{ $pivot?->initial_stock }}" col="col-lg-4 col-sm-6 col-12"
                                label="Stock Awal" name="branches[{{ $index }}][initial_stock]" type="number"
                                placeholder="0" />

                            <x-form.input-group value="{{ $pivot?->cost_price }}" col="col-lg-4 col-sm-6 col-12"
                                label="Harga Beli" prefix="Rp" name="branches[{{ $index }}][cost_price]"
                                type="number" placeholder="0" />

                            <x-form.input-group value="{{ $pivot?->selling_price }}" col="col-lg-4 col-sm-6 col-12"
                                label="Harga Jual" prefix="Rp" name="branches[{{ $index }}][selling_price]"
                                type="number" placeholder="0" />
                        </div>
                    </div>
                @endforeach

            </div>


            {{-- Upload Gambar --}}
            <div class="col-lg-12">
                <div class="form-group">
                    <label>Product Image</label>
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
