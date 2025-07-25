@extends('layouts.vendor')

@section('content')
    <h1>Tambah Pekerjaan Baru</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('vendor.pekerjaan.store') }}" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 10px;">
            <label>Thumbnail:</label><br>
            <input type="file" name="thumbnail" accept="image/*">
        </div>

        <div style="margin-bottom: 10px;">
            <label>Nama:</label><br>
            <input type="text" name="nama" value="{{ old('nama') }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Lokasi:</label><br>
            <input type="text" name="lokasi" value="{{ old('lokasi') }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Range Harga:</label><br>
            <input type="text" name="range_harga" value="{{ old('range_harga') }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Deskripsi:</label><br>
            <textarea name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Mulai Kerja:</label><br>
            <input type="date" name="mulai_kerja" value="{{ old('mulai_kerja') }}" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label>Selesai Kerja:</label><br>
            <input type="date" name="selesai_kerja" value="{{ old('selesai_kerja') }}" required>
        </div>

        <button type="submit">Simpan</button>
        <a href="{{ route('vendor.pekerjaan.index') }}">Batal</a>
    </form>
@endsection
