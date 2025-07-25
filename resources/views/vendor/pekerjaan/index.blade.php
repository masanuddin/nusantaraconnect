@extends('layouts.vendor')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">
        <div class="mt-5">
            <h4 class="fw-bold" style="font-family: 'Montserrat', sans-serif; color: #8B4513;">
                Lowongan Pekerjaan Anda
            </h4>

            @if (session('success'))
                <div class="text-success mt-2" style="font-size: 14px;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="d-flex justify-content-end my-4">
                <a href="{{ route('vendor.pekerjaan.create') }}" class="btn btn-brown text-white px-3" style="font-size: 14px; font-weight: 600;">
                    Tambah Pekerjaan Baru +
                </a>
            </div>

            @if ($pekerjaan->isEmpty())
                <p style="font-size: 14px;">Belum ada pekerjaan yang dibuat.</p>
            @else
                <div class="d-flex flex-column gap-4">
                    @foreach ($pekerjaan as $item)
                        <div class="bg-white rounded-3 p-4">
                            <div class="row">
                                <div class="col-md-3 mb-3 mb-md-0">
                                    @if ($item->thumbnail)
                                        <img src="{{ asset('storage/' . $item->thumbnail) }}"
                                             alt="Thumbnail"
                                             class="w-100 rounded"
                                             style="height: 150px; object-fit: cover;">
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h5 class="fw-semibold mb-1">{{ $item->nama }}</h5>
                                    <p class="mb-1" style="font-size: 14px;">Lokasi: {{ $item->lokasi }}</p>
                                    <p class="mb-1" style="font-size: 14px;">Range Harga: {{ $item->range_harga }}</p>
                                    <p class="mb-1" style="font-size: 14px;">Waktu Kerja: {{ $item->mulai_kerja }} s/d {{ $item->selesai_kerja }}</p>
                                    <p class="mb-1" style="font-size: 14px;">Deskripsi: {{ $item->deskripsi }}</p>
                                    <p class="mb-3" style="font-size: 14px;">Dibuat pada: {{ $item->created_at->format('d M Y, H:i') }}</p>

                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="{{ route('vendor.pekerjaan.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning">
                                            Edit
                                        </a>

                                        <a href="{{ route('vendor.pekerjaan.lamaran', $item->id) }}"
                                        class="btn btn-sm btn-secondary">
                                            Lihat Lamaran
                                        </a>

                                        <form action="{{ route('vendor.pekerjaan.destroy', $item->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pekerjaan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
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
