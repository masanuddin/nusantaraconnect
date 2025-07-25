@extends('layouts.vendor')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">
        <div class="mt-5">
            <h4 class="fw-bold text-brown mb-4">Lamaran untuk: {{ $pekerjaan->nama }}</h4>

            @if(session('success'))
                <div class="alert alert-success" style="font-size: 14px;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger" style="font-size: 14px;">
                    {{ session('error') }}
                </div>
            @endif

            @if ($lamarans->isEmpty())
                <p style="font-size: 14px;">Belum ada pelamar untuk pekerjaan ini.</p>
            @else
                <div class="d-flex flex-column gap-4">
                    @foreach ($lamarans as $lamaran)
                        <div class="bg-white rounded-3 p-4">
                            <h5 class="fw-semibold mb-3">Pelamar Utama (PIC)</h5>
                            <ul class="mb-4" style="font-size: 14px;">
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
                                <h6 class="fw-bold">Anggota Kelompok:</h6>
                                @foreach ($lamaran->anggota as $index => $anggota)
                                    <div class="mb-3" style="font-size: 14px;">
                                        <strong>Anggota {{ $index + 1 }}</strong>
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
                                    </div>
                                @endforeach
                            @endif

                            <h6 class="fw-bold">Informasi Tambahan:</h6>
                            <ul class="mb-3" style="font-size: 14px;">
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

                            <p class="mb-3" style="font-size: 14px;">Status Saat Ini: <strong>{{ strtoupper($lamaran->status) }}</strong></p>

                            @if (in_array($lamaran->status, ['pending', 'on_review']))
                                <form action="{{ route('vendor.lamaran.updateStatus', $lamaran->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')

                                    @if ($lamaran->status === 'pending')
                                        <button type="submit" class="btn btn-warning text-white btn-sm">Review</button>
                                    @elseif ($lamaran->status === 'on_review')
                                        <button type="submit" class="btn btn-success btn-sm">Accept</button>
                                    @endif
                                </form>
                            @elseif ($lamaran->status === 'accepted')
                                @php
                                    $chat = \App\Models\Chat::getOrCreate($lamaran->customer_id, $pekerjaan->vendor_id);
                                @endphp
                                <form action="{{ route('chat.redirect') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                                    <input type="hidden" name="pekerjaan_nama" value="{{ $lamaran->pekerjaan->nama }}">
                                    <input type="hidden" name="gaji" value="{{ $lamaran->pekerjaan->range_harga }}">
                                    <input type="hidden" name="thumbnail" value="{{ $lamaran->pekerjaan->thumbnail }}">
                                    <button type="submit" class="btn btn-primary btn-sm">Chat</button>
                                </form>
                            @endif

                            @if ($lamaran->status === 'cancel_approval')
                                <div class="alert alert-warning mt-4" style="font-size: 14px;">
                                    <p class="mb-1"><strong>Alasan Pembatalan dari Pelamar:</strong></p>
                                    <p>{{ $lamaran->cancel_reason }}</p>

                                    <form action="{{ route('vendor.lamaran.approveCancel', $lamaran->id) }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm">Setujui Pembatalan</button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .text-brown {
        color: #8B4513;
    }

    .btn-brown {
        background-color: #7C4B28;
        color: white;
    }

    .btn-brown:hover {
        background-color: #6f4224;
    }
</style>
@endsection
