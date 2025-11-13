@extends('layouts.app')

@section('content')
<div class="flex flex-col h-full px-8 py-6">
    <!-- AI Chat Header -->
    <div class="bg-gradient-to-r from-purple-500 to-blue-500 rounded-2xl p-6 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('chat.anonymous') }}" class="p-2 hover:bg-white/20 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">MindLink AI Assistant</h1>
                        <p class="text-white/90">Your supportive AI companion</p>
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-2 bg-green-500/20 px-3 py-1 rounded-full">
                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                <span class="text-sm">Online</span>
            </div>
        </div>
    </div>

    <!-- Chat Container -->
    <div class="bg-white rounded-2xl shadow-sm flex-1 flex flex-col overflow-hidden">
        <!-- Messages -->
        <div class="flex-1 overflow-y-auto px-6 py-6" id="chat-messages">
            <div class="space-y-6">
                <!-- Welcome Message -->
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                            </svg>
                        </div>
                        <span class="text-purple-600 text-sm font-medium">MindLink Assistant</span>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-2xl p-4 max-w-[85%] border border-purple-100">
                        <p class="text-gray-800">Hello! I'm your AI mental health companion. I'm here to listen, support, and help you navigate your thoughts and feelings. How are you doing today?</p>
                        <span class="text-purple-400 text-xs mt-2 block">just now</span>
                    </div>
                </div>

                <!-- Chat History -->
                @foreach($history as $index => $message)
                    @if($message['role'] === 'user')
                        <div class="flex flex-col items-end">
                            <span class="text-gray-600 text-sm mb-1">You</span>
                            <div class="bg-purple-100 rounded-2xl p-4 max-w-[85%] shadow-sm">
                                <p class="text-gray-800">{{ $message['content'] }}</p>
                            </div>
                        </div>
                    @elseif($message['role'] === 'assistant')
                        <div class="flex flex-col">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                                    </svg>
                                </div>
                                <span class="text-purple-600 text-sm font-medium">MindLink Assistant</span>
                            </div>
                            <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-2xl p-4 max-w-[85%] border border-purple-100">
                                <p class="text-gray-800">{{ $message['content'] }}</p>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Typing Indicator (hidden by default) -->
        <div id="typing-indicator" class="px-6 pb-2 hidden">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                </div>
                <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-2xl p-4 border border-purple-100">
                    <div class="flex items-center gap-1">
                        <div class="w-2 h-2 bg-purple-400 rounded-full animate-bounce"></div>
                        <div class="w-2 h-2 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                        <div class="w-2 h-2 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message Input -->
        <div class="px-6 py-4 border-t border-gray-100">
            <form id="ai-message-form" class="relative">
                <input type="text" 
                       id="ai-message-input"
                       class="w-full bg-gray-50 text-gray-800 rounded-full py-3 px-6 pr-24 border-0 focus:ring-2 focus:ring-purple-200 placeholder:text-gray-400"
                       placeholder="Share what's on your mind..."
                       required
                       maxlength="1000">
                <button type="submit" 
                        id="send-button"
                        class="absolute right-6 top-1/2 -translate-y-1/2 px-4 py-2 bg-purple-500 hover:bg-purple-600 text-white rounded-full transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                    Send
                </button>
            </form>
        </div>
    </div>
</div>

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
            <div class="flex flex-col items-end">
                <span class="text-gray-600 text-sm mb-1">You</span>
                <div class="bg-purple-100 rounded-2xl p-4 max-w-[85%] shadow-sm">
                    <p class="text-gray-800">${text}</p>
                </div>
            </div>
        `;
        
        const messagesWrapper = document.querySelector('#chat-messages .space-y-6');
        messagesWrapper.insertAdjacentHTML('beforeend', userMessageHtml);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
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
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                            </svg>
                        </div>
                        <span class="text-purple-600 text-sm font-medium">MindLink Assistant</span>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 rounded-2xl p-4 max-w-[85%] border border-purple-100">
                        <p class="text-gray-800">${data.reply}</p>
                        <span class="text-purple-400 text-xs mt-2 block">just now</span>
                    </div>
                </div>
            `;
            
            messagesWrapper.insertAdjacentHTML('beforeend', aiMessageHtml);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
            
        } catch (error) {
            console.error('Error:', error);
            
            // Hide typing indicator
            typingIndicator.classList.add('hidden');
            
            // Show error message
            const errorMessageHtml = `
                <div class="flex flex-col">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-8 h-8 bg-red-500 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <span class="text-red-600 text-sm font-medium">System</span>
                    </div>
                    <div class="bg-red-50 rounded-2xl p-4 max-w-[85%] border border-red-200">
                        <p class="text-gray-800">Sorry, I'm having trouble connecting right now. Please make sure Ollama is running and try again.</p>
                    </div>
                </div>
            `;
            
            messagesWrapper.insertAdjacentHTML('beforeend', errorMessageHtml);
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
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
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
</script>
@endpush
