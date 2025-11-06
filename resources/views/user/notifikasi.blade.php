@extends('layouts.user')

@section('title', 'Detail Produk - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/notifikasi.css') }}">
@endsection

@section('content')
    @include('user.sections.header')
    @include('user.sections.notifikasi')
    @include('user.sections.footer')
@endsection
