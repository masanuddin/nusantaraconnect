@extends('layouts.vendor')

@section('content')
    <h1>Daftar Pekerjaan Anda</h1>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <a href="{{ route('vendor.pekerjaan.create') }}" style="display:inline-block; margin-bottom: 15px;">+ Tambah Pekerjaan Baru</a>

    @if ($pekerjaan->isEmpty())
        <p>Belum ada pekerjaan yang dibuat.</p>
    @else
        <ul style="padding-left: 20px;">
            @foreach ($pekerjaan as $item)
                <li style="margin-bottom: 30px; border-bottom: 1px solid #ccc; padding-bottom: 15px;">
                    @if ($item->thumbnail)
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="Thumbnail" width="200" style="margin-bottom: 10px;"><br>
                    @endif

                    <strong>{{ $item->nama }}</strong><br>
                    Lokasi: {{ $item->lokasi }}<br>
                    Range Harga: {{ $item->range_harga }}<br>
                    Waktu Kerja: {{ $item->mulai_kerja }} s/d {{ $item->selesai_kerja }}<br>
                    Deskripsi: {{ $item->deskripsi }}<br>
                    Dibuat pada: {{ $item->created_at->format('d M Y, H:i') }}<br>

                    <a href="{{ route('vendor.pekerjaan.edit', $item->id) }}">Edit</a>

                    <a href="{{ route('vendor.pekerjaan.lamaran', $item->id) }}">Lihat Lamaran</a>

                    <form action="{{ route('vendor.pekerjaan.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus pekerjaan ini?')">Hapus</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
