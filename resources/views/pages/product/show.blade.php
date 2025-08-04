@extends('layouts.main')
@section('content')
    <div>
        <x-layout.page-header title="Edit Product" subtitle="Edit  Product" />

        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="productdetails">
                            <ul class="product-bar">
                                <li>
                                    <h4>Product</h4>
                                    <h6>{{ $product->name }}</h6>
                                </li>
                                <li>
                                    <h4>Category</h4>
                                    <h6>{{ $product->category->name }}</h6>
                                </li>
                                <li>
                                    <h4>SKU</h4>
                                    <h6>{{ $product->sku }}</h6>
                                </li>
                                <li>
                                    <h4>Harga Beli</h4>
                                    <h6>Rp {{ number_format($product->cost_price, 0, ',', '.') }}</h6>
                                </li>
                                <li>
                                    <h4>Harga Jual</h4>
                                    <h6>Rp {{ number_format($product->selling_price, 0, ',', '.') }}</h6>
                                </li>

                                <li>
                                    <h4>Stock Awal</h4>
                                    <h6>{{ $product->initial_stock }}</h6>
                                </li>
                                <li>
                                    <h4>Stock Akhir</h4>
                                    <h6>{{ $product->stock }}</h6>
                                </li>

                                <li>
                                    <h4>Description</h4>
                                    <h6>
                                        {{ $product->category->description }}
                                    </h6>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="slider-product-details">
                            <div class="owl-carousel owl-theme product-slide">
                                <div class="slider-product">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : '/assets/img/product/product69.jpg' }}"
                                        alt="img" />
                                    <h4>{{ $product->name }}</h4>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
