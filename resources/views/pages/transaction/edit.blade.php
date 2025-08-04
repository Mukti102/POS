@extends('layouts.main')
@section('content')
    <div>
        <x-layout.page-header title="Edit Transaksi" subtitle="Edit Transaksi" />
        <x-form.form 
            title="Edit Transaksi" 
            subtitle="Edit Transaksi" 
            route="{{ route('transaction.update', $transaction->id) }}" 
            method="PUT">

            <x-form.input-text 
                label="Tanggal Transaksi" 
                type="date" 
                name="transaction_date" 
                value="{{ old('transaction_date', $transaction->transaction_date) }}" />

            <div class="col-lg-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Costumer</label>
                    <select class="js-example-basic-single" name="costumer_id">
                        <option value="" disabled>Pilih Costumer</option>
                        @foreach ($costumers as $costumer)
                            <option 
                                value="{{ $costumer->id }}"
                                {{ old('costumer_id', $transaction->costumer_id) == $costumer->id ? 'selected' : '' }}>
                                {{ $costumer->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Product</label>
                    <select class="js-example-basic-single" name="product_id" id="product_id">
                        <option value="" disabled>Pilih Product</option>
                        @foreach ($products as $product)
                            <option 
                                data-price="{{ $product->selling_price }}"
                                value="{{ $product->id }}"
                                {{ old('product_id', $transaction->transactionItems[0]->product_id ?? '') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <x-form.input-text 
                label="Jumlah" 
                type="number" 
                name="quantity" 
                value="{{ old('quantity', $transaction->transactionItems[0]->quantity ?? '') }}"
                placeholder="Masukkan Jumlah" />

            <x-form.input-text 
                label="Subtotal" 
                type="number" 
                readonly 
                name="subtotal" 
                value="{{ old('subtotal', $transaction->transactionItems[0]->subtotal ?? '') }}"
                placeholder="Subtotal" />

            <x-form.input-group 
                prefix="Rp" 
                label="Bayar" 
                type="number" 
                name="paid" 
                value="{{ old('paid', $transaction->paid) }}" />

            <x-form.input-group 
                prefix="Rp" 
                label="Kembalian" 
                readonly 
                type="number" 
                name="change" 
                value="{{ old('change', $transaction->change) }}" />

            <div class="col-lg-6 col-sm-6 col-12">
                <div class="form-group">
                    <label>Status Pembayaran</label>
                    <select class="select" name="status_payment">
                        <option value="" disabled>Status Pembayaran</option>
                        <option value="paid" {{ old('status_payment', $transaction->status_payment) == 'paid' ? 'selected' : '' }}>Sudah Dibayar</option>
                        <option value="due" {{ old('status_payment', $transaction->status_payment) == 'due' ? 'selected' : '' }}>Belum Dibayar</option>
                    </select>
                </div>
            </div>
        </x-form.form>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({ width: '100%' });

        function calculateSubtotal() {
            const selectedOption = $('#product_id option:selected');
            const price = parseFloat(selectedOption.data('price')) || 0;
            const qty = parseFloat($('input[name="quantity"]').val()) || 0;
            const subtotal = price * qty;
            $('input[name="subtotal"]').val(subtotal);
            calculateChange();
        }

        function calculateChange() {
            const bayar = parseFloat($('input[name="paid"]').val()) || 0;
            const total = parseFloat($('input[name="subtotal"]').val()) || 0;
            const change = bayar - total;
            $('input[name="change"]').val(change);
        }

        $('input[name="quantity"], #product_id').on('input change', calculateSubtotal);
        $('input[name="paid"]').on('input', calculateChange);

        // Hitung langsung saat halaman dimuat jika sudah ada data
        calculateSubtotal();
    });
</script>
@endpush
