@extends('layouts.admin')

@section('title', 'Pencarian Kostum')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/iotControl.css') }}">
@endsection

@section('content')
<div class="container">
    {{-- Sidebar --}}
    @include('admin.sections.sidebar')

    {{-- Konten utama --}}
    <div class="main">
        @include('admin.sections.iotControl')
    </div>
</div>
@endsection
