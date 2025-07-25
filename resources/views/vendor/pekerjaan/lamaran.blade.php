@extends('layouts.vendor')

@section('content')
    <h2>Lamaran untuk: {{ $pekerjaan->nama }}</h2>

    @if ($lamarans->isEmpty())
        <p>Belum ada pelamar untuk pekerjaan ini.</p>
    @else
        @foreach ($lamarans as $lamaran)
            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
                <h3>Pelamar Utama (PIC)</h3>
                <ul>
                    <li>Nama: {{ $lamaran->nama_depan }} {{ $lamaran->nama_belakang }}</li>
                    <li>Umur: {{ $lamaran->umur }}</li>
                    <li>Telpon: {{ $lamaran->nomor_telpon }}</li>
                    <li>Email: {{ $lamaran->email }}</li>
                    <li>CV: 
                        @if ($lamaran->cv)
                            <a href="{{ asset('storage/' . $lamaran->cv) }}" target="_blank">Lihat CV</a>
                        @else
                            Tidak ada
                        @endif
                    </li>
                </ul>

                @if ($lamaran->anggota->isNotEmpty())
                    <h4>Anggota Kelompok:</h4>
                    @foreach ($lamaran->anggota as $index => $anggota)
                        <p><strong>Anggota {{ $index + 1 }}</strong></p>
                        <ul>
                            <li>Nama: {{ $anggota->nama_depan }} {{ $anggota->nama_belakang }}</li>
                            <li>Umur: {{ $anggota->umur }}</li>
                            <li>Telpon: {{ $anggota->nomor_telpon }}</li>
                            <li>Email: {{ $anggota->email }}</li>
                            <li>CV: 
                                @if ($anggota->cv)
                                    <a href="{{ asset('storage/' . $anggota->cv) }}" target="_blank">Lihat CV</a>
                                @else
                                    Tidak ada
                                @endif
                            </li>
                        </ul>
                    @endforeach
                @endif

                <h4>Informasi Tambahan:</h4>
                <ul>
                    <li>Pengalaman Kerja: {{ $lamaran->pengalaman_kerja }}</li>
                    <li>Keterangan: {{ $lamaran->keterangan_tambahan ?? '-' }}</li>
                    <li>Video: 
                        @if ($lamaran->video)
                            <a href="{{ asset('storage/' . $lamaran->video) }}" target="_blank">Lihat Video</a>
                        @else
                            Tidak ada
                        @endif
                    </li>
                </ul>

                <p>Status Saat Ini: <strong>{{ strtoupper($lamaran->status) }}</strong></p>

                <form action="{{ route('vendor.lamaran.updateStatus', $lamaran->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    @if ($lamaran->status === 'pending')
                        <button type="submit">Review</button>
                    @elseif ($lamaran->status === 'on_review')
                        <button type="submit">Accept</button>
                    @elseif ($lamaran->status === 'accepted')
                        <button disabled>Chat</button> <!-- tombol nonaktif (nanti fitur chat menyusul) -->
                    @endif
                </form>
            </div>
        @endforeach
    @endif
@endsection
