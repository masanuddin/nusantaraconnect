@extends('layouts.vendor')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">
        <div class="bg-white rounded-4 p-4 mt-5">
            <h4 class="fw-bold mb-4">Tambah Pekerjaan Baru</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('vendor.pekerjaan.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Thumbnail</label>
                    <input type="file" name="thumbnail" class="form-control" accept="image/*">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Pekerjaan</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Range Harga</label>
                    <input type="text" name="range_harga" class="form-control" value="{{ old('range_harga') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4" required>{{ old('deskripsi') }}</textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Mulai Kerja</label>
                        <input type="date" name="mulai_kerja" class="form-control" value="{{ old('mulai_kerja') }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Selesai Kerja</label>
                        <input type="date" name="selesai_kerja" class="form-control" value="{{ old('selesai_kerja') }}" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-brown text-white px-4 me-2">Simpan</button>
                    <a href="{{ route('vendor.pekerjaan.index') }}" class="btn btn-outline-secondary">Batal</a>
                </div>
            </form>
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
