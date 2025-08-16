@extends('layouts.main')

@section('content')
    <div class="card shadow-sm">
        @if (auth()->user()->role == 'superadmin')
            <div class="card-header d-flex aling-items-center justify-content-end ">
                <form method="GET" style="width: 25%" class="d-flex  gap-2 align-items-center">
                    <label for="branch_id" style="width: 100%" class="mb-0 me-2">Pilih Cabang:</label>
                    <select name="branch_id" id="branch_id" class="form-select form-select-sm" onchange="this.form.submit()">
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>
        @endif

        <div class="card-body">
        <x-dashboard.stats />


            <div class="row mt-2">
                                <x-dashboard.chart />
                                  <x-dashboard.debt-expired />

               
            </div>

            <div class="mt-4">
                     <x-dashboard.product-expired />
            </div>
        </div>
    </div>
@endsection
