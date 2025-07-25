@extends('layouts.customer')

@section('content')
    <h1>Selamat Datang, {{ Auth::user()->name }}</h1>
    <p>Ini adalah dashboard Anda sebagai customer.</p>
@endsection
