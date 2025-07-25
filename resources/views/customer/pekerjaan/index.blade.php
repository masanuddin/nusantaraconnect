@extends('layouts.customer')

@section('content')
    <h1>Daftar Pekerjaan</h1>
    
    @if ($pekerjaan->isEmpty())
        <p>Tidak ada pekerjaan tersedia saat ini.</p>
    @else
        <ul style="padding-left: 0;">
            @foreach ($pekerjaan as $item)
                <li style="margin-bottom: 30px; list-style: none; border-bottom: 1px solid #ccc; padding-bottom: 20px;">
                    @if ($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="Thumbnail" width="200" style="margin-bottom: 10px;"><br>
                    @endif

                    <strong>{{ $item->nama }}</strong><br>
                    <small>{{ $item->lokasi }} | {{ $item->range_harga }}</small><br>
                    <p>{{ $item->deskripsi }}</p>
                    <p><strong>Waktu:</strong> {{ $item->mulai_kerja }} s/d {{ $item->selesai_kerja }}</p>

                    {{-- Placeholder untuk tombol apply --}}
                    <a href="{{ route('customer.lamaran.step1', $item->id) }}">
                        <button>Lamar</button>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
