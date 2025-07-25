@extends('layouts.customer')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">
        <div style="height: 30rem" class="bg-white rounded-4 p-4 mt-5">
            <h4 class="fw-bold mb-4" style="color: #7C4B28;">Inbox Lamaran</h4>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($lamarans->isEmpty())
                <p>Anda belum melamar pekerjaan apa pun.</p>
            @else
                @foreach ($lamarans as $lamaran)
                    @php
                        $pekerjaan = $lamaran->pekerjaan;
                        $status = $lamaran->status;
                        $statusText = '';
                        $statusClass = '';
                        switch ($status) {
                            case 'accepted':
                                $statusText = 'Diterima';
                                $statusClass = 'bg-success text-success1';
                                break;
                            case 'on_review':
                                $statusText = 'Sedang Diluas';
                                $statusClass = 'bg-warning-subtle text-warning';
                                break;
                            case 'pending':
                                $statusText = 'Menunggu Review';
                                $statusClass = 'bg-primary-subtle text-primary';
                                break;
                            case 'cancel_approval':
                                $statusText = 'Menunggu Persetujuan Pembatalan';
                                $statusClass = 'bg-danger-subtle text-danger';
                                break;
                            case 'cancelled':
                                $statusText = 'Dibatalkan';
                                $statusClass = 'bg-dark text-white';
                                break;
                            default:
                                $statusText = ucfirst($status);
                                $statusClass = 'bg-secondary text-white';
                                break;
                        }
                    @endphp

                    <div class="d-flex gap-3 align-items-start border rounded-4 mb-3 p-3">
                        {{-- Sidebar (nama perusahaan, thumbnail jika ada) --}}
                        <div class="text-center" style="width: 250px;">
                            <div class="fw-bold text-start">{{ $pekerjaan->nama }}</div>
                            <div class="text-muted text-start">{{ $pekerjaan->vendor->name ?? 'CV Talentamuda' }}</div>
                        </div>

                        {{-- Konten utama --}}
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $pekerjaan->nama }}</h6>
                                    <div class="text-muted">{{ $pekerjaan->lokasi }}</div>
                                    <div class="text-muted">{{ $pekerjaan->deskripsi }}</div>
                                    <div class="text-muted">Rp{{ $pekerjaan->range_harga }}</div>
                                    <div class="text-muted">Event pada tanggal {{ \Carbon\Carbon::parse($pekerjaan->mulai_kerja)->format('d M Y') }}
                                        - {{ \Carbon\Carbon::parse($pekerjaan->selesai_kerja)->format('d M Y') }}</div>
                                    <div class="text-muted">Disubmit pada tanggal {{ \Carbon\Carbon::parse($lamaran->created_at)->format('d M Y') }}</div>
                                </div>

                                {{-- Aksi dan Status --}}
                                <div class="text-end">
                                    @if ($status === 'accepted')
                                        @php
                                            $chat = \App\Models\Chat::getOrCreate($lamaran->customer_id, $lamaran->pekerjaan->vendor_id);
                                        @endphp
                                        <form action="{{ route('chat.redirect') }}" method="POST" class="">
                                            @csrf
                                            <input type="hidden" name="chat_id" value="{{ $chat->id }}">
                                            <input type="hidden" name="pekerjaan_nama" value="{{ $pekerjaan->nama }}">
                                            <input type="hidden" name="gaji" value="{{ $pekerjaan->range_harga }}">
                                            <input type="hidden" name="thumbnail" value="{{ $pekerjaan->thumbnail }}">
                                            <button type="submit" class="btn btn-outline-primary fw-semibold btn-sm mb-3 px-2 rounded-3">Chat</button>
                                        </form>
                                    @endif

                                    <span class="badge {{ $statusClass }} px-3 py-2 rounded-3">{{ $statusText }}</span>

                                    @if (!in_array($status, ['cancel_approval', 'cancelled']))
                                        <br>
                                        <button onclick="openCancelModal({{ $lamaran->id }})" class="btn btn-link text-danger btn-sm text-sm mt-1">Batalkan</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Pembatalan --}}
                    <div id="cancelModal-{{ $lamaran->id }}" class="modal fade" tabindex="-1" aria-labelledby="modalLabel{{ $lamaran->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('customer.lamaran.cancel', $lamaran->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalLabel{{ $lamaran->id }}">Alasan Membatalkan Lamaran</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <textarea name="cancel_reason" rows="4" class="form-control" required></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Kirim Pembatalan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<script>
    function openCancelModal(id) {
        var modal = new bootstrap.Modal(document.getElementById('cancelModal-' + id));
        modal.show();
    }
</script>
@endsection
