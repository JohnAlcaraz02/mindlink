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
        
        // Check if user is Administrator
        if ($user->user_type === 'Administrator') {
            // Redirect to admin dashboard controller
            return redirect()->route('admin.dashboard');
        }
        
        // Student dashboard data
        $totalCheckins = MoodCheckin::where('user_id', $user->id)->count();
        
        // Calculate average mood
        $averageMood = MoodCheckin::where('user_id', $user->id)
            ->avg('mood_value') ?? 0;
        
        // Calculate current streak
        $currentStreak = $this->calculateStreak($user->id);
        
        // Get recent moods for compatibility
        $recentMoods = MoodCheckin::where('user_id', $user->id)
            ->latest()
            ->take(7)
            ->get();
        
        // Check if user has already logged mood today
        $todayMood = MoodCheckin::where('user_id', $user->id)
            ->whereDate('created_at', Carbon::today())
            ->first();
        
        // Get daily tip
        $dailyTip = $this->getDailyTip();
        
        return view('dashboard', compact('totalCheckins', 'recentMoods', 'averageMood', 'currentStreak', 'dailyTip', 'todayMood'));
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
    
    private function getDailyTip()
    {
        $tips = [
            "Remember to take breaks throughout your day. Even 5 minutes of deep breathing can help reduce stress and improve focus. Try the 4-7-8 breathing technique: inhale for 4 seconds, hold for 7, exhale for 8.",
            "Start your morning with gratitude. Write down three things you're thankful for each day. This simple practice can significantly boost your mood and overall well-being.",
            "Stay hydrated! Drinking enough water helps maintain energy levels and supports brain function. Aim for 8 glasses throughout the day.",
            "Take a 10-minute walk outside. Fresh air and natural light can improve your mood, reduce stress, and boost vitamin D levels.",
            "Practice the 5-4-3-2-1 grounding technique when feeling anxious: Notice 5 things you can see, 4 you can touch, 3 you can hear, 2 you can smell, and 1 you can taste.",
            "Limit screen time before bed. Try reading a book or practicing gentle stretches instead. Better sleep leads to better mental health.",
            "Connect with a friend or family member today. Social connections are vital for mental well-being. Even a quick text can make a difference.",
            "Practice mindful eating. Slow down during meals, savor each bite, and pay attention to how food makes you feel. This can improve digestion and reduce stress.",
            "Set boundaries with technology. Designate phone-free times during your day to be more present and reduce digital overwhelm.",
            "Try progressive muscle relaxation. Tense and then relax each muscle group in your body, starting from your toes and working up to your head.",
            "Spend time in nature, even if it's just looking at plants or sitting by a window. Nature has proven benefits for reducing anxiety and improving mood.",
            "Practice self-compassion. Treat yourself with the same kindness you'd show a good friend. Remember that everyone makes mistakes and has difficult days.",
            "Keep a mood journal. Track your emotions and what might be influencing them. This awareness can help you identify patterns and triggers.",
            "Try the 20-20-20 rule for eye strain: Every 20 minutes, look at something 20 feet away for 20 seconds. This helps if you spend a lot of time on screens.",
            "Practice saying 'no' to commitments that drain your energy. Protecting your time and energy is essential for mental health.",
            "Do something creative today, whether it's drawing, writing, cooking, or crafting. Creative activities can be therapeutic and boost self-esteem.",
            "Focus on your posture. Sitting or standing up straight can actually improve your mood and confidence levels throughout the day.",
            "Try aromatherapy. Scents like lavender, peppermint, or citrus can help reduce stress and improve your emotional state.",
            "Practice the 'two-minute rule': If something takes less than two minutes to do, do it now. This prevents small tasks from becoming overwhelming.",
            "End your day by reflecting on one positive moment. This practice can help you sleep better and wake up with a more positive mindset.",
            "Take micro-breaks throughout your workday. Stand up, stretch, or do a few deep breaths every hour to maintain energy and focus.",
            "Try listening to calming music or nature sounds when you feel stressed. Audio can be a powerful tool for mood regulation.",
            "Practice portion control and eat regular meals. Stable blood sugar levels help maintain stable moods throughout the day.",
            "Declutter one small area of your space. A tidy environment can lead to a clearer, calmer mind and reduced anxiety.",
            "Learn something new today, even if it's just for 10 minutes. Learning stimulates the brain and can boost confidence and mood.",
            "Practice deep belly breathing. Place one hand on your chest and one on your belly. Focus on making the belly hand move more than the chest hand.",
            "Reach out for help when you need it. Whether it's professional support or talking to a trusted friend, asking for help is a sign of strength.",
            "Try the 'STOP' technique when overwhelmed: Stop what you're doing, Take a breath, Observe your thoughts and feelings, then Proceed mindfully.",
            "Celebrate small wins. Acknowledge your daily accomplishments, no matter how minor they might seem. Every step forward matters.",
            "Practice loving-kindness meditation. Send positive thoughts to yourself, loved ones, and even difficult people in your life. This builds emotional resilience."
        ];
        
        // Use the day of year to ensure the same tip shows all day but changes daily
        $dayOfYear = Carbon::now()->dayOfYear;
        $tipIndex = ($dayOfYear - 1) % count($tips);
        
        return $tips[$tipIndex];
    }
}