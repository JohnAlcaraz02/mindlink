<?php

namespace App\Http\Controllers;

use App\Models\MoodCheckin;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MoodController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'mood' => 'required|integer|min:1|max:5',
            'note' => 'nullable|string|max:500'
        ]);

        // Check if user already checked in today
        $today = Carbon::today();
        $existingCheckin = MoodCheckin::where('user_id', auth()->id())
            ->whereDate('created_at', $today)
            ->first();

        if ($existingCheckin) {
            // Update existing check-in
            $existingCheckin->update([
                'mood_value' => $request->mood,
                'note' => $request->note
            ]);
            
            return redirect()->route('dashboard')
                ->with('success', 'Your mood has been updated for today!');
        }

        // Create new check-in
        MoodCheckin::create([
            'user_id' => auth()->id(),
            'mood_value' => $request->mood,
            'note' => $request->note
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Thanks for checking in today! 🎉');
    }
}