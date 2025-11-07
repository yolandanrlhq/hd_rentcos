@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/produkAdmin.css') }}">
@endsection

@section('content')
<div class="container">
    {{-- Sidebar --}}
    @include('admin.sections.sidebar')

    {{-- Konten utama --}}
    <div class="main">
        @include('admin.sections.produk')
    </div>
</div>
@endsection
