<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pekerjaan;
use App\Models\Lamaran;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
        return view('customer.dashboard');
    }

    public function listPekerjaan()
    {
        $pekerjaan = Pekerjaan::latest()->get();
        return view('customer.pekerjaan.index', compact('pekerjaan'));
    }

    // Tampilkan halaman chatbot
    public function chatbot()
    {
        return view('customer.chatbot');
    }

    // Proses request ke OpenAI
    public function askChatbot(Request $request)
    {
        $userMessage = $request->input('message');

        // 1. Coba cari apakah pesan mengandung kata kunci lokasi
        preg_match('/di (\w+)/i', $userMessage, $matches);

        // Default response
        $responseText = 'Maaf, saya tidak menemukan pekerjaan yang cocok.';

        if ($matches && isset($matches[1])) {
            $lokasi = $matches[1];

            // 2. Query data pekerjaan yang cocok
            $pekerjaans = Pekerjaan::where('lokasi', 'LIKE', '%' . $lokasi . '%')->get();

            if ($pekerjaans->count()) {
                $resultText = "Berikut pekerjaan yang tersedia di " . ucfirst($lokasi) . ":\n";

                foreach ($pekerjaans as $job) {
                    $resultText .= "- {$job->nama}, Harga: {$job->range_harga}, Tanggal: {$job->mulai_kerja} s/d {$job->selesai_kerja}\nDeskripsi: {$job->deskripsi}\n\n";
                }

                $responseText = $resultText;
            }
        } else {
            // Jika tidak ada keyword spesifik → kirim ke OpenAI biasa
            $ai = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'system', 'content' => 'Kamu adalah asisten budaya Indonesia. Jawablah dengan sopan.'],
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ]);

            $responseText = $ai['choices'][0]['message']['content'] ?? 'Maaf, terjadi kesalahan.';
        }

        return response()->json([
            'reply' => $responseText
        ]);
    }


    public function listLamaranSaya()
    {
        $lamarans = Lamaran::with('pekerjaan')
            ->where('customer_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.lamaran.index', compact('lamarans'));
    }
}
