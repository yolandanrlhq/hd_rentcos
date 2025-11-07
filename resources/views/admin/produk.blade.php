@extends('layouts.admin')

@section('title', 'Dashboard Admin')

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
