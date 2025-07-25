@extends(Auth::user()->role === 'vendor' ? 'layouts.vendor' : 'layouts.customer')

@section('content')
    <h2>Daftar Chat</h2>

    @if ($chats->isEmpty())
        <p>Belum ada percakapan.</p>
    @else
        <ul>
            @foreach ($chats as $chat)
                <li style="margin-bottom: 10px;">
                    <a href="{{ route('chat.show', $chat->id) }}">
                        @if (Auth::user()->role === 'vendor')
                            Chat dengan: {{ $chat->customer->name }}
                        @else
                            Chat dengan: {{ $chat->vendor->name }}
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
