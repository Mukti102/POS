@extends('layouts.main')
@section('content')
    <x-dashboard.card-stats/>
    <div class="row">
        <x-dashboard.chart/>
        <x-dashboard.table-debt-expired/>
    </div>
    <x-dashboard.product-expired/>
@endsection
