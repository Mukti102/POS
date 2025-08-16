@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Data Mutasi Stock" subtitle="View/Search Mutasi Stock">
            <div class="page-btn">
                <a href="{{ route('mutasi-stock.create') }}" class="btn btn-added">
                    <img src="assets/img/icons/plus.svg" class="me-1" alt="img" />Tambah Mutasi
                </a>
            </div>
        </x-layout.page-header>
        <x-table.table-wraper>
            <x-table.table-top />
            <x-table.table-responsive>
                <table class="table {{ $mutasi->count() <= 0 ? '' : 'datanew' }} ">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>Reference</th>
                            <th>Tanggal</th>
                            <th>Dari Cabang</th>
                            <th>Ke Cabang</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mutasi as $item)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $item->reference ?? 'MT-19018829020' }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}</td>
                                <td>{{ $item->fromBranch->name }}</td>
                                <td>{{ $item->toBranch->name }}</td>
                                <td>{{ $item->transferItems->sum('quantity') }}</td>
                                <td>
                                    Rp.{{ number_format($item->transferItems->sum('cost_price'), 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($item->status == 'complete')
                                        <span class="badge bg-success">Complete</span>
                                    @else
                                        <span class="badge bg-warning">Progres</span>
                                    @endif
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('mutasi-stock.show', $item->id) }}"
                                        class="btn btn-sm text-white bg-info" href="javascript:void(0);">
                                        <i class="fa fa-eye" data-bs-toggle="tooltip" title="Lihat Detail"></i>
                                    </a>
                                    @if ($item->status !== 'complete')
                                        <a href="{{ route('mutasi-stock.update.status', $item->id) }}"
                                            class="btn btn-sm text-white bg-warning" href="javascript:void(0);">
                                            <i class="fa fa-repeat" data-bs-toggle="tooltip" title="Update Status"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('mutasi-stock.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm  text-white bg-danger delete-button">
                                            <i class="fa fa-trash" data-bs-toggle="tooltip" title="Hapus"></i>
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
