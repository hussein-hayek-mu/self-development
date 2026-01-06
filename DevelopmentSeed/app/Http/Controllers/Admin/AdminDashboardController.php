<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use App\Models\Quest;
use App\Models\User;
use Illuminate\Http\Request;


class AdminDashboardController extends Controller
{
    
    public function index()
    {
        
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

        
        $recentUsers = User::orderBy('created_at', 'desc')
            ->take(10)
            ->get(['id', 'name', 'email', 'level', 'xp', 'created_at', 'rank_title']);

        
        $topUsers = User::orderBy('level', 'desc')
            ->orderBy('total_xp', 'desc')
            ->take(10)
            ->get(['id', 'name', 'level', 'total_xp', 'rank_title', 'current_streak']);

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentUsers' => $recentUsers,
            'topUsers' => $topUsers,
        ]);
    }
}
