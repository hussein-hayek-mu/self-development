<?php

namespace App\Http\Controllers;

use App\Models\Habit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * CRUD and toggles for a user's own habits.
 */
class HabitController extends Controller
{
    /**
     * Display a listing of habits.
     */
    public function index(Request $request)
    {
        $habits = $request->user()->getTodayHabits();

        return view('habits.index', [
            'habits' => $habits,
        ]);
    }

    /**
     * Store a newly created habit.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'xp_reward' => 'required|integer|min:1|max:1000',
            'description' => 'nullable|string|max:500',
            'frequency' => 'nullable|in:daily,weekly',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
        ]);

        Habit::create([
            'user_id' => $request->user()->id,
            'title' => $validated['title'],
            'xp_reward' => $validated['xp_reward'],
            'description' => $validated['description'] ?? null,
            'frequency' => $validated['frequency'] ?? 'daily',
            'icon' => $validated['icon'] ?? '🎯',
            'color' => $validated['color'] ?? 'purple',
            'current_streak' => 0,
            'longest_streak' => 0,
            'times_completed' => 0,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Habit created successfully!');
    }

    /**
     * Update the specified habit.
     */
    public function update(Request $request, Habit $habit): RedirectResponse
    {
        // Ensure user owns the habit
        if ($habit->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'xp_reward' => 'required|integer|min:1|max:1000',
            'description' => 'nullable|string|max:500',
            'frequency' => 'nullable|in:daily,weekly',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
        ]);

        $habit->update($validated);

        return redirect()->back()->with('success', 'Habit updated successfully!');
    }

    /**
     * Toggle habit completion for today.
     */
    public function toggle(Request $request, Habit $habit): RedirectResponse
    {
        // Ensure user owns the habit
        if ($habit->user_id !== $request->user()->id) {
            abort(403);
        }

        $today = now()->toDateString();
        $existingCompletion = $habit->completions()
            ->where('completion_date', $today)
            ->first();

        if ($existingCompletion) {
            // Uncomplete: remove the completion record
            $existingCompletion->delete();

            // Decrease streak
            $habit->current_streak = max(0, $habit->current_streak - 1);
            $habit->times_completed = max(0, $habit->times_completed - 1);
            $habit->save();
        } else {
            // Complete the habit using the model method
            $habit->complete();

            // Update user streak
            $request->user()->updateStreak();
        }

        return redirect()->back();
    }

    /**
     * Remove the specified habit.
     */
    public function destroy(Request $request, Habit $habit): RedirectResponse
    {
        // Ensure user owns the habit
        if ($habit->user_id !== $request->user()->id) {
            abort(403);
        }

        $habit->delete();

        return redirect()->back()->with('success', 'Habit deleted successfully!');
    }
}
