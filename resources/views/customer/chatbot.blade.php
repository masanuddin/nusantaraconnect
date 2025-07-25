@extends('layouts.customer')

@section('content')
<div class="d-flex justify-content-center">
    <div style="width: 100%; max-width: 1200px;">
        <div class="card shadow-sm p-4" style="background-color: #f8f9fa;">
            <div class="d-flex align-items-center border-bottom pb-3 mb-4">
                <div class="rounded-circle bg-secondary me-3" style="width: 40px; height: 40px;"></div>
                <div>
                    <h5 class="fw-bold mb-0" style="color: #7C4B28;">Muhammad Sirajudin</h5>
                    <small class="text-muted">Talent Group Penari Tarian Kecak</small>
                </div>
            </div>

            <div id="chat-box" class="mb-4" style="max-height: 500px; overflow-y: auto;">
                <!-- Percakapan muncul di sini -->
            </div>

            <form id="chat-form" class="d-flex gap-2">
                <input type="text" id="user-input" class="form-control" placeholder="Tanyakan tentang pekerjaan..." required>
                <button type="submit" class="btn  text-dark border">Kirim</button>
            </form>
        </div>
    </div>
</div>

<style>
    .chat-message {
        max-width: 75%;
        padding: 10px 15px;
        border-radius: 15px;
        margin-bottom: 10px;
        font-size: 0.95rem;
    }

    .chat-left {
        background-color: #ffffff;
        color: #5c3d25;
        align-self: flex-end;
        border: 1px solid #e0e0e0;
    }

    .chat-right {
        background-color: #e8cfc0;
        color: #5c3d25;
        align-self: flex-start;
    }

    #chat-box {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
</style>

<script>
    const form = document.getElementById('chat-form');
    const input = document.getElementById('user-input');
    const chatBox = document.getElementById('chat-box');

    function appendMessage(message, sender = 'user') {
        const bubble = document.createElement('div');
        bubble.classList.add('chat-message');
        bubble.classList.add(sender === 'user' ? 'chat-left' : 'chat-right');
        bubble.innerText = message;
        chatBox.appendChild(bubble);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        const userMessage = input.value;
        appendMessage(userMessage, 'user');
        input.value = '';

        const response = await fetch("{{ route('customer.chatbot.ask') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ message: userMessage })
        });

        const data = await response.json();
        appendMessage(data.reply, 'bot');
    });
</script>
@endsection
