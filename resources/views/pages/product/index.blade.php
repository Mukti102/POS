@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Data Product Cabang {{ optional($branches->where('id', $branchId)->first())->name }}" subtitle="View/Search product">
            <div class="page-btn">
                <a href="{{ route('product.create') }}" class="btn btn-added">
                    <img src="assets/img/icons/plus.svg" class="me-1" alt="img" />Tambah Product
                </a>
            </div>
        </x-layout.page-header>
        <x-table.table-wraper>
            <x-table.table-top />
            <x-table.filter-input>
                <div class="col-lg-2 col-sm-6 col-12">
                    <div class="form-group">
                        <select class="select" name="branch_id">
                            @foreach ($branches as $branch)
                                <option {{$branch->id == $branchId ? 'selected' : ''}} value={{ $branch->id }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </x-table.filter-input>
            <x-table.table-responsive>
                <table class="table {{ $products->count() <= 0 ? '' : 'datanew' }}">
                    <thead>
                        <tr>
                            <th>
                                <label class="checkboxs">
                                    <input type="checkbox" id="select-all" />
                                    <span class="checkmarks"></span>
                                </label>
                            </th>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Category</th>
                            <th>Harga Beli</th>
                            <th>Harga Jual</th>
                            <th>Stok Awal</th>
                            <th>Stok Akhir</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $product)
                        <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox" />
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td class="productimgname">
                                    <a href="javascript:void(0);" class="product-img">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('/assets/img/product/noimage.png') }}"
                                            alt="product" />
                                    </a>
                                    <a href="javascript:void(0);">{{ $product->name }}</a>
                                </td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->category->name }}</td>
                                <td>
                                   Rp.{{number_format($product->branches->first()->pivot->cost_price, 0, ',', '.')}}
                                </td>
                                <td>
                                   Rp.{{number_format($product->branches->first()->pivot->selling_price, 0, ',', '.')}}
                                </td>
                                <td>
                                  {{$product->branches->first()->pivot->initial_stock}}

                                </td>
                                <td>
                                  {{$product->branches->first()->pivot->stock}}
                                </td>
                                <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                        aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('product.show', $product->id) }}" class="dropdown-item"><img
                                                    src="assets/img/icons/eye1.svg" class="me-2" alt="img" />Product
                                                Detail</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('product.edit', $product->id) }}" class="dropdown-item"><img
                                                    src="assets/img/icons/edit.svg" class="me-2" alt="img" />Product
                                                Edit</a>
                                        </li>
                                        <li>
                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <a href="javascript:void(0);" class="dropdown-item delete-button"><img
                                                        src="assets/img/icons/delete1.svg" class="me-2"
                                                        alt="img" />Delete Sale</a>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center;font-size: 15px">Tidak Ada Data</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
            </x-table.table-responsive>

        </x-table.table-wraper>
    </div>
@endsection
