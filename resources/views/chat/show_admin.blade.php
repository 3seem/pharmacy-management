@extends('layouts.testlayout')



@section('content')



<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
body {
    font-family: Arial, sans-serif;
    background: #000;
    margin: 0;
    padding: 0 px;
}

.chat-wrapper {
    display: flex;
    justify-content: center; 
    align-items: center;     
    min-height: calc(100vh - 80px);
    padding-top: 100px;
}

.chat-container {
    width: 450px;
    height: 600px;
    background: #1e1e1e;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 5px 20px rgba(0,0,0,.5);
}

.chat-header {
    padding: 15px;
    background: #111;
    color: #fff;
    text-align: center;
    font-weight: bold;
    border-bottom: 1px solid #333;
}

.chat-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background: #141414;
}

.message {
    max-width: 70%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 10px;
    font-size: 14px;
}

.sent {
    background: #f8532e;
    color: #fdfdfd;
    margin-left: auto;
    text-align: right;
}

.received {
    background: #2f3542;
    color: #fff;
    margin-right: auto;
}

.chat-input {
    display: flex;
    padding: 10px;
    border-top: 1px solid #333;
    background: #111;
}

.chat-input input {
    flex: 1;
    padding: 10px;
    border: 1px solid #333;
    border-radius: 5px;
    background: #1e1e1e;
    color: #fff;
}

.chat-input input::placeholder {
    color: #aaa;
}

.chat-input button {
    margin-left: 10px;
    padding: 10px 15px;
    background: #f8532e;
    border: none;
    color: #fdfbfb;
    border-radius: 5px;
    cursor: pointer;
}

.chat-input button:hover {
    opacity: 0.8;
}
</style>

<div class="chat-wrapper">
    <div class="chat-container">
        <div class="chat-header">
            Chat Support
        </div>

        <div class="chat-messages" id="messages"></div>

        <div class="chat-input">
            <input type="text" id="messageInput" placeholder="Write your message...">
            <button onclick="sendMessage()">Send</button>
        </div>
    </div>
</div>

<script>
const conversationId = {{ $conversation->id }};
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const currentUserRole = "{{ auth()->user()->role }}";

function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    if (!message) return;

    fetch('/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            conversation_id: conversationId,
            message: message
        })
    }).then(() => {
        input.value = '';
        loadMessages();
    });
}

function loadMessages() {
    fetch(`/chat/${conversationId}/messages`)
        .then(res => res.json())
        .then(data => {
            const box = document.getElementById('messages');
            box.innerHTML = '';
            data.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));

            data.forEach(msg => {
                const div = document.createElement('div');
                div.classList.add('message');

                if (msg.sender_type === currentUserRole) {
                    div.classList.add('sent');
                } else {
                    div.classList.add('received');
                }

                div.textContent = msg.message;
                box.appendChild(div);
            });

            box.scrollTop = box.scrollHeight;
        });
}

loadMessages();
setInterval(loadMessages, 3000);
</script>

@endsection
