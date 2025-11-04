<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MoodCheckin;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get total check-ins
        $totalCheckins = MoodCheckin::where('user_id', $user->id)->count();
        
        // Calculate average mood
        $averageMood = MoodCheckin::where('user_id', $user->id)
            ->avg('mood_value') ?? 0;
        
        // Calculate current streak
        $currentStreak = $this->calculateStreak($user->id);
        
        return view('dashboard', compact('totalCheckins', 'averageMood', 'currentStreak'));
    }
    
    private function calculateStreak($userId)
    {
        $streak = 0;
        $date = Carbon::today();
        
        while (true) {
            $hasCheckin = MoodCheckin::where('user_id', $userId)
                ->whereDate('created_at', $date)
                ->exists();
            
            if (!$hasCheckin) {
                break;
            }
            
            $streak++;
            $date->subDay();
        }
        
        return $streak;
    }
}