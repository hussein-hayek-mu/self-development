<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use App\Models\Quest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): Response
    {
        // Get statistics
        $stats = [
            'totalUsers' => User::count(),
            'activeUsers' => User::where('last_activity_date', '>=', now()->subDays(7))->count(),
            'totalHabits' => Habit::count(),
            'totalQuests' => Quest::count(),
            'completedQuests' => Quest::where('status', 'completed')->count(),
            'newUsersToday' => User::whereDate('created_at', today())->count(),
            'newUsersThisWeek' => User::where('created_at', '>=', now()->subDays(7))->count(),
            'newUsersThisMonth' => User::where('created_at', '>=', now()->subDays(30))->count(),
            'totalXpAwarded' => User::sum('total_xp'),
            'averageLevel' => round(User::avg('level') ?? 1, 1),
        ];

        // Get recent users
        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(10)
            ->get(['id', 'name', 'email', 'level', 'xp', 'created_at', 'rank_title']);

        // Get top users by level
        $topUsers = User::orderBy('level', 'desc')
            ->orderBy('total_xp', 'desc')
            ->take(10)
            ->get(['id', 'name', 'level', 'total_xp', 'rank_title', 'current_streak']);

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'topUsers' => $topUsers,
        ]);
    }
}
