@extends('layouts.vendor')

@section('content')
    <h2>Lamaran untuk: {{ $pekerjaan->nama }}</h2>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 15px;">
            {{ session('error') }}
        </div>
    @endif


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

                @if (in_array($lamaran->status, ['pending', 'on_review']))
                    <form action="{{ route('vendor.lamaran.updateStatus', $lamaran->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        @if ($lamaran->status === 'pending')
                            <button type="submit">Review</button>
                        @elseif ($lamaran->status === 'on_review')
                            <button type="submit">Accept</button>
                        @endif
                    </form>
                @elseif ($lamaran->status === 'accepted')
                    @php
                        $chat = \App\Models\Chat::getOrCreate($lamaran->customer_id, $pekerjaan->vendor_id);
                    @endphp
                    <form action="{{ route('chat.redirect') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                        <input type="hidden" name="pekerjaan_nama" value="{{ $lamaran->pekerjaan->nama }}">
                        <input type="hidden" name="gaji" value="{{ $lamaran->pekerjaan->range_harga }}">
                        <input type="hidden" name="thumbnail" value="{{ $lamaran->pekerjaan->thumbnail }}">
                        <button type="submit">Chat</button>
                    </form>
                @endif

                @if ($lamaran->status === 'cancel_approval')
                    <div style="background: #fff3cd; padding: 10px; border: 1px solid #ffeeba; margin-top: 10px;">
                        <p><strong>Alasan Pembatalan dari Pelamar:</strong></p>
                        <p>{{ $lamaran->cancel_reason }}</p>

                        <form action="{{ route('vendor.lamaran.approveCancel', $lamaran->id) }}" method="POST" style="margin-top: 10px;">
                            @csrf
                            <button type="submit" style="background: #dc3545; color: white; padding: 8px 16px;">Setujui Pembatalan</button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    @endif
@endsection
