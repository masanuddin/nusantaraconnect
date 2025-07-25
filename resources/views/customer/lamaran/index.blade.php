@extends('layouts.customer')

@section('content')
    <h2>Lamaran Saya</h2>
    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; margin-bottom: 15px;">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($lamarans as $lamaran)
        <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
            <p><strong>Pekerjaan:</strong> {{ $lamaran->pekerjaan->nama }}</p>
            <p><strong>Status:</strong> 
                @if ($lamaran->status === 'pending')
                    <span style="color: blue;">Menunggu Review</span>
                @elseif ($lamaran->status === 'on_review')
                    <span style="color: orange;">Dalam Review</span>
                @elseif ($lamaran->status === 'accepted')
                    <span style="color: green;">Diterima</span>
                    @php
                        $chat = \App\Models\Chat::getOrCreate($lamaran->customer_id, $lamaran->pekerjaan->vendor_id);
                    @endphp
                    <form action="{{ route('chat.redirect') }}" method="POST" style="display: inline;">
                        @csrf
                        <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                        <input type="hidden" name="pekerjaan_nama" value="{{ $lamaran->pekerjaan->nama }}">
                        <input type="hidden" name="gaji" value="{{ $lamaran->pekerjaan->range_harga }}">
                        <input type="hidden" name="thumbnail" value="{{ $lamaran->pekerjaan->thumbnail }}">
                        <button type="submit">Chat</button>
                    </form>
                @elseif ($lamaran->status === 'cancel_approval')
                    <span style="color: rgb(255, 63, 63);">Menunggu Persetujuan Pembatalan</span>
                @elseif ($lamaran->status === 'cancelled')
                    <span style="color: rgb(70, 10, 10);">Lamaran Dibatalkan</span>
                @endif
            </p>
            @if (!in_array($lamaran->status, ['cancel_approval', 'cancelled']))
                <button onclick="openCancelModal({{ $lamaran->id }})">Cancel Lamaran</button>
            @endif

            <!-- Modal -->
            <div id="cancelModal-{{ $lamaran->id }}" class="cancel-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); z-index:999;">
                <div style="background:#fff; padding:20px; margin:100px auto; width:400px; border-radius:8px;">
                    <h4>Alasan Membatalkan Lamaran</h4>
                    <form action="{{ route('customer.lamaran.cancel', $lamaran->id) }}" method="POST">
                        @csrf
                        <textarea name="cancel_reason" rows="4" style="width:100%;" required></textarea>
                        <br>
                        <button type="submit">Kirim Pembatalan</button>
                        <button type="button" onclick="closeCancelModal({{ $lamaran->id }})">Tutup</button>
                    </form>
                </div>
            </div>

            <script>
                function openCancelModal(id) {
                    document.getElementById('cancelModal-' + id).style.display = 'block';
                }

                function closeCancelModal(id) {
                    document.getElementById('cancelModal-' + id).style.display = 'none';
                }
            </script>
        </div>
    @empty
        <p>Anda belum melamar pekerjaan apa pun.</p>
    @endforelse
@endsection
