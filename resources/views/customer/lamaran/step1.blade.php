@extends('layouts.customer')

@section('content')
<h2>Informasi Pribadi (PIC)</h2>

<form method="POST" action="{{ route('customer.lamaran.step1.post', $pekerjaan->id) }}" enctype="multipart/form-data" id="lamaranForm">
    @csrf

    {{-- PIC --}}
    <div>
        <label>Nama Depan</label>
        <input type="text" name="nama_depan" required>
    </div>
    <div>
        <label>Nama Belakang</label>
        <input type="text" name="nama_belakang" required>
    </div>
    <div>
        <label>Umur</label>
        <input type="number" name="umur" required>
    </div>
    <div>
        <label>Nomor Telpon</label>
        <input type="text" name="nomor_telpon" required>
    </div>
    <div>
        <label>Alamat Email</label>
        <input type="email" name="email" required>
    </div>
    <div>
        <label>Resume/CV (opsional)</label>
        <input type="file" name="cv" accept=".pdf,.doc,.docx">
    </div>

    <hr>

    {{-- Bagian Anggota --}}
    <div id="anggota-container">
        <h3>Tambah Anggota (jika berkelompok)</h3>
    </div>

    <button type="button" onclick="tambahAnggota()">Tambah! +</button>

    <br><br>
    <button type="submit">Lanjut!</button>
</form>

<script>
    let anggotaIndex = 0;

    function tambahAnggota() {
        const container = document.getElementById('anggota-container');
        const anggotaHTML = `
            <fieldset style="margin-top: 20px; border: 1px solid #ccc; padding: 10px;">
                <legend>Informasi Anggota ${anggotaIndex + 1}</legend>
                <div>
                    <label>Nama Depan</label>
                    <input type="text" name="anggota[${anggotaIndex}][nama_depan]" required>
                </div>
                <div>
                    <label>Nama Belakang</label>
                    <input type="text" name="anggota[${anggotaIndex}][nama_belakang]" required>
                </div>
                <div>
                    <label>Umur</label>
                    <input type="number" name="anggota[${anggotaIndex}][umur]" required>
                </div>
                <div>
                    <label>Nomor Telpon</label>
                    <input type="text" name="anggota[${anggotaIndex}][nomor_telpon]" required>
                </div>
                <div>
                    <label>Alamat Email</label>
                    <input type="email" name="anggota[${anggotaIndex}][email]" required>
                </div>
                <div>
                    <label>Resume/CV (opsional)</label>
                    <input type="file" name="anggota[${anggotaIndex}][cv]" accept=".pdf,.doc,.docx">
                </div>
            </fieldset>
        `;

        container.insertAdjacentHTML('beforeend', anggotaHTML);
        anggotaIndex++;
    }
</script>
@endsection
