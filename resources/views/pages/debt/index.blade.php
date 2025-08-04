@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Data Hutang Costumer" subtitle="View/Search Costumer Hutang">
        </x-layout.page-header>
        <x-table.table-wraper>
            <x-table.table-top />
            <x-table.table-responsive>
                <table class="table {{ $hutangs->count() <= 0 ? '' : 'datanew' }}">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>Nama Costumer</th>
                            <th>Nama Product</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total</th>
                            <th>Tebayar</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hutangs as $hutang)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $hutang->transaction->costumer->name }}</td>

                                <td>{{ $hutang->transaction->transactionItems->first()->product->name }}</td>
                                <td>{{ $hutang->transaction->transactionItems->first()->quantity }}</td>
                                <td>Rp
                                    {{ number_format($hutang->transaction->transactionItems->first()->product->selling_price) }}
                                </td>
                                <td>Rp {{ number_format($hutang->total_debt, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($hutang->paid, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($hutang->remaining, 0, ',', '.') }}</td>
                                <td>
                                    @if ($hutang->status !== 'lunas')
                                        <span class="badges bg-danger">Belum Lunas</span>
                                    @else
                                        <span class="badges bg-lightgreen">Lunas</span>
                                    @endif

                                </td>
                                <td class="d-flex gap-3">
                                    <form action="{{ route('debt.destroy', $hutang->id) }}" method="POST">
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
                                <td colspan="7" style="text-align: center;font-size: 15px">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-table.table-responsive>

        </x-table.table-wraper>

    </div>
@endsection
