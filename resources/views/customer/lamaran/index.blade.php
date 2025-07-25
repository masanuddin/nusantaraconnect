@extends('layouts.customer')

@section('content')
    <h2>Lamaran Saya</h2>

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
                @endif
            </p>
        </div>
    @empty
        <p>Anda belum melamar pekerjaan apa pun.</p>
    @endforelse
@endsection
