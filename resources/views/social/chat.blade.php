@extends('layouts.app')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    body { background-color: #0f172a; color: white; }
    .message-bubble-sent {
        background: linear-gradient(135deg, #3b82f6, #2563eb);
        border-radius: 18px 18px 4px 18px;
        max-width: 75%;
    }
    .message-bubble-received {
        background: #1e293b;
        border-radius: 18px 18px 18px 4px;
        max-width: 75%;
    }
    .chat-container {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }
</style>

<script>
function scrollToBottom() {
    const chatContainer = document.getElementById('chat-messages');
    if (chatContainer) {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
}

function sendMessage() {
    const input = document.getElementById('message-input');
    const message = input.value.trim();
    if (!message) return;

    // Add message to UI immediately
    const chatContainer = document.getElementById('chat-messages');
    const newMessage = `
        <div class="flex justify-end mb-3">
            <div class="message-bubble-sent px-4 py-2 text-sm">
                <p>${message}</p>
                <p class="text-[10px] text-blue-100 mt-1 text-right">Just now</p>
            </div>
        </div>
    `;
    chatContainer.innerHTML += newMessage;
    input.value = '';
    scrollToBottom();

    // Send to server via AJAX
    fetch('{{ route('social.message.send') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            to_id: {{ $chatUser['id'] ?? 0 }},
            text: message
        })
    });
}

document.addEventListener('DOMContentLoaded', function() {
    scrollToBottom();
    
    // Allow Enter key to send
    document.getElementById('message-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
});
</script>

<div class="min-h-screen bg-slate-900 flex flex-col">
    
    <!-- Chat Header -->
    <div class="bg-slate-800 p-3 flex items-center gap-3 border-b border-white/10">
        <a href="{{ route('social.messages') }}" class="text-white hover:text-slate-300">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-700">
            @if(isset($chatUser['avatar']))
                <img src="{{ $chatUser['avatar'] }}" alt="{{ $chatUser['full_name'] }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center">
                    <i class="fas fa-user text-slate-400"></i>
                </div>
            @endif
        </div>
        <div class="flex-1">
            <h3 class="font-semibold text-white">{{ $chatUser['full_name'] ?? 'User' }}</h3>
            <p class="text-xs text-slate-400">{{ $chatUser['username'] ?? '' }}</p>
        </div>
        <button class="text-white p-2">
            <i class="fas fa-phone text-xl"></i>
        </button>
        <button class="text-white p-2">
            <i class="fas fa-video text-xl"></i>
        </button>
    </div>

    <!-- Messages -->
    <div class="chat-container flex-1 overflow-y-auto" id="chat-messages">
        @if(!empty($messages))
            @foreach($messages as $message)
                <div class="flex justify-{{ $message['from_id'] == ($currentUser['id'] ?? 0) ? 'end' : 'start' }} mb-3">
                    <div class="{{ $message['from_id'] == ($currentUser['id'] ?? 0) ? 'message-bubble-sent' : 'message-bubble-received' }} px-4 py-2 text-sm">
                        <p>{{ $message['text'] }}</p>
                        <p class="text-[10px] {{ $message['from_id'] == ($currentUser['id'] ?? 0) ? 'text-blue-100' : 'text-slate-400' }} mt-1">
                            {{ date('H:i', strtotime($message['created_at'] ?? 'now')) }}
                        </p>
                    </div>
                </div>
            @endforeach
        @else
            <div class="flex flex-col items-center justify-center h-full text-center">
                <div class="w-20 h-20 rounded-full bg-slate-800 flex items-center justify-center mb-4">
                    @if(isset($chatUser['avatar']))
                        <img src="{{ $chatUser['avatar'] }}" alt="{{ $chatUser['full_name'] }}" class="w-full h-full object-cover rounded-full">
                    @else
                        <i class="fas fa-user text-3xl text-slate-400"></i>
                    @endif
                </div>
                <h3 class="text-lg font-semibold text-white">{{ $chatUser['full_name'] ?? 'User' }}</h3>
                <p class="text-sm text-slate-400 mt-1">Start a conversation!</p>
            </div>
        @endif
    </div>

    <!-- Input -->
    <div class="bg-slate-800 p-3 border-t border-white/10">
        <div class="flex items-center gap-3">
            <button class="text-slate-400 p-2">
                <i class="fas fa-plus-circle text-xl"></i>
            </button>
            <div class="flex-1 relative">
                <input type="text" id="message-input" placeholder="Type a message..." 
                    class="w-full bg-slate-700 border border-white/10 rounded-full py-2 px-4 text-white text-sm focus:outline-none focus:border-blue-500">
            </div>
            <button onclick="sendMessage()" class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 transition-colors">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>
</div>

@endsection

