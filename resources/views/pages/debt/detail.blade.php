@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Detail Transaksi {{ $costumer->name }}" subtitle="View/Search transaction List">
        </x-layout.page-header>
        <x-table.table-wraper>
            <x-table.table-top />
            <x-table.table-responsive>
                <table class="table ">
                    <thead>
                        <tr>
                            <th>
                                <label class="checkboxs">
                                    <input type="checkbox" id="select-all" />
                                    <span class="checkmarks"></span>
                                </label>
                            </th>
                            <th>Reference</th>
                            <th>Total</th>
                            <th>Bayar</th>
                            <th>Sisa</th>
                            <th>Tanggal Jatuh Tempo</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($debts as $debt)
                            <tr>
                                <td>
                                    <label class="checkboxs">
                                        <input type="checkbox" />
                                        <span class="checkmarks"></span>
                                    </label>
                                </td>
                                <td>{{ $debt->transaction->reference }}</td>

                                <td class="text-info">Rp {{ number_format($debt->total_debt, 0, ',', '.') }}</td>
                                <td class="text-success">Rp {{ number_format($debt->paid, 0, ',', '.') }}</td>
                                <td class="text-warning">Rp {{ number_format($debt->remaining, 0, ',', '.') }}</td>
                                <td>{{ $debt->due_date }}</td>
                                <td>
                                    @if ($debt->status == 'lunas')
                                        <span class="badges bg-lightgreen">Lunas</span>
                                    @else
                                        <span class="badges bg-danger">Belum Lunas</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href={{ route('debt.show', $debt->id) }} class="btn btn-sm text-white bg-info"
                                        href="javascript:void(0);">
                                        <i class="fa fa-eye" data-bs-toggle="tooltip" title="Bayar"></i>
                                    </a>
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
