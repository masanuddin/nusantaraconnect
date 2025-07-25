@extends('layouts.customer')

@section('content')
    <h2>Lamaran Berhasil Dikirim</h2>
    <p>Selamat! Anda telah berhasil mengisi dan mengirimkan lamaran pekerjaan ini.</p>

    <p>Tim vendor akan segera meninjau lamaran Anda. Terima kasih telah menggunakan platform ini!</p>

    <a href="{{ route('customer.dashboard') }}">Kembali ke Dashboard</a>
@endsection
