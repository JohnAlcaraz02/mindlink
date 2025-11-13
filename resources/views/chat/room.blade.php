@extends('layouts.app')

@section('content')
<div class="flex flex-col h-full px-8 py-6">
    <!-- Room Header -->
    <div class="bg-gradient-to-r from-purple-500 to-blue-500 rounded-2xl p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('chat.anonymous') }}" class="p-2 hover:bg-white/20 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold">{{ $roomName }}</h1>
                    <p class="text-white/90">You are chatting as: {{ $anonymousName }}</p>
                </div>
            </div>
            <div class="flex items-center gap-2 bg-white/20 px-3 py-1 rounded-full">
                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                <span class="text-sm">Online</span>
            </div>
        </div>
    </div>

    <!-- Chat Container -->
    <div class="bg-white rounded-2xl shadow-sm flex-1 flex flex-col overflow-hidden">
        <!-- Messages -->
        <div class="flex-1 overflow-y-auto px-6 py-6" id="chat-messages">
            <div class="space-y-4">
                @foreach($messages as $message)
                    <div class="flex flex-col">
                        <span class="text-purple-600 text-sm mb-1">{{ $message->anonymous_name }}</span>
                        <div class="bg-purple-50 rounded-2xl p-4 max-w-[85%] shadow-sm">
                            <p class="text-gray-800">{{ $message->message }}</p>
                            <span class="text-purple-400 text-xs mt-2 block">{{ $message->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Message Input -->
        <div class="px-6 py-4 border-t border-gray-100">
            <form id="message-form" class="relative">
                <input type="text" 
                       id="message-input"
                       class="w-full bg-gray-50 text-gray-800 rounded-full py-3 px-6 pr-24 border-0 focus:ring-2 focus:ring-purple-200 placeholder:text-gray-400"
                       placeholder="Type your message..."
                       required
                       maxlength="1000">
                <button type="submit" 
                        class="absolute right-6 top-1/2 -translate-y-1/2 px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-full transition-colors">
                    Send
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    // Initialize Pusher
    const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
        cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}'
    });

    const channel = pusher.subscribe('chat.anonymous');
    const messagesContainer = document.getElementById('chat-messages');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');

    // Listen for new messages
    channel.bind('App\\Events\\NewChatMessage', function(data) {
        // Event payload is the message fields directly (see broadcastWith)
        const message = data;
        const isCurrentUser = message.user_id === {{ auth()->id() }};
        
        // Only show messages for this room
        if (message.room_id !== '{{ $room }}') return;
        
        const messageHtml = `
            <div class="flex flex-col ${isCurrentUser ? 'items-end' : ''}">
                <span class="text-purple-600 text-sm mb-1">${message.anonymous_name}</span>
                <div class="${isCurrentUser ? 'bg-purple-100' : 'bg-purple-50'} rounded-2xl p-4 max-w-[85%] shadow-sm">
                    <p class="text-gray-800">${message.message}</p>
                    <span class="text-purple-400 text-xs mt-2 block">just now</span>
                </div>
            </div>
        `;
        
        const messagesWrapper = document.querySelector('#chat-messages .space-y-4');
        messagesWrapper.insertAdjacentHTML('beforeend', messageHtml);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    });

    // Handle message submission
    messageForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const text = messageInput.value.trim();
        if (!text) return;
        
        try {
            const response = await fetch('{{ route('chat.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    message: text,
                    chat_type: 'anonymous',
                    room_id: '{{ $room }}'
                })
            });
            
            if (!response.ok) throw new Error('Failed to send message');
            
            // Optimistically append current user's message (toOthers() won't echo back)
            const sent = await response.json();
            const messageHtml = `
                <div class="flex flex-col items-end">
                    <span class="text-purple-600 text-sm mb-1">${sent.anonymous_name ?? '{{ $anonymousName }}'}</span>
                    <div class="bg-purple-100 rounded-2xl p-4 max-w-[85%] shadow-sm">
                        <p class="text-gray-800">${sent.message ?? text}</p>
                        <span class="text-purple-400 text-xs mt-2 block">just now</span>
                    </div>
                </div>`;
            const messagesWrapper = document.querySelector('#chat-messages .space-y-4');
            messagesWrapper.insertAdjacentHTML('beforeend', messageHtml);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;

            messageInput.value = '';
            messageInput.focus();
            
        } catch (error) {
            console.error('Error:', error);
            alert('Failed to send message. Please try again.');
        }
    });

    // Scroll to bottom on load
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
</script>
@endpush
