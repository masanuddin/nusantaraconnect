@extends(Auth::user()->role === 'vendor' ? 'layouts.vendor' : 'layouts.customer')
@php use Illuminate\Support\Str; @endphp

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">

        {{-- Pop-up informasi pekerjaan dari lamaran --}}
        @if (session()->has('chat_pop'))
            @php
                $pop = session('chat_pop');
                session()->forget('chat_pop');
            @endphp
            <div class="alert alert-success d-flex align-items-center mb-4 mt-5 shadow-sm" style="background-color: #eaf6ef; border-color: #c3e6cb;">
                @if ($pop['thumbnail'])
                    <img src="{{ asset('storage/' . $pop['thumbnail']) }}" class="rounded me-3" style="height: 50px; width: 50px; object-fit: cover;">
                @endif
                <div>
                    <div class="fw-semibold text-success">Pesanan dari Lamaran</div>
                    <div>{{ $pop['pekerjaan_nama'] }}</div>
                    @if (!empty($pop['gaji']))
                        <div class="fw-bold">{{ $pop['gaji'] }}</div>
                    @endif
                </div>
            </div>
        @endif

        <div class="bg-white rounded-4 mt-5 p-4 mb-5">
            {{-- Judul --}}
            <h4 class="fw-bold mb-3" style="color: #7C4B28;">Chat</h4>

            {{-- Area chat --}}
            <div class="border rounded p-3 mb-4" style="max-height: 500px; overflow-y: auto; background-color: #f8f9fa;" id="chat-box">
                @foreach ($chat->messages as $message)
                    @if (Str::startsWith($message->message, '[Lamaran:'))
                        <div class="bg-success-subtle text-dark p-3 rounded mb-3 border border-success-subtle" style="max-width: 75%;">
                            {{ $message->message }}
                        </div>
                    @else
                        <div class="d-flex {{ $message->sender_id === Auth::id() ? 'justify-content-end' : 'justify-content-start' }} mb-2">
                            <div class="chat-bubble {{ $message->sender_id === Auth::id() ? 'chat-left' : 'chat-right' }}">
                                <p class="mb-1">{{ $message->message }}</p>
                                <small class="text-muted d-block text-end" style="font-size: 0.75rem;">
                                    {{ $message->created_at->format('d M Y H:i') }}
                                </small>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- Form kirim pesan --}}
            <form action="{{ route('chat.message.send', $chat->id) }}" method="POST" class="d-flex flex-column gap-2">
                @csrf
                <textarea name="message" class="form-control" rows="3" placeholder="Ketik pesan..." required></textarea>
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn px-3 text-dark border">Kirim</button>
                </div>
            </form>
        </div>

    </div>
</div>

{{-- Styling untuk bubble chat --}}
<style>
    .chat-bubble {
        max-width: 75%;
        padding: 12px 16px;
        border-radius: 15px;
        font-size: 0.95rem;
    }

    .chat-left {
        background-color: #ffffff;
        color: #5c3d25;
        border: 1px solid #e0e0e0;
    }

    .chat-right {
        background-color: #fff7f1;
        color: #5c3d25;
        border: 1px solid #e0e0e0;
    }
</style>
@endsection
