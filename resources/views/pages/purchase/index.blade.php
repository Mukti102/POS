@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Pengadaan Barang Cabang {{ optional($branches->where('id', $branchId)->first())->name }}" subtitle="View/Search Pengadaan List">
            <div class="page-btn">
                <button data-bs-toggle="modal" data-bs-target="#addModal" href="addproduct.html" class="btn btn-added"><img
                        src="assets/img/icons/plus.svg" alt="img" class="me-1" />Tambah</button>
            </div>
        </x-layout.page-header>
        <x-table.table-wraper>
            <x-table.table-top />
            <x-table.filter-input action="pengadaan.index">
                <div class="col-lg-2 col-sm-6 col-12">
                    <div class="form-group">
                        <select class="select" name="branch_id">
                            @foreach ($branches as $branch)
                                <option {{ $branch->id == $branchId ? 'selected' : '' }} value={{ $branch->id }}>
                                    {{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </x-table.filter-input>
            <x-table.table-responsive>
                <table class="table {{ $purchases->count() >= 0 ? '' : 'datanew' }}">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>Nama Cabang</th>
                            <th>Nama Product</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($purchases as $purchase)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $purchase->branch->name }}</td>
                                <td class="productimgname">
                                    <a href="javascript:void(0);" class="product-img">
                                        <img src="{{ !$purchase->product->image ? 'assets/img/product/noimage.png' : asset('storage/' . $purchase->product->image) }}"
                                            alt="product" />
                                    </a>
                                    <a href="javascript:void(0);">{{ $purchase->product->name }}</a>
                                </td>
                                <td>{{ $purchase->quantity }}</td>
                                <td>Rp {{ number_format($purchase->cost_price, 0, ',', '.') }}</td>
                                <td class="d-flex gap-3">
                                    <a class="me-3 btn" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $purchase->id }}">
                                        <img src="assets/img/icons/edit.svg" alt="img" />
                                    </a>
                                    <form action="{{ route('pengadaan.destroy', $purchase->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="me-3 btn delete-button" href="javascript:void(0);">
                                            <img src="assets/img/icons/delete.svg" alt="img" />
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="editModal{{ $purchase->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $purchase->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $purchase->id }}">Edit Pengadaan
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('pengadaan.update', $purchase->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body row">
                                                <div class="form-group">
                                                    <label>Cabang</label>
                                                    <select class="js-example-basic-single"
                                                        id="branch_id-{{ $purchase->id }}" name="branch_id">

                                                        <option value="" selected disabled>Pilih Product</option>
                                                        @foreach ($branches as $branch)
                                                            <option
                                                                {{ $purchase->branch_id == $branch->id ? 'selected' : '' }}
                                                                value="{{ $branch->id }}">{{ $branch->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Product</label>
                                                    <select class="js-example-basic-single" name="product_id"
                                                        style="width: 100%" id="product_id-{{ $purchase->id }}">


                                                        <option value="" disabled>Pilih Product</option>
                                                        @foreach ($products as $product)
                                                            <option value="{{ $product->id }}"
                                                                {{ $purchase->product_id == $product->id ? 'selected' : '' }}>
                                                                {{ $product->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <x-form.input-text label="Jumlah" name="quantity" type="number"
                                                    :value="$purchase->quantity" :id="'quantity-' . $purchase->id" />
                                                <x-form.input-text label="Total Harga" name="cost_price" type="number"
                                                    :value="$purchase->cost_price" :id="'cost_price-' . $purchase->id" />

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center;font-size: 15px">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-table.table-responsive>

        </x-table.table-wraper>

        {{-- modal --}}
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Pengadaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('pengadaan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body row">
                            <div class="form-group">
                                <label>Cabang</label>
                                <select class="js-example-basic-single" id="branch_id" name="branch_id">
                                    <option value="" selected disabled>Pilih Cabang</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Product</label>
                                <select class="js-example-basic-single" id="product_id" name="product_id">
                                    <option value="" selected disabled>Pilih Product</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <x-form.input-text label="Jumlah" name="quantity" type="number" />
                            <x-form.input-text label="Total Harga" name="cost_price" type="number" />
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Aktifkan Select2 di semua modal saat ditampilkan
            $('.modal').on('shown.bs.modal', function() {
                $(this).find('.js-example-basic-single').select2({
                    dropdownParent: $(this),
                    width: '100%'
                });
            });

            // Hitung total otomatis hanya di modal tambah
            const products = @json($products);

            // Untuk setiap modal edit
            @foreach ($purchases as $purchase)
                $('#product_id-{{ $purchase->id }}, #branch_id-{{ $purchase->id }}, #quantity-{{ $purchase->id }}')
                    .on('change keyup', function() {
                        const productId = $('#product_id-{{ $purchase->id }}').val();
                        const branchId = $('#branch_id-{{ $purchase->id }}').val();
                        const qty = $('#quantity-{{ $purchase->id }}').val();

                        const selectedProduct = products.find(item => item.id == productId);
                        const product = selectedProduct?.branches.find(item => item.id == branchId)?.pivot;

                        if (selectedProduct && product && qty) {
                            $('#cost_price-{{ $purchase->id }}').val(qty * product.cost_price);
                        } else {
                            $('#cost_price-{{ $purchase->id }}').val('');
                        }
                    });
            @endforeach





            function updateHarga() {
                const productSelected = $('#product_id').val();
                const branchSelected = $('#branch_id').val();
                console.log(branchSelected)
                const qty = $('#quantity').val();
                const selectedProduct = products.find(item => item.id == productSelected);
                const product = selectedProduct.branches.find((item) => item.id == branchSelected)?.pivot;
                console.log(branchSelected)

                if (selectedProduct && qty) {
                    const total = qty * product.cost_price;
                    $('#cost_price').val(total);
                } else {
                    $('#cost_price').val('');
                }
            }

            $('#product_id, #branch_id').on('change', updateHarga);

            $('#quantity').on('input', updateHarga);
        });
    </script>
@endpush
