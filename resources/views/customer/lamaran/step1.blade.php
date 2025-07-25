@extends('layouts.customer')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">
        <div class="card shadow-sm p-4">
            <h4 class="fw-bold mb-4">Informasi Pribadi (PIC)</h4>

            <form method="POST" action="{{ route('customer.lamaran.step1.post', $pekerjaan->id) }}" enctype="multipart/form-data" id="lamaranForm">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Depan</label>
                        <input type="text" name="nama_depan" class="form-control" placeholder="Isi nama depanmu" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Belakang</label>
                        <input type="text" name="nama_belakang" class="form-control" placeholder="Isi nama depanmu" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Umur</label>
                        <input type="number" name="umur" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Telpon</label>
                        <input type="text" name="nomor_telpon" class="form-control" placeholder="awali dengan +62" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat E-mail</label>
                    <input type="email" name="email" class="form-control" placeholder="Pastikan email terdaftar" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Resume/CV (opsional, menyesuaikan pelamar)</label>
                    <div class="input-group">
                        <input type="file" name="cv" class="form-control" accept=".pdf,.doc,.docx">
                        <span class="input-group-text"><i class="bi bi-plus"></i></span>
                    </div>
                </div>

                <div class="border-top pt-4 mt-4">
                    <h5 class="fw-semibold mb-3">Tambah Anggota (jika berkelompok)</h5>
                    <div id="anggota-container"></div>

                    <button type="button" class="btn btn-outline-secondary" onclick="tambahAnggota()">
                        Tambah! <i class="bi bi-plus"></i>
                    </button>
                </div>

                <div class="d-flex justify-content-end mt-4">
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

<script>
    let anggotaIndex = 0;

    function tambahAnggota() {
        const container = document.getElementById('anggota-container');
        const anggotaHTML = `
            <fieldset class="border p-3 mb-3">
                <legend class="float-none w-auto px-2">Informasi Anggota ${anggotaIndex + 1}</legend>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Depan</label>
                        <input type="text" name="anggota[${anggotaIndex}][nama_depan]" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Belakang</label>
                        <input type="text" name="anggota[${anggotaIndex}][nama_belakang]" class="form-control" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Umur</label>
                        <input type="number" name="anggota[${anggotaIndex}][umur]" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nomor Telpon</label>
                        <input type="text" name="anggota[${anggotaIndex}][nomor_telpon]" class="form-control" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat Email</label>
                    <input type="email" name="anggota[${anggotaIndex}][email]" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Resume/CV (opsional)</label>
                    <input type="file" name="anggota[${anggotaIndex}][cv]" class="form-control" accept=".pdf,.doc,.docx">
                </div>
            </fieldset>
        `;
        container.insertAdjacentHTML('beforeend', anggotaHTML);
        anggotaIndex++;
    }
</script>
@endsection
