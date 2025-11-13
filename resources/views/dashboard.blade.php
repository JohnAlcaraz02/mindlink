@extends('layouts.app')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-8 mb-8 text-white">
        <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->student_id ?? auth()->id() }}! 👋</h1>
        <p class="text-purple-100">How are you feeling today?</p>
    </div>

    <!-- Daily Mood Check-in -->
    <div class="bg-white rounded-2xl shadow-sm p-8 mb-8">
        <div class="flex items-center gap-2 mb-2">
            <span class="text-2xl">✨</span>
            <h2 class="text-2xl font-bold text-gray-800">Daily Mood Check-in</h2>
        </div>
        
        @if($todayMood)
            <!-- Already Logged State -->
            <p class="text-gray-600 mb-8">You've already logged your mood today!</p>
            
            <div class="flex flex-col items-center py-8">
                <!-- Mood Emoji with Circle Background -->
                <div class="w-40 h-40 rounded-full flex items-center justify-center mb-6" style="background: linear-gradient(135deg, #e0e7ff 0%, #ddd6fe 100%);">
                    <span style="font-size: 6rem;">
                        @if($todayMood->mood_value == 1) 😢
                        @elseif($todayMood->mood_value == 2) 😔
                        @elseif($todayMood->mood_value == 3) 😐
                        @elseif($todayMood->mood_value == 4) 🙂
                        @else 😊
                        @endif
                    </span>
                </div>
                
                <!-- Mood Text -->
                <p class="text-xl text-gray-700 mb-4">
                    You're feeling 
                    <span class="font-bold" style="color: #a855f7;">
                        @if($todayMood->mood_value == 1) very sad
                        @elseif($todayMood->mood_value == 2) sad
                        @elseif($todayMood->mood_value == 3) okay
                        @elseif($todayMood->mood_value == 4) good
                        @else great
                        @endif
                    </span>
                    today
                </p>
                
                <!-- Note Display -->
                @if($todayMood->note)
                    <div class="w-full max-w-lg bg-purple-50 rounded-2xl p-6 text-center">
                        <p class="text-gray-700 italic">"{{ $todayMood->note }}"</p>
                    </div>
                @endif
            </div>
        @else
            <!-- Mood Entry Form -->
            <p class="text-gray-600 mb-8">Track how you're feeling today</p>

            <form action="{{ route('mood.store') }}" method="POST" id="moodForm">
                @csrf
                <div class="grid grid-cols-5 gap-4 mb-6">
                <label class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-500 transition-all cursor-pointer mood-option" data-mood="1">
                    <input type="radio" name="mood" value="1" class="hidden mood-radio">
                    <div class="w-16 h-16 mx-auto mb-2 text-5xl flex items-center justify-center">
                        😢
                    </div>
                    <span class="text-sm font-medium text-gray-700">Very Sad</span>
                </label>

                <label class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-500 transition-all cursor-pointer mood-option" data-mood="2">
                    <input type="radio" name="mood" value="2" class="hidden mood-radio">
                    <div class="w-16 h-16 mx-auto mb-2 text-5xl flex items-center justify-center">
                        😔
                    </div>
                    <span class="text-sm font-medium text-gray-700">Sad</span>
                </label>

                <label class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-500 transition-all cursor-pointer mood-option" data-mood="3">
                    <input type="radio" name="mood" value="3" class="hidden mood-radio">
                    <div class="w-16 h-16 mx-auto mb-2 text-5xl flex items-center justify-center">
                        😐
                    </div>
                    <span class="text-sm font-medium text-gray-700">Okay</span>
                </label>

                <label class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-500 transition-all cursor-pointer mood-option" data-mood="4">
                    <input type="radio" name="mood" value="4" class="hidden mood-radio">
                    <div class="w-16 h-16 mx-auto mb-2 text-5xl flex items-center justify-center">
                        🙂
                    </div>
                    <span class="text-sm font-medium text-gray-700">Good</span>
                </label>

                <label class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-500 transition-all cursor-pointer mood-option" data-mood="5">
                    <input type="radio" name="mood" value="5" class="hidden mood-radio">
                    <div class="w-16 h-16 mx-auto mb-2 text-5xl flex items-center justify-center">
                        😊
                    </div>
                    <span class="text-sm font-medium text-gray-700">Great</span>
                </label>
            </div>
            
            <!-- Note Textarea -->
            <textarea name="note" rows="4" placeholder="Add a note about how you're feeling (optional)..." class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:border-purple-500 focus:outline-none resize-none mb-4"></textarea>
            
            <!-- Save Button -->
            <button type="submit" class="w-full py-4 rounded-xl text-white font-semibold text-lg transition-all" style="background: linear-gradient(135deg, #a855f7 0%, #3b82f6 100%);" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                Save Mood Entry
            </button>
        </form>
        @endif
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-3 gap-6 mb-8">
        <!-- Total Check-ins -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-700 font-medium">Total Check-ins</h3>
                <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center">
                    <span class="text-xl">😊</span>
                </div>
            </div>
            <p class="text-4xl font-bold text-gray-800">{{ $totalCheckins }}</p>
        </div>

        <!-- Average Mood -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-700 font-medium">Average Mood</h3>
                <div class="w-10 h-10 bg-green-500 rounded-xl flex items-center justify-center">
                    <span class="text-xl">📈</span>
                </div>
            </div>
            <p class="text-4xl font-bold text-gray-800">{{ number_format($averageMood, 1) }}/5</p>
        </div>

        <!-- Current Streak -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-2xl p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-700 font-medium">Current Streak</h3>
                <div class="w-10 h-10 bg-yellow-500 rounded-xl flex items-center justify-center">
                    <span class="text-xl">🔥</span>
                </div>
            </div>
            <p class="text-4xl font-bold text-gray-800">{{ $currentStreak }} days</p>
            <p class="text-sm text-gray-600 mt-2">keep it up! 🔥</p>
        </div>
    </div>

    <!-- 7-Day Mood Trend -->
    <div class="bg-white rounded-2xl shadow-sm p-8 mb-8">
        <div class="flex items-center gap-2 mb-2">
            <span class="text-2xl">📊</span>
            <h2 class="text-2xl font-bold text-gray-800">7-Day Mood Trend</h2>
        </div>
        <p class="text-gray-600 mb-6">Track your emotional well-being over time</p>
        <canvas id="moodTrendChart" style="max-height: 300px;"></canvas>
    </div>

    <!-- Daily Wellness Tip -->
    <div class="bg-purple-500 rounded-2xl p-8 text-white">
        <div class="flex items-center gap-3 mb-4">
            <span class="text-2xl">💡</span>
            <h2 class="text-2xl font-bold">Daily Wellness Tip</h2>
        </div>
        <p class="text-white/90 leading-relaxed text-lg">
            {{ $dailyTip }}
        </p>
        <div class="mt-4 text-sm text-white/75">
            <span>Tip changes daily • {{ now()->format('F j, Y') }}</span>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Mood selection interaction
    document.querySelectorAll('.mood-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected state from all options
            document.querySelectorAll('.mood-option').forEach(opt => {
                opt.classList.remove('border-purple-500', 'bg-purple-50');
                opt.classList.add('border-gray-200');
            });
            // Add selected state to clicked option
            this.classList.remove('border-gray-200');
            this.classList.add('border-purple-500', 'bg-purple-50');
        });
    });

    // 7-Day Mood Trend Chart
    const ctx = document.getElementById('moodTrendChart').getContext('2d');
    const moodData = {!! json_encode($recentMoods->pluck('mood_value')->reverse()->values()) !!};
    const moodDates = {!! json_encode($recentMoods->map(function($mood) { return $mood->created_at->format('M j'); })->reverse()->values()) !!};
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: moodDates.length > 0 ? moodDates : ['No data'],
            datasets: [{
                label: 'Mood',
                data: moodData.length > 0 ? moodData : [0],
                borderColor: '#a855f7',
                backgroundColor: 'rgba(168, 85, 247, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 6,
                pointBackgroundColor: '#a855f7',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    min: 0,
                    ticks: {
                        stepSize: 1
                    },
                    grid: {
                        color: '#e5e7eb',
                        drawBorder: false
                    }
                },
                x: {
                    grid: {
                        color: '#e5e7eb',
                        drawBorder: false
                    }
                }
            }
        }
    });
</script>
@endpush
@endsection