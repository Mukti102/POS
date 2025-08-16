@extends('layouts.main')
@section('content')
    @push('styles')
        <style>
            .hover-card {
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            }

            .hover-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
            }

            .card-header {
                border-bottom: 1px solid #f0f0f0;
            }

            .progress {
                border-radius: 10px;
            }

            .progress-bar {
                border-radius: 10px;
            }
        </style>
    @endpush
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
                            </ul>
                        </div>
                    </div>
                    {{-- cabang2 --}}
                </div>
                <div class="">
                    <div class="row g-3">
                        @foreach ($product->branches as $index => $branch)
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="card ">
                                    <!-- Header dengan warna yang lebih soft -->
                                    <div class="card-header bg-light border-0 py-3">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-store text-primary"></i>
                                            </div>
                                            <div>
                                                <small class="text-muted">Cabang {{ $index + 1 }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Body dengan layout yang lebih clean -->
                                    <div class="card-body p-4">
                                        <div class="row g-3">
                                            <!-- Harga Beli -->
                                            <div class="col-6">
                                                <div class="text-center p-3 bg-success bg-opacity-10 rounded">
                                                    <div class="text-success mb-1">
                                                        <i class="fas fa-arrow-down"></i>
                                                    </div>
                                                    <div class="fw-bold text-dark mb-1">
                                                        Rp {{ number_format($branch->pivot->cost_price, 0, ',', '.') }}
                                                    </div>
                                                    <small class="text-muted">Harga Beli</small>
                                                </div>
                                            </div>

                                            <!-- Harga Jual -->
                                            <div class="col-6">
                                                <div class="text-center p-3 bg-warning bg-opacity-10 rounded">
                                                    <div class="text-warning mb-1">
                                                        <i class="fas fa-arrow-up"></i>
                                                    </div>
                                                    <div class="fw-bold text-dark mb-1">
                                                        Rp {{ number_format($branch->pivot->selling_price, 0, ',', '.') }}
                                                    </div>
                                                    <small class="text-muted">Harga Jual</small>
                                                </div>
                                            </div>

                                            <!-- Stock Information -->
                                            <div class="col-12 mt-3">
                                                <div class="border-top pt-3">
                                                    <div class="row text-center">
                                                        <div class="col-6">
                                                            <div class="fw-bold h5 text-primary mb-1">
                                                                {{ $branch->pivot->initial_stock }}
                                                            </div>
                                                            <small class="text-muted">Stock Awal</small>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="fw-bold h5 text-success mb-1">
                                                                {{ $branch->pivot->stock }}
                                                            </div>
                                                            <small class="text-muted">Stock Akhir</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Stock Status Indicator (Optional) -->
                                            <div class="col-12">
                                                @php
                                                    $stockPercentage =
                                                        $branch->pivot->initial_stock > 0
                                                            ? ($branch->pivot->stock / $branch->pivot->initial_stock) *
                                                                100
                                                            : 0;
                                                    $statusClass =
                                                        $stockPercentage > 50
                                                            ? 'success'
                                                            : ($stockPercentage > 20
                                                                ? 'warning'
                                                                : 'danger');
                                                @endphp
                                                <div class="progress" style="height: 6px;">
                                                    <div class="progress-bar bg-{{ $statusClass }}"
                                                        style="width: {{ $stockPercentage }}%"></div>
                                                </div>
                                                <div class="d-flex justify-content-between mt-1">
                                                    <small class="text-muted">Stock Status</small>
                                                    <small class="text-{{ $statusClass }}">
                                                        {{ round($stockPercentage) }}%
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
