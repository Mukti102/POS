@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Product Category list" subtitle="View/Search product Category">
            <div class="page-btn">
                <a href="{{ route('category.create') }}" class="btn btn-added">
                    <img src="assets/img/icons/plus.svg" class="me-1" alt="img" />Add Category
                </a>
            </div>
        </x-layout.page-header>
        <x-table.table-wraper>
            <x-table.table-top />
            <x-table.filter-input>
                <div class="col-lg-2 col-sm-6 col-12">
                    <div class="form-group">
                        <select class="select">
                            <option>Choose Category</option>
                            <option>Computers</option>
                        </select>
                    </div>
                </div>
            </x-table.filter-input>
            <x-table.table-responsive>
                <table class="table {{ $categories->count() >= 0 ? '' : 'datanew' }}">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>Category name</th>
                            <th>Category Code</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td class="productimgname">
                                    <a href="javascript:void(0);" class="product-img">
                                        <img src="{{!$category->photo ? 'assets/img/product/noimage.png' : asset('storage/'. $category->photo)}}" alt="product" />
                                    </a>
                                    <a href="javascript:void(0);">{{ $category->name }}</a>
                                </td>
                                <td>{{ $category->code }}</td>
                                <td>{{ $category->description }}</td>
                                <td class="d-flex gap-3">
                                    <a class="me-3 btn" href="{{route('category.edit',$category->id)}}">
                                        <img src="assets/img/icons/edit.svg" alt="img" />
                                    </a>
                                    <form  action="{{route('category.destroy',$category->id)}}" method="POST" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="me-3 btn delete-button" href="javascript:void(0);">
                                            <img src="assets/img/icons/delete.svg" alt="img" />
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;font-size: 15px">Tidak Ada Data</td>
                            </tr>
                        @endforelse


                    </tbody>
                </table>
            </x-table.table-responsive>

        </x-table.table-wraper>
    </div>
@endsection
