@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="Costumer list" subtitle="View/Search Costumer List">
            <div class="page-btn">
                <button data-bs-toggle="modal" data-bs-target="#addModal" href="#" class="btn btn-added"><img
                        src="assets/img/icons/plus.svg" alt="img" class="me-1" />Tambah</button>
            </div>
        </x-layout.page-header>
        <x-table.table-wraper>
            <x-table.table-top />
            <x-table.table-responsive>
                <table class="table {{ $costumers->count() <= 0 ? '' : 'datanew' }}">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>Nama Costumer</th>
                            <th>Nomor telphoe</th>
                            <th>Alamat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($costumers as $costumer)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $costumer->name }}</td>
                                <td>{{ $costumer->phone }}</td>
                                <td>{{ $costumer->address }}</td>
                                <td class="d-flex gap-3">
                                    <a class="me-3 btn" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $costumer->id }}">
                                        <img src="assets/img/icons/edit.svg" alt="img" />
                                    </a>
                                    <form action="{{ route('costumer.destroy', $costumer->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="me-3 btn delete-button" href="javascript:void(0);">
                                            <img src="assets/img/icons/delete.svg" alt="img" />
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="editModal{{ $costumer->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $costumer->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $costumer->id }}">Edit Pengadaan
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('costumer.update', $costumer->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body row">
                                                <x-form.input-text label="Nama Costumer" name="name" :value="$costumer->name" />
                                                <x-form.input-text label="Nomor Telephone" name="phone"
                                                    :value="$costumer->phone" />
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <textarea name="address" class="form-control">{{ $costumer->address }}</textarea>
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
                        <h5 class="modal-title" id="addModalLabel">Tambah Pengadaan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('costumer.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body row">
                            <x-form.input-text label="Nama Costumer" name="name"  />
                            <x-form.input-text label="Nomor Telephone" name="phone"  />
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
