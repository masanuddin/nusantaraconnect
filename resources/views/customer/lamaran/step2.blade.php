@extends('layouts.customer')

@section('content')
<h2>Pengalaman & Keterangan Tambahan</h2>

<form method="POST" action="{{ route('customer.lamaran.step2.post', $pekerjaan->id) }}" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Berapa tahun pengalaman kerja Anda?</label><br>
        <select name="pengalaman_kerja" required>
            <option value="">-- Pilih Pengalaman --</option>
            <option value="Dibawah 1 tahun">Dibawah 1 tahun</option>
            <option value="1 - 3 tahun">1 - 3 tahun</option>
            <option value="Di atas 3 tahun">Di atas 3 tahun</option>
            <option value="Belum punya pengalaman">Belum punya pengalaman</option>
        </select>
    </div>

    <div style="margin-top: 15px;">
        <label>Keterangan Tambahan (opsional)</label><br>
        <textarea name="keterangan_tambahan" rows="4" placeholder="Ceritakan pengalaman atau motivasi Anda..."></textarea>
    </div>

    <div style="margin-top: 15px;">
        <label>Upload Video Pendukung (opsional)</label><br>
        <input type="file" name="video" accept="video/mp4,video/quicktime,video/x-msvideo">
    </div>

    <br>
    <button type="submit">Lanjut</button>
</form>
@endsection
