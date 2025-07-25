@extends('layouts.customer')

@section('content')
<div class="d-flex justify-content-center mt-4">
    <div style="width: 100%; max-width: 1200px;">

        {{-- Filter --}}
        <div class="card shadow-sm border-0 rounded-3 p-4 mb-5 bg-light">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="kategori" class="form-label fw-semibold text-dark">Kategori Budaya</label>
                    <select id="kategori" class="form-select rounded-3 bg-white text-secondary">
                        <option selected>Pilih klasifikasi</option>
                        {{-- Tambahkan opsi --}}
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="lokasi" class="form-label fw-semibold text-dark">Lokasi</label>
                    <select id="lokasi" class="form-select rounded-3 bg-white text-secondary">
                        <option selected>Pilih provinsi</option>
                        {{-- Tambahkan opsi --}}
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    <button type="submit" class="btn rounded-3 fw-semibold px-4 py-2" style="background-color: #f4e5dc; color: #5c3d25;">
                        Cari <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>

        {{-- List + Detail --}}
        <div class="row g-4">
            {{-- List Kiri --}}
            <div class="col-md-4">
                @if ($pekerjaan->isEmpty())
                    <div class="alert alert-warning text-center rounded-3">Tidak ada pekerjaan tersedia saat ini.</div>
                @else
                    <div class="d-flex flex-column gap-3">
                        @foreach ($pekerjaan as $item)
                            <div class="card shadow-sm border-0 rounded-3 pekerjaan-item p-0"
                                style="cursor: pointer; transition: 0.3s;"
                                data-id="{{ $item->id }}"
                                data-nama="{{ $item->nama }}"
                                data-perusahaan="{{ $item->perusahaan ?? 'CV TALENTAMUDA' }}"
                                data-lokasi="{{ $item->lokasi }}"
                                data-kategori="{{ $item->range_harga ?? 'Tarian (Performance)' }}"
                                data-deskripsi="{{ $item->deskripsi }}"
                                data-thumbnail="{{ asset('storage/' . $item->thumbnail) }}"
                                data-waktu="{{ $item->mulai_kerja }} s/d {{ $item->selesai_kerja }}"
                                data-link="{{ route('customer.lamaran.step1', $item->id) }}">
                                
                                @if ($item->thumbnail)
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" class="rounded-top-4" style="height: 160px; width: 100%; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h6 class="fw-bold text-dark mb-1">{{ $item->nama }}</h6>
                                    <div class="text-muted small">{{ $item->perusahaan ?? 'CV TALENTAMUDA' }}</div>
                                    <div class="text-secondary small">{{ $item->lokasi }}</div>
                                    <div class="text-secondary small">{{ $item->range_harga ?? 'Tarian (Performance)' }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Detail Kanan --}}
            <div class="col-md-8">
                <div class="bg-white p-4 rounded-3 shadow-sm" id="detail-container" style="min-height: 350px;">
                    <p class="text-muted">Pilih salah satu pekerjaan untuk melihat detail di sini.</p>
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Script --}}
<script>
    document.querySelectorAll('.pekerjaan-item').forEach(item => {
        item.addEventListener('click', function () {
            const detailHTML = `
                <img src="${this.dataset.thumbnail}" class="img-fluid rounded-3 mb-3" style="max-height: 300px; object-fit: cover;" />
                <h5 class="fw-bold">${this.dataset.nama}</h5>
                <p class="mb-1 text-muted fw-semibold">${this.dataset.perusahaan}</p>
                <p class="mb-1 text-secondary">${this.dataset.lokasi}</p>
                <p class="mb-2 text-secondary">${this.dataset.kategori}</p>
                <a href="${this.dataset.link}" class="btn rounded-3 fw-semibold mb-4" style="background-color: #f4e5dc; color: #5c3d25;">Lamar Sekarang</a>
                <h6 class="fw-bold">Deskripsi Pekerjaan</h6>
                <p>${this.dataset.deskripsi}</p>
                <p><strong>Waktu:</strong> ${this.dataset.waktu}</p>
            `;
            document.getElementById('detail-container').innerHTML = detailHTML;
        });
    });
</script>
@endsection
