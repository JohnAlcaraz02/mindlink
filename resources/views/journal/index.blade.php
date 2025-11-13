@extends('layouts.app')

@section('content')
<div class="h-full overflow-y-auto">
    <div class="p-8">
        <!-- Header -->
        <div class="bg-purple-500 rounded-2xl p-8 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold mb-1">My Journal</h1>
                        <p class="text-white/90 text-sm">Express your thoughts and feelings in a safe space</p>
                    </div>
                </div>
                <button onclick="openModal()" class="bg-white px-6 py-3 rounded-xl font-semibold hover:bg-purple-50 transition-colors flex items-center gap-2 shadow-lg flex-shrink-0" style="color: #000000;">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>New Entry</span>
                </button>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <!-- Total Entries -->
            <div class="rounded-2xl shadow-lg p-8" style="background-color: #e9d5ff;">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-purple-900 font-semibold">Total Entries</h3>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-color: #a855f7;">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                </div>
                <p class="text-5xl font-bold text-gray-800 mb-2">{{ $totalEntries }}</p>
                <p class="text-sm text-purple-600 font-medium">journal entries</p>
            </div>

            <!-- This Month -->
            <div class="rounded-2xl shadow-lg p-8" style="background-color: #bfdbfe;">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-blue-900 font-semibold">This Month</h3>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-color: #3b82f6;">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-5xl font-bold text-gray-800 mb-2">{{ $thisMonthEntries }}</p>
                <p class="text-sm text-blue-600 font-medium">entries this month</p>
            </div>

            <!-- Most Used Tag -->
            <div class="rounded-2xl shadow-lg p-8" style="background-color: #bbf7d0;">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-green-900 font-semibold">Most Used Tag</h3>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center" style="background-color: #22c55e;">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                    </div>
                </div>
                <p class="text-5xl font-bold text-gray-800 mb-2">{{ $mostUsedTag }}</p>
                <p class="text-sm text-green-600 font-medium">popular topic</p>
            </div>
        </div>

        <!-- Journal Entries -->
        @if($entries->isEmpty())
            <div class="rounded-2xl shadow-sm p-16 text-center" style="background-color: #ffffff; border: 1px solid #e5e7eb;">
                <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6" style="background-color: #f3e8ff; width: 96px; height: 96px; border-radius: 9999px; border: 2px solid #e9d5ff;">
                    <svg class="w-12 h-12" fill="none" stroke="#a855f7" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">No journal entries yet</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">Start writing to track your thoughts and feelings. Your entries are private and secure.</p>
                <button onclick="openModal()" class="text-white px-8 py-4 rounded-xl font-semibold transition-all inline-flex items-center gap-2 shadow-lg hover:shadow-xl transform hover:scale-105" style="background: linear-gradient(135deg, #a855f7 0%, #3b82f6 100%);">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Create First Entry</span>
                </button>
            </div>
        @else
            <div class="space-y-6">
                @foreach($entries as $entry)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8 hover:shadow-md transition-all relative">
                        <!-- Emoji and Title -->
                        <div class="flex items-start gap-3 mb-2">
                            @if($entry->mood)
                                <span class="text-3xl flex-shrink-0">
                                    @if($entry->mood == 1) 😢
                                    @elseif($entry->mood == 2) 😔
                                    @elseif($entry->mood == 3) 😐
                                    @elseif($entry->mood == 4) 🙂
                                    @else 😊
                                    @endif
                                </span>
                            @endif
                            <h3 class="text-lg font-bold text-gray-800 flex-1 leading-tight">{{ $entry->title }}</h3>
                        </div>
                        
                        <!-- Date -->
                        <p class="text-sm text-gray-500 mb-4">{{ $entry->created_at->format('l, F j, Y') }}</p>
                        
                        <!-- Content -->
                        <p class="text-gray-700 mb-4 whitespace-pre-wrap leading-relaxed">{{ $entry->content }}</p>
                        
                        <!-- Tags at bottom -->
                        @if($entry->tags)
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $entry->tags) as $tag)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-xs">{{ trim($tag) }}</span>
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Delete Icon (absolute positioned) -->
                        <form action="{{ route('journal.destroy', $entry->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this entry?');" class="absolute top-6 right-6">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-1">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection

