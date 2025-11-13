<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JournalEntry;
use Carbon\Carbon;

class JournalController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get all journal entries for the user
        $entries = JournalEntry::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Calculate statistics
        $totalEntries = $entries->count();
        $thisMonthEntries = JournalEntry::where('user_id', $user->id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        // Get most used tag
        $mostUsedTag = $this->getMostUsedTag($user->id);
        
        return view('journal.index', compact('entries', 'totalEntries', 'thisMonthEntries', 'mostUsedTag'));
    }

    public function create()
    {
        return view('journal.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'mood' => 'nullable|integer|min:1|max:5',
        ]);

        JournalEntry::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'content' => $request->content,
            'tags' => $request->tags,
            'mood' => $request->mood,
        ]);

        return redirect()->route('journal.index')
            ->with('success', 'Journal entry created successfully!');
    }

    public function show($id)
    {
        $entry = JournalEntry::where('user_id', auth()->id())
            ->findOrFail($id);
        
        return view('journal.show', compact('entry'));
    }

    public function edit($id)
    {
        $entry = JournalEntry::where('user_id', auth()->id())
            ->findOrFail($id);
        
        return view('journal.edit', compact('entry'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'tags' => 'nullable|string',
            'mood' => 'nullable|integer|min:1|max:5',
        ]);

        $entry = JournalEntry::where('user_id', auth()->id())
            ->findOrFail($id);
        
        $entry->update([
            'title' => $request->title,
            'content' => $request->content,
            'tags' => $request->tags,
            'mood' => $request->mood,
        ]);

        return redirect()->route('journal.index')
            ->with('success', 'Journal entry updated successfully!');
    }

    public function destroy($id)
    {
        $entry = JournalEntry::where('user_id', auth()->id())
            ->findOrFail($id);
        
        $entry->delete();

        return redirect()->route('journal.index')
            ->with('success', 'Journal entry deleted successfully!');
    }
    
    private function getMostUsedTag($userId)
    {
        $entries = JournalEntry::where('user_id', $userId)
            ->whereNotNull('tags')
            ->get();
        
        if ($entries->isEmpty()) {
            return 'N/A';
        }
        
        $tagCounts = [];
        foreach ($entries as $entry) {
            $tags = array_map('trim', explode(',', $entry->tags));
            foreach ($tags as $tag) {
                if (!empty($tag)) {
                    $tagCounts[$tag] = ($tagCounts[$tag] ?? 0) + 1;
                }
            }
        }
        
        if (empty($tagCounts)) {
            return 'N/A';
        }
        
        arsort($tagCounts);
        return array_key_first($tagCounts);
    }
}