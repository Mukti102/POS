@extends('layouts.main')
@section('content')
    <x-stats/>
    <div class="row">
        <x-chart/>
        <x-debt-expired/>
    </div>
    <x-product-expired/>
@endsection
