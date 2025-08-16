@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Data Cabang" subtitle="View/Search Costumer List">
            <div class="page-btn">
                <button data-bs-toggle="modal" data-bs-target="#addModal" href="#" class="btn btn-added"><img
                        src="assets/img/icons/plus.svg" alt="img" class="me-1" />Tambah</button>
            </div>
        </x-layout.page-header>
        <x-table.table-wraper>
            <x-table.table-top />
            <x-table.table-responsive>
                <table class="table {{ $branches->count() >= 0 ? '' : 'datanew' }}">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Phone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($branches as $cabang)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $cabang->name }}</td>
                                <td style="max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"
                                    title="{{ $cabang->address }}">
                                    {{ $cabang->address }}
                                </td>

                                <td>{{ $cabang->phone }}</td>
                                <td class="d-flex gap-1">
                                    <a class="me-1 btn btn-sm btn-warning text-white" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $cabang->id }}">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form action="{{ route('cabang.destroy', $cabang->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="me-3 btn btn-sm btn-danger text-white delete-button" href="javascript:void(0);">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="editModal{{ $cabang->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $cabang->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $cabang->id }}">Edit Cabang
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('cabang.update', $cabang->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body row">
                                                <x-form.input-text label="Nama" name="name" :value="$cabang->name" />
                                                <x-form.input-text label="Nomor Telephone" name="phone"
                                                    :value="$cabang->phone" />
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <textarea name="address" class="form-control">{{ $cabang->address }}</textarea>
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
                        <h5 class="modal-title" id="addModalLabel">Tambah Cabang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('cabang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body row">
                            <x-form.input-text label="Nama Costumer" name="name" />
                            <x-form.input-text label="Nomor Telephone" name="phone" />
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Alamat</label>
                                    <textarea name="address" class="form-control"></textarea>
                                </div>
                            </div>
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
