<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use App\Models\Quest;
use Illuminate\Http\Request;

/**
 * Authenticated user dashboard data aggregation.
 */
class DashboardController extends Controller
{
    /**
     * Display the user dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Get user's habits for today with completion status
        $habits = $user->getTodayHabits();

        // Get active quests
        $activeQuests = $user->getActiveQuests();

        // Calculate XP progress
        $currentXp = $user->xp ?? 0;
        $level = $user->level ?? 1;
        $xpForNextLevel = $user->xp_to_next_level ?? $user->calculateNextLevelXP();

        return view('dashboard', [
            'user' => [
                'name' => $user->name,
                'level' => $level,
                'title' => $user->rank_title ?? 'Novice Adventurer',
                'currentXp' => $currentXp,
                'xpForNextLevel' => $xpForNextLevel,
                'xpProgress' => $xpForNextLevel > 0 ? min(100, ($currentXp / $xpForNextLevel) * 100) : 0,
                'currentStreak' => $user->current_streak ?? 0,
                'longestStreak' => $user->longest_streak ?? 0,
                'totalXp' => $user->total_xp ?? 0,
            ],
            'habits' => $habits,
            'activeQuests' => $activeQuests,
        ]);
    }
}
