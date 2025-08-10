@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Data Hutang Costumer" subtitle="View/Search Costumer Hutang">
        </x-layout.page-header>
        <x-table.table-wraper>
            <x-table.table-top pdf="{{ route('debt.print') }}" />
            <x-table.table-responsive>
                <table class="table {{ $debts->count() <= 0 ? '' : 'datanew' }}">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>Nama Costumer</th>
                            <th>Total</th>
                            <th>Tebayar</th>
                            <th>Sisa</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($debts as $hutang)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $hutang['costumer'] }}</td>

                                <td>Rp
                                    {{ number_format($hutang['total'], 0, ',', '.') }}
                                </td>
                                <td>Rp {{ number_format($hutang['paid'], 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($hutang['remaining'], 0, ',', '.') }}</td>
                                <td>
                                    @if ($hutang['status'] !== 'lunas')
                                        <span class="badges bg-danger">Belum Lunas</span>
                                    @else
                                        <span class="badges bg-lightgreen">Lunas</span>
                                    @endif

                                </td>
                                <td class="d-flex gap-2">
                                    <a href={{ route('detail.debts', $hutang['id']) }} class="btn btn-sm text-white bg-info" href="javascript:void(0);">
                                        <i class="fa fa-eye" data-bs-toggle="tooltip" title="Lihat Detail"></i>
                                    </a>

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
