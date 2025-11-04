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
        <div class="flex items-center gap-2 mb-6">
            <span class="text-2xl">✨</span>
            <h2 class="text-2xl font-bold text-gray-800">Daily Mood Check-in</h2>
        </div>
        <p class="text-gray-600 mb-8">Track how you're feeling today</p>

        <!-- Mood Selection -->
        <form action="{{ route('mood.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-5 gap-4">
                <button type="submit" name="mood" value="1" class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-500 hover:bg-purple-50 transition-all cursor-pointer group">
                    <div class="w-20 h-20 mx-auto mb-3 text-5xl flex items-center justify-center transition-transform group-hover:scale-110">
                        😢
                    </div>
                    <span class="text-sm font-medium text-gray-700">Very Sad</span>
                </button>

                <button type="submit" name="mood" value="2" class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-500 hover:bg-purple-50 transition-all cursor-pointer group">
                    <div class="w-20 h-20 mx-auto mb-3 text-5xl flex items-center justify-center transition-transform group-hover:scale-110">
                        😔
                    </div>
                    <span class="text-sm font-medium text-gray-700">Sad</span>
                </button>

                <button type="submit" name="mood" value="3" class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-500 hover:bg-purple-50 transition-all cursor-pointer group">
                    <div class="w-20 h-20 mx-auto mb-3 text-5xl flex items-center justify-center transition-transform group-hover:scale-110">
                        😐
                    </div>
                    <span class="text-sm font-medium text-gray-700">Okay</span>
                </button>

                <button type="submit" name="mood" value="4" class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-500 hover:bg-purple-50 transition-all cursor-pointer group">
                    <div class="w-20 h-20 mx-auto mb-3 text-5xl flex items-center justify-center transition-transform group-hover:scale-110">
                        🙂
                    </div>
                    <span class="text-sm font-medium text-gray-700">Good</span>
                </button>

                <button type="submit" name="mood" value="5" class="flex flex-col items-center p-4 rounded-xl border-2 border-gray-200 hover:border-purple-500 hover:bg-purple-50 transition-all cursor-pointer group">
                    <div class="w-20 h-20 mx-auto mb-3 text-5xl flex items-center justify-center transition-transform group-hover:scale-110">
                        😊
                    </div>
                    <span class="text-sm font-medium text-gray-700">Great</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-3 gap-6">
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
        </div>
    </div>
</div>
@endsection