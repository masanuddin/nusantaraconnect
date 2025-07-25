@extends(Auth::user()->role === 'vendor' ? 'layouts.vendor' : 'layouts.customer')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">
        <div class="card shadow-sm p-4">
            <h4 class="fw-bold mb-4" style="color: #7C4B28;">Daftar Chat</h4>

            @if ($chats->isEmpty())
                <div class="alert alert-info">Belum ada percakapan.</div>
            @else
                <div class="list-group">
                    @foreach ($chats as $chat)
                        @php
                            $partner = Auth::user()->role === 'vendor' ? $chat->customer : $chat->vendor;
                        @endphp
                        <a href="{{ route('chat.show', $chat->id) }}" class="list-group-item list-group-item-action d-flex align-items-center gap-3 border rounded mb-2 shadow-sm">
                            <div class="rounded-circle bg-secondary flex-shrink-0" style="width: 40px; height: 40px;"></div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-0" style="color: #5C3D25;">{{ $partner->name }}</h6>
                                <small class="text-muted">Klik untuk membuka percakapan</small>
                            </div>
                            <div>
                                <button class="btn btn-sm" style="background-color: #f4e5dc; color: #5c3d25;">Chat</button>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
