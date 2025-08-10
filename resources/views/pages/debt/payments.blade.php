@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Daftar Pembayaran" subtitle="Lihat / Edit Pembayaran Hutang">
            <div class="page-btn">
                <button data-bs-toggle="modal" data-bs-target="#addModal" class="btn btn-added">
                    <img src="/assets/img/icons/plus.svg" alt="img" class="me-1" />Tambah
                </button>
            </div>
        </x-layout.page-header>

        <x-table.table-wraper>
            <x-table.table-top />
            <x-table.table-responsive>
                <table class="table {{ $payments->count() > 0 ? 'datanew' : '' }}">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jumlah Bayar</th>
                            <th>Tanggal Bayar</th>
                            <th>Catatan</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($payments as $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ number_format($payment->amount, 0, ',', '.') }}</td>
                                <td>{{ $payment->payment_date }}</td>
                                <td>{{ $payment->notes ?? '-' }}</td>
                                <td class="d-flex gap-3">
                                    <a class="btn" data-bs-toggle="modal"
                                       data-bs-target="#editModal{{ $payment->id }}">
                                        <img src="/assets/img/icons/edit.svg" alt="Edit" />
                                    </a>
                                    <form action="{{ route('bayar-tagihan.destroy', $payment->id) }}" method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus pembayaran ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn delete-button">
                                            <img src="/assets/img/icons/delete.svg" alt="Delete" />
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            {{-- Modal Edit --}}
                            <div class="modal fade" id="editModal{{ $payment->id }}" tabindex="-1"
                                 aria-labelledby="editModalLabel{{ $payment->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $payment->id }}">
                                                Edit Pembayaran
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('bayar-tagihan.update', $payment->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body row">
                                                <input type="hidden" name="debt_id" value="{{ $payment->debt_id }}">
                                                <x-form.input-text label="Jumlah Bayar" name="amount" type="number"
                                                                   :value="$payment->amount" />
                                                <x-form.input-text label="Tanggal Bayar" name="payment_date" type="date"
                                                                   :value="$payment->payment_date" />
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Catatan</label>
                                                        <textarea name="notes" class="form-control">{{ $payment->notes }}</textarea>
                                                    </div>
                                                </div>
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
                                <td colspan="5" class="text-center">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-table.table-responsive>
        </x-table.table-wraper>

        {{-- Modal Tambah --}}
        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Tambah Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                    </div>
                    <form action="{{ route('bayar-tagihan.store') }}" method="POST">
                        @csrf
                        <div class="modal-body row">
                            <input type="hidden" name="debt_id" value="{{ $debt->id }}">
                            <x-form.input-text label="Jumlah Bayar" name="amount" type="number" />
                            <x-form.input-text label="Tanggal Bayar" name="payment_date" type="date" />
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea name="notes" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
