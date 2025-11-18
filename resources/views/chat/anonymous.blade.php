@extends('layouts.app')

@section('content')
<div class="h-screen flex flex-col">
    <!-- Chat Header -->
    <div class="bg-gradient-to-r from-red-600 to-red-700 text-white px-6 py-4 flex-shrink-0">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-xl font-semibold">AI Assistant</h1>
                <p class="text-white/90 text-sm">Online • Ready to help</p>
            </div>
        </div>
    </div>

    <!-- Chat Container -->
    <div class="flex-1 flex flex-col min-h-0">
        <!-- Messages -->
        <div class="flex-1 overflow-y-auto bg-white" id="chat-messages" style="scrollbar-width: thin; scrollbar-color: #d1d5db #f3f4f6;">
            <div class="max-w-4xl mx-auto px-6 py-8">
                <div class="space-y-6">
                    <!-- Welcome Message -->
                    <div class="flex gap-3 mb-6">
                        <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="mb-1">
                                <p class="text-gray-800 leading-relaxed">Hello! I'm your AI assistant. Feel free to ask me anything!</p>
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ now()->format('h:i A') }}
                            </div>
                        </div>
                    </div>

                    <!-- Chat History -->
                    @if(session('ai_history'))
                        @foreach(session('ai_history') as $index => $message)
                            @if($message['role'] === 'user')
                                <div class="flex justify-end gap-3 mb-6">
                                    <div class="flex-1 max-w-2xl text-right">
                                        <div class="inline-block bg-red-600 text-white rounded-2xl px-4 py-3 mb-1">
                                            <p class="leading-relaxed">{{ $message['content'] }}</p>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $message['timestamp'] ?? now()->format('h:i A') }}
                                        </div>
                                    </div>
                                    <div class="w-8 h-8 bg-gray-300 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                </div>
                            @elseif($message['role'] === 'assistant')
                                <div class="flex gap-3 mb-6">
                                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <div class="mb-1">
                                            <p class="text-gray-800 leading-relaxed">{{ $message['content'] }}</p>
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $message['timestamp'] ?? now()->format('h:i A') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- Typing Indicator (hidden by default) -->
        <div id="typing-indicator" class="bg-white hidden">
            <div class="max-w-4xl mx-auto px-6 pb-4">
                <div class="flex gap-3">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-1">
                            <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="w-2 h-2 bg-red-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Input -->
        <div class="bg-gray-50 border-t border-gray-200 flex-shrink-0 h-20">
            <div class="max-w-4xl mx-auto px-6 py-4">
                <form id="ai-message-form" class="flex items-center gap-3">
                    <input type="text" 
                           id="ai-message-input"
                           class="flex-1 bg-white text-gray-800 rounded-full py-3 px-4 border border-gray-300 focus:ring-2 focus:ring-red-200 focus:border-red-600 placeholder:text-gray-500 transition-all"
                           placeholder="Type your message..."
                           required
                           maxlength="1000">
                    <button type="submit" 
                            id="send-button"
                            class="w-10 h-10 bg-red-600 hover:bg-red-700 text-white rounded-full flex items-center justify-center transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Custom scrollbar styling */
    #chat-messages::-webkit-scrollbar {
        width: 8px;
    }
    
    #chat-messages::-webkit-scrollbar-track {
        background: #f3f4f6;
        border-radius: 4px;
    }
    
    #chat-messages::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 4px;
    }
    
    #chat-messages::-webkit-scrollbar-thumb:hover {
        background: #9ca3af;
    }
</style>
@endpush

@push('scripts')
<script>
    const messageForm = document.getElementById('ai-message-form');
    const messageInput = document.getElementById('ai-message-input');
    const sendButton = document.getElementById('send-button');
    const messagesContainer = document.getElementById('chat-messages');
    const typingIndicator = document.getElementById('typing-indicator');

    // Handle message submission
    messageForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const text = messageInput.value.trim();
        if (!text) return;
        
        // Disable input while processing
        messageInput.disabled = true;
        sendButton.disabled = true;
        
        // Add user message to chat
        const userMessageHtml = `
            <div class="flex justify-end gap-3 mb-6">
                <div class="flex-1 max-w-2xl text-right">
                    <div class="inline-block bg-red-600 text-white rounded-2xl px-4 py-3 mb-1">
                        <p class="leading-relaxed">${text}</p>
                    </div>
                    <div class="text-xs text-gray-500">
                        ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: true})}
                    </div>
                </div>
                <div class="w-8 h-8 bg-gray-300 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            </div>
        `;
        
        const messagesWrapper = document.querySelector('#chat-messages .space-y-6');
        messagesWrapper.insertAdjacentHTML('beforeend', userMessageHtml);
        messagesContainer.scrollTo({
            top: messagesContainer.scrollHeight,
            behavior: 'smooth'
        });
        
        // Clear input
        messageInput.value = '';
        
        // Show typing indicator
        typingIndicator.classList.remove('hidden');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        try {
            const response = await fetch('{{ route('chat.ai.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    message: text
                })
            });
            
            const data = await response.json();
            
            // Hide typing indicator
            typingIndicator.classList.add('hidden');
            
            if (!response.ok) {
                throw new Error(data.error || 'Failed to get AI response');
            }
            
            // Add AI response to chat
            const aiMessageHtml = `
                <div class="flex gap-3 mb-6">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="mb-1">
                            <p class="text-gray-800 leading-relaxed">${data.reply}</p>
                        </div>
                        <div class="text-xs text-gray-500">
                            ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: true})}
                        </div>
                    </div>
                </div>
            `;
            
            messagesWrapper.insertAdjacentHTML('beforeend', aiMessageHtml);
            messagesContainer.scrollTo({
                top: messagesContainer.scrollHeight,
                behavior: 'smooth'
            });
            
        } catch (error) {
            console.error('Error:', error);
            
            // Hide typing indicator
            typingIndicator.classList.add('hidden');
            
            // Show error message
            const errorMessageHtml = `
                <div class="flex gap-3 mb-6">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <div class="mb-1 text-red-600">
                            <p class="leading-relaxed">Sorry, I'm having trouble connecting right now. Please make sure Ollama is running and try again.</p>
                        </div>
                        <div class="text-xs text-gray-500">
                            ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', hour12: true})}
                        </div>
                    </div>
                </div>
            `;
            
            messagesWrapper.insertAdjacentHTML('beforeend', errorMessageHtml);
            messagesContainer.scrollTo({
                top: messagesContainer.scrollHeight,
                behavior: 'smooth'
            });
        } finally {
            // Re-enable input
            messageInput.disabled = false;
            sendButton.disabled = false;
            messageInput.focus();
        }
    });

    // Auto-focus input on load
    messageInput.focus();
    
    // Scroll to bottom on load
    messagesContainer.scrollTo({
        top: messagesContainer.scrollHeight,
        behavior: 'smooth'
    });
</script>
@endpush

@endsection