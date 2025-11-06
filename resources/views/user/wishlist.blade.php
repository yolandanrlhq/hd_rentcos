@extends('layouts.user')

@section('title', 'Detail Produk - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/produk.css') }}">
@endsection

@section('content')
    @include('user.sections.header')
    @include('user.sections.wishlist')
    @include('user.sections.footer')
@endsection
