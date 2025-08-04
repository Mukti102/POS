@extends('layouts.main')
@section('content')
    <div>
        <x-layout.page-header title="Tambah Transaksi" subtitle="Tambah  Transaksi" />
        <x-form.form title="Tambah  Transaksi" subtitle="Tambah  Transaksi" route="{{ route('transaction.store') }}">
            <x-form.input-text label="Tanggal Transaksi" type="date" name="transaction_date" />
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Costumer</label>
                    <select class="js-example-basic-single" name="costumer_id">
                        <option value="" selected disabled>Pilih Costumer</option>
                        @foreach ($costumers as $costumer)
                            <option value="{{ $costumer->id }}">{{ $costumer->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Product</label>
                    <select class="js-example-basic-single" name="product_id" id="product_id">
                        <option value="" selected disabled>Pilih Product</option>
                        @foreach ($products as $product)
                            <option data-price="{{ $product->selling_price }}" value="{{ $product->id }}">
                                {{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <x-form.input-text label="Jumlah" type="number" name="quantity" placeholder="Masukkan Jumlah" />
            <x-form.input-text label="Subtotal" type="number" readonly name="subtotal" placeholder="Subtotal" />
            <x-form.input-group prefix="Rp" label="Bayar" type="number" name="paid" />
            <x-form.input-group prefix='Rp' label="Kembalian" readonly type="number" name="change" />
            <div class="col-lg-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Status Pembayaran</label>
                    <select class="select" name="status_payment">
                        <option value="" disabled>Status Pembayaran</option>
                        <option value="paid" selected>Sudah Di Bayar</option>
                        <option value="due">Belum Di Bayar</option>
                    </select>
                </div>
            </div>
        </x-form.form>
    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jQuery-slimScroll/1.3.8/jquery.slimscroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2({
                width: '100%'
            });

            function calculateSubtotal() {
                const selectedOption = $('#product_id option:selected');
                const price = parseFloat(selectedOption.data('price')) || 0;
                const qty = parseFloat($('input[name="quantity"]').val()) || 0;
                const subtotal = price * qty;


                $('input[name="subtotal"]').val(subtotal);
            }

            function calculateChange() {
                const bayar = parseFloat($('input[name="paid"]').val()) || 0;
                const total = parseFloat($('input[name="subtotal"]').val()) || 0;
                const change = bayar - total;
                $('input[name="change"]').val(change);
            }

            $('input[name="paid"]').on('input', calculateChange);
            $('input[name="subtotal"]').on('input', calculateChange); // Opsional, jika subtotal berubah
            $('input[name="quantity"]').on('input', calculateChange); // Opsional, jika subtotal berubah

            $('#product_id').on('change', calculateSubtotal);
            $('input[name="quantity"]').on('input', calculateSubtotal);
        });
    </script>
@endpush
