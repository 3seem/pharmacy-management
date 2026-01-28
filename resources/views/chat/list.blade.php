@extends('Layout2.navbar')
@section('content')

@section('title')
<title>Chats</title>
@endsection

@section('stylesheet')
<style>
body { font-family: Arial; background:#f1f2f6; padding: 0px;}
.chat-list { max-width: 600px; margin: auto;margin-top: 10px; }
.chat-item {
    background: #fff; 
    padding: 15px; 
    margin-bottom: 10px; 
    border-radius: 10px; 
    display: flex; 
    justify-content: space-between; 
    align-items: center; 
    box-shadow: 0 2px 6px rgba(0,0,0,.2);
}
.chat-item a { text-decoration: none; color: #2f3542; font-weight: bold; }
.last-message { font-size: 13px; color: #57606f; margin-top: 5px; }
.chat-link {
    color: #1e90ff; 
    text-decoration: none; 
    font-weight: bold;
}
.unread-badge {
    display: inline-flex;          
    justify-content: center;       
    align-items: center;           
    width: 20px;                   
    height: 20px;                  
    background: #1e90ff;           
    color: #fff;                   
    font-size: 12px;              
    font-weight: bold;
    border-radius: 50%;            
    margin-left: 5px;
}

.start-chat-btn {
    display: block;
    width: 200px;
    margin: 20px auto;
    padding: 10px 15px;
    background: #1e90ff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
}
</style>
@endsection

@if($conversations->isEmpty())
    <form action="{{ route('chat.start') }}" method="POST">
        @csrf
        <button type="submit" class="start-chat-btn">start new chat</button>
    </form>
@endif

<div class="chat-list">
    @foreach($conversations as $conversation)
        <div class="chat-item">
            <div>
                <a href="{{ route('chat.show', $conversation->id) }}">
                    {{ $conversation->admin->name }}
                </a>
                <div class="last-message">
                    {{ $conversation->latestMessage->message ?? 'no messages found' }}
                </div>
            </div>

            <div>
                <a href="{{ route('chat.show', $conversation->id) }}" class="chat-link">open chat</a>

                @if($conversation->unread_count > 0)
                    <span class="unread-badge">
                        {{ $conversation->unread_count }}
                    </span>
                @endif
            </div>
        </div>
    @endforeach
</div>

@endsection
