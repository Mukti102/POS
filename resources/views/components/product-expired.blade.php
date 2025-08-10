<div class="card mb-0">
    <div class="card-body">
        <h4 class="card-title">Expired Products</h4>
        <div class="table-responsive dataview">
            <table class="table {{ $products->count() == 0 ? '' : 'datatable' }}">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Product</th>
                        <th>Nama Kategory</th>
                        <th>Stock</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td class="productimgname">
                                <a class="product-img" href="productlist.html">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : '/assets/img/product/noimage.png' }}"
                                        alt="product" />
                                </a>
                                <a href="productlist.html">{{ $product->name }}</a>
                            </td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                @if ($product->stock <= 5 && $product->stock > 0)
                                    <span class="badge bg-warning">Stock Hampir Habis</span>
                                @elseif ((float) $product->stock <= 0)
                                    <span class="badge bg-danger">Stock Habis</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center">
                                Tidak Ada Product
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