<!-- Modal -->
<div id="journalModal" class="fixed inset-0 hidden items-center justify-center" style="background-color: rgba(0, 0, 0, 0.5); z-index: 9999;" onclick="closeModalOnOutsideClick(event)">
    <div class="bg-white rounded-2xl p-8 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Create New Journal Entry</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form action="{{ route('journal.store') }}" method="POST">
            @csrf
            
            <!-- Title -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Title</label>
                <input type="text" name="title" required maxlength="255"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all"
                       placeholder="Give your entry a title...">
            </div>
            
            <!-- Content -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Content</label>
                <textarea name="content" required rows="6"
                          class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all resize-none"
                          placeholder="What's on your mind?"></textarea>
            </div>
            
            <!-- Tags -->
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Tags <span class="text-gray-500 text-sm font-normal">(optional, comma-separated)</span></label>
                <input type="text" name="tags"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-purple-200 focus:border-purple-400 transition-all"
                       placeholder="e.g., anxiety, gratitude, reflection">
            </div>
            
            <!-- Mood -->
            <div class="mb-8">
                <label class="block text-gray-700 font-medium mb-3">How are you feeling? <span class="text-gray-500 text-sm font-normal">(optional)</span></label>
                <div class="flex gap-3 justify-between">
                    <label class="cursor-pointer flex-1">
                        <input type="radio" name="mood" value="1" class="hidden peer">
                        <div class="w-full h-16 flex items-center justify-center text-4xl rounded-xl hover:bg-gray-100 peer-checked:bg-purple-100 peer-checked:ring-2 peer-checked:ring-purple-500 transition-all">
                            😢
                        </div>
                    </label>
                    <label class="cursor-pointer flex-1">
                        <input type="radio" name="mood" value="2" class="hidden peer">
                        <div class="w-full h-16 flex items-center justify-center text-4xl rounded-xl hover:bg-gray-100 peer-checked:bg-purple-100 peer-checked:ring-2 peer-checked:ring-purple-500 transition-all">
                            😔
                        </div>
                    </label>
                    <label class="cursor-pointer flex-1">
                        <input type="radio" name="mood" value="3" class="hidden peer">
                        <div class="w-full h-16 flex items-center justify-center text-4xl rounded-xl hover:bg-gray-100 peer-checked:bg-purple-100 peer-checked:ring-2 peer-checked:ring-purple-500 transition-all">
                            😐
                        </div>
                    </label>
                    <label class="cursor-pointer flex-1">
                        <input type="radio" name="mood" value="4" class="hidden peer">
                        <div class="w-full h-16 flex items-center justify-center text-4xl rounded-xl hover:bg-gray-100 peer-checked:bg-purple-100 peer-checked:ring-2 peer-checked:ring-purple-500 transition-all">
                            🙂
                        </div>
                    </label>
                    <label class="cursor-pointer flex-1">
                        <input type="radio" name="mood" value="5" class="hidden peer">
                        <div class="w-full h-16 flex items-center justify-center text-4xl rounded-xl hover:bg-gray-100 peer-checked:bg-purple-100 peer-checked:ring-2 peer-checked:ring-purple-500 transition-all">
                            😊
                        </div>
                    </label>
                </div>
            </div>
            
            <!-- Submit Button -->
            <button type="submit" class="w-full py-4 rounded-xl font-semibold transition-all shadow-lg hover:shadow-xl transform hover:scale-105" style="background: linear-gradient(135deg, #a855f7 0%, #3b82f6 100%); color: #ffffff;">
                Save Entry
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openModal() {
    console.log('openModal called');
    const modal = document.getElementById('journalModal');
    console.log('Modal element:', modal);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        console.log('Modal should be visible now');
    } else {
        console.error('Modal element not found!');
    }
}

function closeModal() {
    const modal = document.getElementById('journalModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

function closeModalOnOutsideClick(event) {
    if (event.target.id === 'journalModal') {
        closeModal();
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeModal();
    }
});
</script>
@endpush