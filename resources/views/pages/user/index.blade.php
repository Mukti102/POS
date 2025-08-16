@extends('layouts.main')
@section('content')
    <x-alert />
    <div>
        <x-layout.page-header title="User list" subtitle="View/Search User List">
            <div class="page-btn">
                <button data-bs-toggle="modal" data-bs-target="#addModal" href="#" class="btn btn-added"><img
                        src="assets/img/icons/plus.svg" alt="img" class="me-1" />Tambah</button>
            </div>
        </x-layout.page-header>
        <x-table.table-wraper>
            <x-table.table-top />
            <x-table.table-responsive>
                <table class="table {{ $users->count() <= 0 ? '' : 'datanew' }}">
                    <thead>
                        <tr>
                            <th>
                                No
                            </th>
                            <th>Nama User</th>
                            <th>Phone</th>
                            <th>Hak Akses</th>
                            <th>Cabang</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>
                                    @if ($user->role == 'superadmin')
                                        <span class="badge bg-info">Superadmin</span>
                                    @else
                                        <span class="badge bg-warning">Admin</span>
                                    @endif
                                </td>
                                <td>{{ $user->branch->name }}</td>
                                <td class="d-flex gap-3">
                                    <a class="me-3 btn" data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $user->id }}">
                                        <img src="assets/img/icons/edit.svg" alt="img" />
                                    </a>
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="me-3 btn delete-button" href="javascript:void(0);">
                                            <img src="assets/img/icons/delete.svg" alt="img" />
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editModalLabel{{ $user->id }}">Edit Pengadaan
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('user.update', $user->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body row">
                                                <x-form.input-text value="{{ $user->name }}" label="Nama Costumer"
                                                    name="name" />
                                                <x-form.input-text label="Password" type="password" name="password" />

                                                <x-form.input-text value="{{ $user->email }}" label="Email"
                                                    name="email" />
                                                <x-form.input-text value="{{ $user->phone }}" label="Nomor Telephone"
                                                    name="phone" />
                                                <div class="form-group">
                                                    <label>Hak Akses</label>
                                                    <select class="select" name="role" required>
                                                        <option value="" selected disabled>Pilih Hak Akses</option>
                                                        <option @selected('admin') value="admin">Admin</option>
                                                        <option @selected('superadmin') value="superadmin">SuperAdmin
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Cabang</label>
                                                    <select class="select" name="branch_id" required>
                                                        <option value="" selected disabled>Pilih Cabang</option>
                                                        @foreach ($branches as $branch)
                                                            <option @selected($branch->id == $user->branch_id)
                                                                value="{{ $branch->id }}">{{ $branch->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label>Alamat</label>
                                                        <textarea name="address" class="form-control">
                                                            {{ $user->address }}
                                                        </textarea>
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
                    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body row">
                            <x-form.input-text label="Nama Costumer" name="name" />
                            <x-form.input-text label="Email" name="email" />
                            <x-form.input-text label="Password" type="password" name="password" />
                            <x-form.input-text label="Nomor Telephone" name="phone" />
                            <div class="form-group">
                                <label>Hak Akses</label>
                                <select class="select" name="role" required>
                                    <option value="" selected disabled>Pilih Hak Akses</option>
                                    <option value="admin">Admin</option>
                                    <option value="superadmin">SuperAdmin</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Cabang</label>
                                <select class="select" name="branch_id" required>
                                    <option value="" selected disabled>Pilih Cabang</option>
                                    @foreach ($branches as $branch)
                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                    @endforeach
                                </select>
                            </div>
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
