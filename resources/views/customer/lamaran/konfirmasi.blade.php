@extends('layouts.customer')

@section('content')
<h2>Konfirmasi Lamaran</h2>

@if (!$step1 || !$step2)
    <p>Data lamaran tidak lengkap. Silakan mulai dari awal.</p>
    <a href="{{ route('customer.pekerjaan') }}">Kembali</a>
@else
    <h3>Data PIC</h3>
    <ul>
        <li>Nama: {{ $step1['nama_depan'] }} {{ $step1['nama_belakang'] }}</li>
        <li>Umur: {{ $step1['umur'] }}</li>
        <li>Telpon: {{ $step1['nomor_telpon'] }}</li>
        <li>Email: {{ $step1['email'] }}</li>
        <li>CV: {{ $step1['cv'] ? 'Sudah diupload' : 'Tidak diupload' }}</li>
    </ul>

    @if (!empty($step1['anggota']))
        <h3>Anggota</h3>
        <ul>
            @foreach ($step1['anggota'] as $index => $anggota)
                <li>
                    <strong>Anggota {{ $index + 1 }}:</strong><br>
                    Nama: {{ $anggota['nama_depan'] }} {{ $anggota['nama_belakang'] }}<br>
                    Umur: {{ $anggota['umur'] }}<br>
                    Telpon: {{ $anggota['nomor_telpon'] }}<br>
                    Email: {{ $anggota['email'] }}<br>
                    CV: {{ isset($anggota['cv']) ? 'Sudah diupload' : 'Tidak diupload' }}
                </li>
            @endforeach
        </ul>
    @endif

    <h3>Pengalaman & Keterangan</h3>
    <ul>
        <li>Pengalaman: {{ $step2['pengalaman_kerja'] }}</li>
        <li>Keterangan: {{ $step2['keterangan_tambahan'] ?? '-' }}</li>
        <li>Video: {{ $step2['video'] ? 'Sudah diupload' : 'Tidak diupload' }}</li>
    </ul>

    <form method="POST" action="{{ route('customer.lamaran.submit', $pekerjaan->id) }}">
        @csrf
        <button type="submit">Lanjut & Kirim Lamaran</button>
    </form>
@endif
@endsection
