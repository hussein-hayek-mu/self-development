<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class QuestController extends Controller
{
    
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $dailyQuests = Quest::where('user_id', $userId)
            ->where('type', 'daily')
            ->orderByRaw("FIELD(status, 'active', 'completed', 'failed')")
            ->orderBy('due_date')
            ->get();

        $weeklyQuests = Quest::where('user_id', $userId)
            ->where('type', 'weekly')
            ->orderByRaw("FIELD(status, 'active', 'completed', 'failed')")
            ->orderBy('due_date')
            ->get();

        $bossQuests = Quest::where('user_id', $userId)
            ->where('type', 'boss')
            ->orderByRaw("FIELD(status, 'active', 'completed', 'failed')")
            ->orderBy('due_date')
            ->get();

        return view('quests.index', [
            'dailyQuests' => $dailyQuests,
            'weeklyQuests' => $weeklyQuests,
            'bossQuests' => $bossQuests,
        ]);
    }

    
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:daily,weekly,boss',
            'xp_reward' => 'required|integer|min:1|max:5000',
            'due_date' => 'nullable|date',
            'difficulty' => 'required|in:easy,medium,hard',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
        ]);

        
        $difficultyMultiplier = match ($validated['difficulty']) {
            'easy' => 1,
            'medium' => 1.5,
            'hard' => 2,
            default => 1,
        };

        Quest::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'type' => $validated['type'],
            'xp_reward' => (int) ($validated['xp_reward'] * $difficultyMultiplier),
            'due_date' => $validated['due_date'],
            'difficulty' => $validated['difficulty'],
            'description' => $validated['description'] ?? null,
            'icon' => $validated['icon'] ?? '⚔️',
            'status' => 'active',
            'progress' => 0,
            'target' => 1,
        ]);

        return redirect()->back()->with('success', 'Quest created successfully!');
    }

    
    public function update(Request $request, Quest $quest): RedirectResponse
    {
        
        if ($quest->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:daily,weekly,boss',
            'xp_reward' => 'required|integer|min:1|max:5000',
            'due_date' => 'nullable|date',
            'difficulty' => 'required|in:easy,medium,hard',
            'description' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:50',
        ]);

        $quest->update($validated);

        return redirect()->back()->with('success', 'Quest updated successfully!');
    }

    
    public function complete(Request $request, Quest $quest): RedirectResponse
    {
        
        if ($quest->user_id !== $request->user()->id) {
            abort(403);
        }

        if ($quest->status !== 'completed') {
            
            $quest->complete();

            
            $request->user()->updateStreak();
        }

        return redirect()->back()->with('success', 'Quest completed! XP awarded!');
    }

    
    public function destroy(Request $request, Quest $quest): RedirectResponse
    {
        
        if ($quest->user_id !== $request->user()->id) {
            abort(403);
        }

        $quest->delete();

        return redirect()->back()->with('success', 'Quest deleted successfully!');
    }
}
