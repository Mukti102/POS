@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Data Transaksi" subtitle="View/Search transaction List">
            <div class="page-btn">
                <a href="{{ route('transaction.create') }}" class="btn btn-added"><img src="assets/img/icons/plus.svg"
                        alt="img" class="me-1" />Tambah</a>
            </div>
        </x-layout.page-header>
        <x-table.table-wraper>
            <x-table.table-top />
            <x-table.table-responsive>
                <table class="table {{ $transactions->count() < 0 ? '' : 'datanew' }}">
                    <thead>
                        <tr>
                            <th>
                                <label class="checkboxs">
                                    <input type="checkbox" id="select-all" />
                                    <span class="checkmarks"></span>
                                </label>
                            </th>
                            <th>Tanggal</th>
                            <th>Nama Costumer</th>
                            <th>Reference</th>
                            <th>Total</th>
                            <th>Bayar</th>
                            <th>Kembali</th>
                            <th>Status</th>
                            <th>Payment</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox" />
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>{{ $transaction->transaction_date ? \Carbon\Carbon::parse($transaction->transaction_date)->translatedFormat('d F Y') : '-' }}
                                </td>
                                <td>{{ $transaction->costumer->name }}</td>
                                <td>{{ $transaction->reference }}</td>

                                <td class="text-info">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                <td class="text-success">Rp {{ number_format($transaction->paid, 0, ',', '.') }}</td>
                                <td class="text-warning">Rp {{ number_format($transaction->change, 0, ',', '.') }}</td>
                                <td>
                                    @if ($transaction->status == 'complete')
                                        <span class="badges bg-lightgreen">Completed</span>
                                    @else
                                        <span class="badges bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>

                                    @if ($transaction->status_payment == 'paid')
                                        <span class="badges bg-lightgreen">Success</span>
                                    @else
                                        <span class="badges bg-warning">Pending</span>
                                    @endif

                                </td>
                                <td class="text-center">
                                    <a class="action-set" href="javascript:void(0);" data-bs-toggle="dropdown"
                                        aria-expanded="true">
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a href="{{ route('transaction.show', $transaction->id) }}"
                                                class="dropdown-item"><img src="/assets/img/icons/eye1.svg" class="me-2"
                                                    alt="img" />
                                                Detail</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('transaction.edit', $transaction->id) }}"
                                                class="dropdown-item"><img src="/assets/img/icons/edit.svg" class="me-2"
                                                    alt="img" />
                                                Edit</a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item"><img
                                                    src="/assets/img/icons/download.svg" class="me-2"
                                                    alt="img" />Download
                                                pdf</a>
                                        </li>
                                        <li>
                                            <form action="{{ route('transaction.destroy', $transaction->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item delete-button"><img
                                                        src="assets/img/icons/delete1.svg" class="me-2"
                                                        alt="img" />Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="text-align: center">Tidak Ada Data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </x-table.table-responsive>

        </x-table.table-wraper>

    </div>
@endsection
