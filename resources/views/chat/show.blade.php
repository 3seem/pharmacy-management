@extends('Layout2.navbar')
@section('content')

@section('title')
<title>Chat</title>
@endsection

@section('stylesheet')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
body {
    font-family: Arial, sans-serif;
    background: #f1f2f6;
    margin: 0;
    padding: 0;
}

.chat-wrapper {
    display: flex;
    justify-content: center; 
    align-items: center;     
    min-height: calc(100vh - 80px);
    padding-top: 10px;
}

.chat-container {
    width: 450px;
    height: 600px;
    background: #fff;
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    box-shadow: 0 5px 20px rgba(0,0,0,.2);
}

/* هيدر الشات */
.chat-header {
    padding: 15px;
    background: #2f3542;
    color: #fff;
    text-align: center;
    font-weight: bold;
}

/* صندوق الرسائل */
.chat-messages {
    flex: 1;
    padding: 15px;
    overflow-y: auto;
    background: #f5f6fa;
}

/* رسائل */
.message {
    max-width: 70%;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 10px;
    font-size: 14px;
}

/* الرسائل المرسلة */
.sent {
    background: #70a1ff;
    color: #fff;
    margin-left: auto;
    text-align: right;
}

/* الرسائل المستقبلة */
.received {
    background: #dfe4ea;
    color: #000;
    margin-right: auto;
}

/* إدخال الرسائل */
.chat-input {
    display: flex;
    padding: 10px;
    border-top: 1px solid #ddd;
}

.chat-input input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.chat-input button {
    margin-left: 10px;
    padding: 10px 15px;
    background: #2ed573;
    border: none;
    color: #fff;
    border-radius: 5px;
    cursor: pointer;
}
</style>
@endsection

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

            // ترتيب الرسائل من الأقدم للأحدث
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

// تحميل أولي
loadMessages();

// تحديث تلقائي كل 3 ثواني
setInterval(loadMessages, 3000);
</script>

@endsection
