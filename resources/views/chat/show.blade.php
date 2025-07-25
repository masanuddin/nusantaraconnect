@extends(Auth::user()->role === 'vendor' ? 'layouts.vendor' : 'layouts.customer')
@php use Illuminate\Support\Str; @endphp

@section('content')
    @if (session()->has('chat_pop'))
        @php
            $pop = session('chat_pop');
            session()->forget('chat_pop'); // hapus manual setelah ditampilkan
        @endphp
        <div style="border: 1px solid #28a745; background: #e9f9ee; padding: 10px; margin-bottom: 20px; display: flex; align-items: center;">
            @if ($pop['thumbnail'])
                <img src="{{ asset('storage/' . $pop['thumbnail']) }}" style="height: 50px; width: 50px; object-fit: cover; margin-right: 15px;">
            @endif
            <div>
                <div style="color: green; font-weight: bold;">Pesanan dari Lamaran</div>
                <div>{{ $pop['pekerjaan_nama'] }}</div>
                @if (!empty($pop['gaji']))
                    <div><strong>{{ $pop['gaji'] }}</strong></div>
                @endif
            </div>
        </div>
    @endif

    <h2>Chat</h2>

    <div style="max-height: 400px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; margin-bottom: 20px;">
        @foreach ($chat->messages as $message)
            <div style="margin-bottom: 10px;">
                @if (Str::startsWith($message->message, '[Lamaran:'))
                    <div style="background: #e1f7e1; border: 1px solid #28a745; padding: 10px;">
                        {{ $message->message }}
                    </div>
                @else
                    <strong>{{ $message->sender->name ?? 'System' }}:</strong>
                    <p style="margin: 0;">{{ $message->message }}</p>
                    <small>{{ $message->created_at->format('d M Y H:i') }}</small>
                @endif
            </div>
        @endforeach
    </div>

    <form action="{{ route('chat.message.send', $chat->id) }}" method="POST">
        @csrf
        <textarea name="message" rows="3" style="width:100%;" required></textarea>
        <button type="submit" style="margin-top: 10px;">Kirim</button>
    </form>
@endsection
