@extends('layouts.user')

@section('title', 'Keranjang - HD RENTCOS')

@section('extra-css')
<link rel="stylesheet" href="{{ asset('css/') }}">
@endsection

@section('content')
    @include('user.sections.header')
    @include('user.sections.sewa')
    @include('user.sections.footer')
@endsection
