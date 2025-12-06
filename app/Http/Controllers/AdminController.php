<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\JournalEntry;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        // Get selected college from request
        $selectedCollege = $request->input('college', 'all');

        // Build base query for users
        $userQuery = User::where('user_type', 'Student');
        if ($selectedCollege !== 'all') {
            $userQuery->where('college', $selectedCollege);
        }

        // Get user IDs for filtered college
        $filteredUserIds = $userQuery->pluck('id');

        // Total users
        $totalUsers = $userQuery->count();
        $activeToday = $userQuery->whereDate('updated_at', today())->count();

        // Journal entries (filtered by college users)
        $totalJournalEntries = JournalEntry::whereIn('user_id', $filteredUserIds)->count();

        // Chat messages (filtered by college users)
        $totalChatMessages = ChatMessage::whereIn('user_id', $filteredUserIds)->count();

        // Average mood (from mood check-ins, filtered by college)
        $averageMood = \App\Models\MoodCheckin::whereIn('user_id', $filteredUserIds)->avg('mood_value');
        $averageMood = $averageMood ? round($averageMood, 1) : 0;

        // Get college statistics for comparison
        $collegeStats = $this->getCollegeStats();

        // Popular topics - get all tags and count frequency (filtered)
        $allTags = JournalEntry::whereIn('user_id', $filteredUserIds)
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatMap(function($tags) {
                return array_map('trim', explode(',', $tags));
            })
            ->filter()
            ->countBy()
            ->sortDesc()
            ->take(10);

        $topicLabels = $allTags->keys()->toArray();
        $topicData = $allTags->values()->toArray();

        // 7-day activity data
        $activityData = $this->getActivityData();

        // Chat room activity (last 24h) - grouped by room/topic
        $chatRoomActivity = $this->getChatRoomActivity();

        // Feature engagement - calculate percentage of users who used each feature
        $featureEngagement = $this->getFeatureEngagement();

        // Well-being data
        $moodDistribution = $this->getMoodDistribution();
        $insights = $this->getInsights();

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeToday',
            'totalJournalEntries',
            'totalChatMessages',
            'averageMood',
            'topicLabels',
            'topicData',
            'activityData',
            'chatRoomActivity',
            'featureEngagement',
            'moodDistribution',
            'insights',
            'selectedCollege',
            'collegeStats'
        ));
    }

    private function getCollegeStats()
    {
        $colleges = [
            'College of Engineering',
            'College of Engineering Technology',
            'College of Informatics and Computing Sciences',
            'College of Architecture Fine Arts and Design'
        ];

        $stats = [];

        foreach ($colleges as $college) {
            $userIds = User::where('college', $college)->pluck('id');
            $avgMood = \App\Models\MoodCheckin::whereIn('user_id', $userIds)->avg('mood_value');
            $studentCount = $userIds->count();

            $stats[] = [
                'name' => $college,
                'short_name' => $this->getCollegeShortName($college),
                'avg_mood' => $avgMood ? round($avgMood, 1) : 0,
                'student_count' => $studentCount,
                'stress_level' => $avgMood ? $this->calculateStressLevel($avgMood) : 'No Data'
            ];
        }

        // Sort by average mood (ascending = more stressed)
        usort($stats, function($a, $b) {
            if ($a['avg_mood'] == 0) return 1;
            if ($b['avg_mood'] == 0) return -1;
            return $a['avg_mood'] <=> $b['avg_mood'];
        });

        return $stats;
    }

    private function getCollegeShortName($college)
    {
        $shortNames = [
            'College of Engineering' => 'COE',
            'College of Engineering Technology' => 'CET',
            'College of Informatics and Computing Sciences' => 'CICS',
            'College of Architecture Fine Arts and Design' => 'CAFAD'
        ];

        return $shortNames[$college] ?? $college;
    }

    private function calculateStressLevel($avgMood)
    {
        if ($avgMood >= 4) return 'Low Stress';
        if ($avgMood >= 3) return 'Moderate Stress';
        if ($avgMood >= 2) return 'High Stress';
        return 'Very High Stress';
    }
    
    private function getActivityData()
    {
        $dates = [];
        $activeUsers = [];
        $journalEntries = [];
        $messages = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dates[] = $date->format('M j');
            
            // Active users (users who created entries or sent messages that day)
            $activeUsers[] = User::whereDate('updated_at', $date->toDateString())->count();
            
            // Journal entries created that day
            $journalEntries[] = JournalEntry::whereDate('created_at', $date->toDateString())->count();
            
            // Messages sent that day
            $messages[] = ChatMessage::whereDate('created_at', $date->toDateString())->count();
        }
        
        return [
            'dates' => $dates,
            'activeUsers' => $activeUsers,
            'journalEntries' => $journalEntries,
            'messages' => $messages
        ];
    }
    
    private function getChatRoomActivity()
    {
        $last24h = now()->subHours(24);
        
        $roomLabels = [
            'general' => 'General Support',
            'anxiety' => 'Anxiety & Stress',
            'academic' => 'Academic Pressure',
            'counselor-sarah' => 'Counselor Sarah',
            'ai-assistant' => 'AI Assistant',
        ];

        $counts = ChatMessage::where('created_at', '>=', $last24h)
            ->select('room_id', DB::raw('COUNT(*) as count'))
            ->groupBy('room_id')
            ->pluck('count', 'room_id')
            ->toArray();

        $rooms = [];

        foreach ($roomLabels as $roomKey => $label) {
            $rooms[] = [
                'name' => $label,
                'count' => $counts[$roomKey] ?? 0,
            ];
            unset($counts[$roomKey]);
        }

        foreach ($counts as $roomKey => $count) {
            $label = $roomKey ? ucwords(str_replace(['-', '_'], ' ', $roomKey)) : 'Unassigned';
            $rooms[] = [
                'name' => $label,
                'count' => $count,
            ];
        }

        $maxCount = array_reduce($rooms, function ($carry, $room) {
            return max($carry, $room['count']);
        }, 0);

        $denominator = $maxCount > 0 ? $maxCount : 1;

        foreach ($rooms as &$room) {
            $room['percentage'] = $denominator > 0 ? round(($room['count'] / $denominator) * 100, 2) : 0;
        }
        unset($room);

        return $rooms;
    }
    
    private function getFeatureEngagement()
    {
        $totalUsers = User::count();
        
        if ($totalUsers == 0) {
            return [
                ['name' => 'Mood Tracker', 'icon' => '📊', 'percentage' => 0],
                ['name' => 'Chat', 'icon' => '💬', 'percentage' => 0],
                ['name' => 'Journal', 'icon' => '📔', 'percentage' => 0],
                ['name' => 'Resources', 'icon' => '📚', 'percentage' => 0],
            ];
        }
        
        // Count unique users who used each feature
        $moodTrackerUsers = \App\Models\MoodCheckin::distinct('user_id')->count('user_id');
        $chatUsers = ChatMessage::distinct('user_id')->count('user_id');
        $journalUsers = JournalEntry::distinct('user_id')->count('user_id');
        
        // Resources doesn't have tracking yet, so we'll estimate based on active users
        $resourcesUsers = User::whereDate('updated_at', '>=', now()->subDays(7))->count();
        
        return [
            [
                'name' => 'Mood Tracker',
                'icon' => '📊',
                'percentage' => round(($moodTrackerUsers / $totalUsers) * 100)
            ],
            [
                'name' => 'Chat',
                'icon' => '💬',
                'percentage' => round(($chatUsers / $totalUsers) * 100)
            ],
            [
                'name' => 'Journal',
                'icon' => '📔',
                'percentage' => round(($journalUsers / $totalUsers) * 100)
            ],
            [
                'name' => 'Resources',
                'icon' => '📚',
                'percentage' => round(($resourcesUsers / $totalUsers) * 100)
            ],
        ];
    }
    
    private function getMoodDistribution()
    {
        // Get mood distribution from mood check-ins
        $moodCounts = \App\Models\MoodCheckin::selectRaw('mood_value, COUNT(*) as count')
            ->groupBy('mood_value')
            ->pluck('count', 'mood_value')
            ->toArray();
        
        $totalMoods = array_sum($moodCounts);
        
        if ($totalMoods == 0) {
            return [
                'labels' => ['No data'],
                'data' => [1],
                'percentages' => ['No mood data yet']
            ];
        }
        
        // Map mood values to labels
        $moodLabels = [
            1 => 'Very Sad',
            2 => 'Sad',
            3 => 'Okay',
            4 => 'Good',
            5 => 'Great'
        ];
        
        $labels = [];
        $data = [];
        $percentages = [];
        
        foreach ([5, 4, 3, 2, 1] as $mood) {
            if (isset($moodCounts[$mood]) && $moodCounts[$mood] > 0) {
                $labels[] = $moodLabels[$mood];
                $data[] = $moodCounts[$mood];
                $percentage = round(($moodCounts[$mood] / $totalMoods) * 100);
                $percentages[] = $moodLabels[$mood] . ' ' . $percentage . '%';
            }
        }
        
        return [
            'labels' => $labels,
            'data' => $data,
            'percentages' => $percentages
        ];
    }
    
    private function getInsights()
    {
        $insights = [];
        
        // Calculate mood trend (compare this week vs last week)
        $thisWeekAvg = \App\Models\MoodCheckin::where('created_at', '>=', now()->subWeek())
            ->avg('mood_value');
        $lastWeekAvg = \App\Models\MoodCheckin::whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])
            ->avg('mood_value');
        
        if ($thisWeekAvg && $lastWeekAvg) {
            $moodChange = (($thisWeekAvg - $lastWeekAvg) / $lastWeekAvg) * 100;
            if ($moodChange > 5) {
                $insights[] = [
                    'type' => 'positive',
                    'icon' => '📈',
                    'title' => 'Positive Trend:',
                    'message' => 'Average mood increased by ' . round($moodChange) . '% this week'
                ];
            } elseif ($moodChange < -5) {
                $insights[] = [
                    'type' => 'warning',
                    'icon' => '📉',
                    'title' => 'Attention:',
                    'message' => 'Average mood decreased by ' . abs(round($moodChange)) . '% this week'
                ];
            }
        }
        
        // Check chat activity trend
        $thisWeekChats = ChatMessage::where('created_at', '>=', now()->subWeek())->count();
        $lastWeekChats = ChatMessage::whereBetween('created_at', [now()->subWeeks(2), now()->subWeek()])->count();
        
        if ($lastWeekChats > 0) {
            $chatChange = (($thisWeekChats - $lastWeekChats) / $lastWeekChats) * 100;
            if ($chatChange > 20) {
                $insights[] = [
                    'type' => 'info',
                    'icon' => '💬',
                    'title' => 'High Engagement:',
                    'message' => 'Chat activity up ' . round($chatChange) . '% from last week'
                ];
            }
        }
        
        // Check for concerning tags in journals
        $anxietyTags = JournalEntry::where('created_at', '>=', now()->subWeek())
            ->where(function($query) {
                $query->where('tags', 'LIKE', '%anxiety%')
                      ->orWhere('tags', 'LIKE', '%stress%')
                      ->orWhere('tags', 'LIKE', '%worried%');
            })
            ->count();
        
        $totalRecentJournals = JournalEntry::where('created_at', '>=', now()->subWeek())->count();
        
        if ($totalRecentJournals > 0 && ($anxietyTags / $totalRecentJournals) > 0.3) {
            $insights[] = [
                'type' => 'attention',
                'icon' => '⚠️',
                'title' => 'Attention:',
                'message' => '"Anxiety" tag usage increased, consider adding more resources'
            ];
        }
        
        // If no insights, add a default positive message
        if (empty($insights)) {
            $insights[] = [
                'type' => 'positive',
                'icon' => '✨',
                'title' => 'All Good:',
                'message' => 'Platform metrics are stable and healthy'
            ];
        }
        
        return $insights;
    }
}
