@extends('layouts.customer')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">
        <div class="card shadow-sm p-5 text-center">
            <h4 class="fw-bold mb-3">Lamaran Berhasil Dikirim</h4>
            <p class="fs-5">Selamat! Anda telah berhasil mengisi dan mengirimkan lamaran pekerjaan ini.</p>
            <p class="text-muted">Tim vendor akan segera meninjau lamaran Anda. Terima kasih telah menggunakan platform ini!</p>

            <div class="mt-4">
                <a href="{{ route('customer.dashboard') }}" class="btn btn-brown text-white px-4">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-brown {
        background-color: #7C4B28;
    }

    .btn-brown:hover {
        background-color: #6f4224;
    }
</style>
@endsection
