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

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Kamu adalah asisten budaya Indonesia. Bantu customer memahami pekerjaan seperti lokasi, harga, deskripsi.'],
                ['role' => 'user', 'content' => $userMessage],
            ],
        ]);

        return response()->json([
            'reply' => $response['choices'][0]['message']['content'] ?? 'Maaf, terjadi kesalahan.'
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
