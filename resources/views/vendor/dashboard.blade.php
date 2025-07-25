@extends('layouts.vendor')

@section('content')
    <h1>Selamat Datang di Dashboard Vendor</h1>

    <p>Halo, {{ Auth::user()->name }}! Ini adalah halaman utama Anda sebagai vendor.</p>

    <p>Gunakan sidebar di kiri untuk mengelola pekerjaan Anda.</p>
@endsection
