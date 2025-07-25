<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'customer') {
            $chats = Chat::with('vendor')
                ->where('customer_id', $user->id)
                ->get();
        } elseif ($user->role === 'vendor') {
            $chats = Chat::with('customer')
                ->where('vendor_id', $user->id)
                ->get();
        } else {
            abort(403, 'Unauthorized');
        }

        return view('chat.index', compact('chats'));
    }

    public function show(Chat $chat)
    {
        $user = Auth::user();

        // Hanya customer atau vendor yang terkait boleh mengakses
        if (!in_array($user->id, [$chat->customer_id, $chat->vendor_id])) {
            abort(403, 'Unauthorized');
        }

        $chat->load('messages.sender');

        return view('chat.show', compact('chat'));
    }

    public function sendMessage(Request $request, Chat $chat)
    {
        $user = Auth::user();

        // Hanya vendor atau customer yang berhak
        if (!in_array($user->id, [$chat->customer_id, $chat->vendor_id])) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        Message::create([
            'chat_id' => $chat->id,
            'sender_id' => $user->id,
            'message' => $request->message,
        ]);

        return redirect()->route('chat.show', $chat->id);
    }

    public function redirectToChat(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|integer|exists:chats,id',
            'pekerjaan_nama' => 'required|string',
            'gaji' => 'nullable|string',
            'thumbnail' => 'nullable|string',
        ]);

        session([
            'chat_pop' => [
                'pekerjaan_nama' => $request->pekerjaan_nama,
                'gaji' => $request->gaji,
                'thumbnail' => $request->thumbnail,
            ]
        ]);

        $pattern = '[Lamaran: ' . $request->pekerjaan_nama . '] Gaji: ' . ($request->gaji ?? '-');

        $existingMessage = Message::where('chat_id', $request->chat_id)
            ->where('sender_id', Auth::id())
            ->where('message', $pattern)
            ->first();

        if (!$existingMessage) {
            Message::create([
                'chat_id' => $request->chat_id,
                'sender_id' => Auth::id(),
                'message' => $pattern,
            ]);
        }

        return redirect()->route('chat.show', ['chat' => $request->chat_id]);
    }
}
