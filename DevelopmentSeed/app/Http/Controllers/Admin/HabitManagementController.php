<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use App\Models\HabitCompletion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;


class HabitManagementController extends Controller
{
    
    public function index(Request $request)
    {
        $query = Habit::with('user');

        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        
        if ($request->has('difficulty') && $request->difficulty) {
            $query->where('difficulty', $request->difficulty);
        }

        
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $habits = $query->paginate(15)->withQueryString();

        
        $stats = [
            'total' => Habit::count(),
            'completedToday' => HabitCompletion::whereDate('completion_date', today())->count(),
            'avgStreak' => round(Habit::avg('current_streak') ?? 0, 1),
            'totalXpRewarded' => Habit::sum('xp_reward') * (Habit::avg('times_completed') ?? 0),
        ];

        return view('admin.habits.index', [
            'habits' => $habits,
            'stats' => $stats,
            'filters' => [
                'search' => $request->search,
                'difficulty' => $request->difficulty,
                'sort' => $sortField,
                'direction' => $sortDirection,
            ],
        ]);
    }

    
    public function show(Habit $habit)
    {
        $habit->load('user');

        $recentCompletions = HabitCompletion::where('habit_id', $habit->id)
            ->orderBy('completion_date', 'desc')
            ->take(10)
            ->get();

        return view('admin.habits.show', [
            'habit' => $habit,
            'recentCompletions' => $recentCompletions,
        ]);
    }

    
    public function update(Request $request, Habit $habit): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:10',
            'difficulty' => 'required|in:easy,medium,hard',
            'xp_reward' => 'required|integer|min:1',
            'frequency' => 'required|in:daily,weekly',
        ]);

        $habit->update($validated);

        return redirect()->back()->with('success', 'Habit updated successfully!');
    }

    
    public function destroy(Habit $habit): RedirectResponse
    {
        $habit->delete();

        return redirect()->route('admin.habits.index')->with('success', 'Habit deleted successfully!');
    }
}
