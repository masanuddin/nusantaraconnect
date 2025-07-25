@extends('layouts.customer')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">
        <div class="card shadow-sm p-4">
            <h4 class="fw-bold mb-4">Konfirmasi Lamaran</h4>

            @if (!$step1 || !$step2)
                <div class="alert alert-warning">
                    Data lamaran tidak lengkap. Silakan mulai dari awal.
                </div>
                <a href="{{ route('customer.pekerjaan') }}" class="btn btn-secondary">Kembali</a>
            @else
                <div class="mb-4">
                    <h5 class="fw-semibold">Data PIC</h5>
                    <ul class="list-group">
                        <li class="list-group-item">Nama: {{ $step1['nama_depan'] }} {{ $step1['nama_belakang'] }}</li>
                        <li class="list-group-item">Umur: {{ $step1['umur'] }}</li>
                        <li class="list-group-item">Telpon: {{ $step1['nomor_telpon'] }}</li>
                        <li class="list-group-item">Email: {{ $step1['email'] }}</li>
                        <li class="list-group-item">CV: {{ $step1['cv'] ? 'Sudah diupload' : 'Tidak diupload' }}</li>
                    </ul>
                </div>

                @if (!empty($step1['anggota']))
                    <div class="mb-4">
                        <h5 class="fw-semibold">Anggota</h5>
                        @foreach ($step1['anggota'] as $index => $anggota)
                            <div class="card mb-3 p-3">
                                <h6 class="fw-bold mb-2">Anggota {{ $index + 1 }}</h6>
                                <p class="mb-1">Nama: {{ $anggota['nama_depan'] }} {{ $anggota['nama_belakang'] }}</p>
                                <p class="mb-1">Umur: {{ $anggota['umur'] }}</p>
                                <p class="mb-1">Telpon: {{ $anggota['nomor_telpon'] }}</p>
                                <p class="mb-1">Email: {{ $anggota['email'] }}</p>
                                <p class="mb-0">CV: {{ isset($anggota['cv']) ? 'Sudah diupload' : 'Tidak diupload' }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="mb-4">
                    <h5 class="fw-semibold">Pengalaman & Keterangan</h5>
                    <ul class="list-group">
                        <li class="list-group-item">Pengalaman: {{ $step2['pengalaman_kerja'] }}</li>
                        <li class="list-group-item">Keterangan: {{ $step2['keterangan_tambahan'] ?? '-' }}</li>
                        <li class="list-group-item">Video: {{ $step2['video'] ? 'Sudah diupload' : 'Tidak diupload' }}</li>
                    </ul>
                </div>

                <form method="POST" action="{{ route('customer.lamaran.submit', $pekerjaan->id) }}">
                    @csrf
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-brown text-white px-4">Lanjut & Kirim Lamaran</button>
                    </div>
                </form>
            @endif
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
