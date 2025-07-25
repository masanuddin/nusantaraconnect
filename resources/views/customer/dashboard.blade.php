@extends('layouts.customer')

@section('content')
<div class="d-flex justify-content-center mt-5">
    <div style="width: 100%; max-width: 1200px;">

        {{-- Welcome Card --}}
        <div class="card border-0 rounded-3 p-4 mb-3">
            <div style="height: 310px" class="row g-4 align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-2" style="color: #5c3d25;">Halo, {{ Auth::user()->name }} 👋</h2>
                    <p class="text-muted mb-3" style="font-size: 1rem;">
                        Selamat datang di <strong>NusantaraConnect</strong> – jembatan antara pelaku budaya & pencari talenta budaya di Indonesia!
                    </p>
                    <p class="text-dark">Temukan dan lamar pekerjaan budaya, mulai dari festival lokal hingga event nasional!</p>
                    <a href="#job-board" class="btn rounded-3 fw-semibold mt-2 px-4 py-2" style="background-color: #f4e5dc; color: #5c3d25;">
                        Lihat Lowongan Budaya
                    </a>
                </div>
                <div class="col-md-4 text-center">
                    <img style="position: relative; top: -65px; width: 250px;" src="{{ asset('images/illustration_budaya.png') }}" alt="Ilustrasi Budaya" class="img-fluid">
                </div>
            </div>
        </div>

        {{-- Fitur Info --}}
        <div class="row g-4 mb-3">
            <div class="col-md-4">
                <div class="p-4 rounded-3 h-100 bg-white">
                    <h5 class="fw-bold text-dark mb-2">💼 Job Budaya</h5>
                    <p class="text-muted small">Temukan lowongan tampil di festival, kampus, atau komunitas budaya di berbagai daerah.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-3 h-100 bg-white">
                    <h5 class="fw-bold text-dark mb-2">🎭 Profil Performer</h5>
                    <p class="text-muted small">Lengkapi skill budaya, komunitas, dan pengalamanmu. Sistem akan bantu cocokkan dengan lowongan!</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 rounded-3 h-100 bg-white">
                    <h5 class="fw-bold text-dark mb-2">📚 Facts about Tari Piring!</h5>
                    <p class="text-muted small">Tari Piring adalah tarian khas Minangkabau yang dibawakan dengan gerakan cepat sambil membawa piring.</p>
                </div>
            </div>
        </div>

        {{-- AI Chatbot Section --}}
        <div style="height: 310px" class="card border-0 rounded-3 p-4 mb-5 bg-white">
            <div class="row align-items-center">
                <div class="col-md-4 text-center">
                    <img style="position: relative; top: -90px; width: 250px;" src="{{ asset('images/ai_chatbot_illustration.png') }}" alt="Asisten Budaya AI" class="img-fluid rounded-3">
                </div>
                <div class="col-md-8">
                    <h5 class="fw-bold text-dark mb-2">🎙 Asisten Budaya (AI Chatbot)</h5>
                    <p class="text-muted" style="font-size: 0.95rem;">
                        Bingung mencari pekerjaan budaya yang cocok? Coba ngobrol dengan <strong>Asisten Budaya</strong> kami!
                        Fitur AI ini siap menjawab pertanyaanmu seputar event budaya, lokasi tampil, hingga rekomendasi pekerjaan.
                    </p>
                    <a href="{{ route('customer.chatbot') }}" class="btn rounded-3 fw-semibold px-4 py-2 mt-2" style="background-color: #e3f4f1; color: #2f4f4f;">
                        Coba Sekarang
                    </a>
                </div>
            </div>
        </div>


        {{-- Job Board --}}
        <div id="job-board" class="card border-0 rounded-3 p-4 mb-5 bg-white">
            <h4 class="fw-bold text-dark mb-4">🎯 Kesempatan Budaya Terkini</h4>

            @if ($pekerjaan->isEmpty())
                <div class="alert alert-warning text-center rounded-3 py-2" style="font-size: 13.5px;">Belum ada pekerjaan tersedia saat ini.</div>
            @else
                <div class="row row-cols-1 row-cols-md-3 g-3">
                    @foreach ($pekerjaan as $item)
                        <div class="col">
                            <div class="card border-0 pekerjaan-item rounded-3 shadow-sm p-0"
                                style="cursor: pointer; font-size: 13.5px;"
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
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" 
                                        class="card-img-top rounded-top-3" 
                                        style="height: 120px; object-fit: cover;" 
                                        alt="Thumbnail">
                                @endif

                                <div class="card-body px-3 py-2">
                                    <h6 class="fw-semibold text-dark mb-1" style="font-size: 14px;">{{ $item->nama }}</h6>
                                    <div class="text-muted">{{ $item->perusahaan ?? 'CV TALENTAMUDA' }}</div>
                                    <div class="text-secondary">{{ $item->lokasi }}</div>
                                    <div class="text-secondary">{{ $item->range_harga ?? 'Tarian (Performance)' }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="mt-5">
                <div class="bg-white p-4 rounded-3" id="detail-container" style="min-height: 300px;">
                    <p class="text-muted">Klik salah satu pekerjaan di atas untuk melihat detailnya di sini.</p>
                </div>
            </div>
        </div>

        {{-- Detail Pekerjaan --}}
        
    </div>
</div>

{{-- Script for interactive job detail --}}
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
