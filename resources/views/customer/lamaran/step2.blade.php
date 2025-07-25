@extends('layouts.customer')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">
        <div class="card shadow-sm p-4">
            <h4 class="fw-bold mb-4">Pengalaman & Keterangan Tambahan</h4>

            <form method="POST" action="{{ route('customer.lamaran.step2.post', $pekerjaan->id) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Berapa tahun pengalaman kerja Anda?</label>
                    <select name="pengalaman_kerja" class="form-select" required>
                        <option value="">-- Pilih Pengalaman --</option>
                        <option value="Dibawah 1 tahun">Dibawah 1 tahun</option>
                        <option value="1 - 3 tahun">1 - 3 tahun</option>
                        <option value="Di atas 3 tahun">Di atas 3 tahun</option>
                        <option value="Belum punya pengalaman">Belum punya pengalaman</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Keterangan Tambahan (opsional)</label>
                    <textarea name="keterangan_tambahan" class="form-control" rows="4" placeholder="Ceritakan pengalaman atau motivasi Anda..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="form-label">Upload Video Pendukung (opsional)</label>
                    <div class="input-group">
                        <input type="file" name="video" class="form-control" accept="video/mp4,video/quicktime,video/x-msvideo">
                        <span class="input-group-text"><i class="bi bi-upload"></i></span>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-brown text-white px-4">Lanjut!</button>
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
