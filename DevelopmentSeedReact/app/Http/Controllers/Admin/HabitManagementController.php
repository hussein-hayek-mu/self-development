<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Habit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HabitManagementController extends Controller
{
    /**
     * Display a listing of all habits.
     */
    public function index(Request $request): Response
    {
        $query = Habit::with('user');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by active status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $habits = $query->paginate(15)->withQueryString();

        // Get statistics
        $stats = [
            'totalHabits' => Habit::count(),
            'activeHabits' => Habit::where('is_active', true)->count(),
            'averageStreak' => round(Habit::avg('current_streak') ?? 0, 1),
            'topStreak' => Habit::max('best_streak') ?? 0,
            'totalCompletions' => Habit::sum('total_completions'),
        ];

        return Inertia::render('Admin/Habits/Index', [
            'habits' => $habits,
            'stats' => $stats,
            'filters' => [
                'search' => $request->search,
                'status' => $request->status,
                'sort' => $sortField,
                'direction' => $sortDirection,
            ],
        ]);
    }

    /**
     * Display the specified habit.
     */
    public function show(Habit $habit): Response
    {
        $habit->load(['user', 'completions' => function ($query) {
            $query->orderBy('completed_date', 'desc')->take(30);
        }]);

        return Inertia::render('Admin/Habits/Show', [
            'habit' => $habit,
        ]);
    }

    /**
     * Remove the specified habit.
     */
    public function destroy(Habit $habit): RedirectResponse
    {
        $habit->delete();

        return redirect()->route('admin.habits.index')->with('success', 'Habit deleted successfully!');
    }
}
