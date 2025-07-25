<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pekerjaan;
use App\Models\Lamaran;
use App\Models\AnggotaLamaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LamaranController extends Controller
{
    public function step1(Pekerjaan $pekerjaan)
    {
        return view('customer.lamaran.step1', compact('pekerjaan'));
    }

    public function step1Post(Request $request, Pekerjaan $pekerjaan)
    {
        $data = $request->validate([
            'nama_depan' => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'umur' => 'required|integer|min:10',
            'nomor_telpon' => 'required|string',
            'email' => 'required|email',
            'cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',

            'anggota' => 'array',
            'anggota.*.nama_depan' => 'required|string',
            'anggota.*.nama_belakang' => 'required|string',
            'anggota.*.umur' => 'required|integer',
            'anggota.*.nomor_telpon' => 'required|string',
            'anggota.*.email' => 'required|email',
            'anggota.*.cv' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cv', 'public');
        }

        // Simpan sementara di session
        $anggotaData = [];

        if (!empty($request->anggota)) {
            foreach ($request->anggota as $anggota) {
                $anggotaCvPath = null;

                if (isset($anggota['cv']) && $anggota['cv'] instanceof \Illuminate\Http\UploadedFile) {
                    $anggotaCvPath = $anggota['cv']->store('cv_anggota', 'public');
                }

                $anggotaData[] = [
                    'nama_depan' => $anggota['nama_depan'],
                    'nama_belakang' => $anggota['nama_belakang'],
                    'umur' => $anggota['umur'],
                    'nomor_telpon' => $anggota['nomor_telpon'],
                    'email' => $anggota['email'],
                    'cv' => $anggotaCvPath
                ];
            }
        }

        session([
            'lamaran_step1' => [
                'pekerjaan_id' => $pekerjaan->id,
                'customer_id' => Auth::id(),
                'nama_depan' => $data['nama_depan'],
                'nama_belakang' => $data['nama_belakang'],
                'umur' => $data['umur'],
                'nomor_telpon' => $data['nomor_telpon'],
                'email' => $data['email'],
                'cv' => $cvPath,
                'anggota' => $anggotaData,
            ]
        ]);


        return redirect()->route('customer.lamaran.step2', $pekerjaan->id);
    }

    public function step2(Pekerjaan $pekerjaan)
    {
        return view('customer.lamaran.step2', compact('pekerjaan'));
    }

    public function step2Post(Request $request, Pekerjaan $pekerjaan)
    {
        $data = $request->validate([
            'pengalaman_kerja' => 'required|string',
            'keterangan_tambahan' => 'nullable|string',
            'video' => 'nullable|file|mimes:mp4,mov,avi|max:10240',
        ]);

        $videoPath = null;
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video')->store('video', 'public');
        }

        session([
            'lamaran_step2' => [
                'pengalaman_kerja' => $data['pengalaman_kerja'],
                'keterangan_tambahan' => $data['keterangan_tambahan'],
                'video' => $videoPath
            ]
        ]);

        return redirect()->route('customer.lamaran.konfirmasi', $pekerjaan->id);
    }

    public function konfirmasi(Pekerjaan $pekerjaan)
    {
        $step1 = session('lamaran_step1');
        $step2 = session('lamaran_step2');

        return view('customer.lamaran.konfirmasi', compact('pekerjaan', 'step1', 'step2'));
    }

    public function submit(Request $request, Pekerjaan $pekerjaan)
    {
        $step1 = session('lamaran_step1');
        $step2 = session('lamaran_step2');

        $lamaran = Lamaran::create([
            ...$step1,
            ...$step2,
        ]);

        foreach ($step1['anggota'] as $anggota) {
            AnggotaLamaran::create([
                'lamaran_id' => $lamaran->id,
                'nama_depan' => $anggota['nama_depan'],
                'nama_belakang' => $anggota['nama_belakang'],
                'umur' => $anggota['umur'],
                'nomor_telpon' => $anggota['nomor_telpon'],
                'email' => $anggota['email'],
                'cv' => $anggota['cv'] ?? null, // optional handling CV per anggota
            ]);
        }

        // Hapus session
        session()->forget(['lamaran_step1', 'lamaran_step2']);

        return redirect()->route('customer.lamaran.selesai');
    }

    public function selesai()
    {
        return view('customer.lamaran.selesai');
    }

    public function index()
    {
        $lamarans = Lamaran::with('pekerjaan')
            ->where('customer_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.lamaran.index', compact('lamarans'));
    }

}
