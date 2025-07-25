@extends('layouts.customer')

@section('content')
    <div class="container">
        <h2>Chat dengan Asisten Budaya</h2>
        <form id="chat-form">
            <input type="text" id="user-input" placeholder="Tanyakan tentang pekerjaan..." required>
            <button type="submit">Kirim</button>
        </form>
        <div id="chat-box" style="margin-top:20px;"></div>
    </div>

    <script>
        const form = document.getElementById('chat-form');
        const input = document.getElementById('user-input');
        const chatBox = document.getElementById('chat-box');

        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const userMessage = input.value;
            chatBox.innerHTML += `<p><strong>Anda:</strong> ${userMessage}</p>`;
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
            chatBox.innerHTML += `<p><strong>Asisten:</strong> ${data.reply}</p>`;
        });
    </script>
@endsection
