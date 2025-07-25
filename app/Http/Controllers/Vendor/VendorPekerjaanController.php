<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pekerjaan;
use Illuminate\Support\Facades\Auth;
use App\Models\Lamaran;
use App\Models\AnggotaLamaran;

class VendorPekerjaanController extends Controller
{
    public function index()
    {
        $pekerjaan = Pekerjaan::where('vendor_id', Auth::id())->latest()->get();
        return view('vendor.pekerjaan.index', compact('pekerjaan'));
    }

    public function create()
    {
        return view('vendor.pekerjaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'range_harga' => 'required',
            'deskripsi' => 'required',
            'mulai_kerja' => 'required|date',
            'selesai_kerja' => 'required|date|after_or_equal:mulai_kerja',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Pekerjaan::create([
            'vendor_id' => Auth::id(),
            'nama' => $request->nama,
            'lokasi' => $request->lokasi,
            'range_harga' => $request->range_harga,
            'deskripsi' => $request->deskripsi,
            'mulai_kerja' => $request->mulai_kerja,
            'selesai_kerja' => $request->selesai_kerja,
            'thumbnail' => $thumbnailPath
        ]);

        return redirect()->route('vendor.pekerjaan.index')->with('success', 'Pekerjaan berhasil ditambahkan.');
    }

    public function edit(Pekerjaan $pekerjaan)
    {
        return view('vendor.pekerjaan.edit', compact('pekerjaan'));
    }

    public function update(Request $request, Pekerjaan $pekerjaan)
    {
        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'range_harga' => 'required',
            'deskripsi' => 'required',
            'mulai_kerja' => 'required|date',
            'selesai_kerja' => 'required|date|after_or_equal:mulai_kerja',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only([
            'nama', 'lokasi', 'range_harga', 'deskripsi',
            'mulai_kerja', 'selesai_kerja'
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = $thumbnailPath;
        }

        $pekerjaan->update($data);

        return redirect()->route('vendor.pekerjaan.index')->with('success', 'Pekerjaan berhasil diperbarui.');
    }

    public function destroy(Pekerjaan $pekerjaan)
    {
        $pekerjaan->delete();
        return redirect()->route('vendor.pekerjaan.index')->with('success', 'Pekerjaan berhasil dihapus.');
    }
    
    public function lamaran(Pekerjaan $pekerjaan)
    {
        // Pastikan hanya vendor pemilik pekerjaan ini yang bisa melihatnya
        if ($pekerjaan->vendor_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke pekerjaan ini.');
        }

        // Ambil semua lamaran untuk pekerjaan ini, beserta anggota masing-masing
        $lamarans = Lamaran::with('anggota')
            ->where('pekerjaan_id', $pekerjaan->id)
            ->latest()
            ->get();

        return view('vendor.pekerjaan.lamaran', compact('pekerjaan', 'lamarans'));
    }

    public function updateStatus(Request $request, Lamaran $lamaran)
    {
        $nextStatus = null;

        if ($lamaran->status === 'pending') {
            $nextStatus = 'on_review';
        } elseif ($lamaran->status === 'on_review') {
            $nextStatus = 'accepted';
        }

        if ($nextStatus) {
            $lamaran->update(['status' => $nextStatus]);
        }

        return back()->with('success', 'Status lamaran berhasil diperbarui.');
    }

    public function approveCancel(Request $request, Lamaran $lamaran)
    {
        // Pastikan hanya vendor pemilik pekerjaan ini yang bisa menyetujui pembatalan
        if ($lamaran->pekerjaan->vendor_id !== Auth::id()) {
            abort(403, 'Tidak diizinkan.');
        }

        if ($lamaran->status !== 'cancel_approval') {
            return back()->with('error', 'Status lamaran tidak valid untuk approval cancel.');
        }

        $lamaran->update([
            'status' => 'cancelled',
        ]);

        return back()->with('success', 'Pembatalan lamaran telah disetujui.');
    }
}
