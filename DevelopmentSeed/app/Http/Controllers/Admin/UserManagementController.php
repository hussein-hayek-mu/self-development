<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * Admin CRUD, banning, and stats for any user account.
 */
class UserManagementController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $users = $query->paginate(15)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'filters' => [
                'search' => $request->search,
                'role' => $request->role,
                'sort' => $sortField,
                'direction' => $sortDirection,
            ],
        ]);
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load(['habits', 'quests']);

        $userStats = [
            'totalHabits' => $user->habits->count(),
            'completedHabitsToday' => $user->habits->filter(function ($habit) {
                return $habit->completions()
                    ->whereDate('completion_date', today())
                    ->exists();
            })->count(),
            'totalQuests' => $user->quests->count(),
            'completedQuests' => $user->quests->where('status', 'completed')->count(),
            'longestStreak' => $user->habits->max('longest_streak') ?? 0,
        ];

        return view('admin.users.show', [
            'user' => $user,
            'userStats' => $userStats,
        ]);
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'level' => 'nullable|integer|min:1',
            'xp' => 'nullable|integer|min:0',
            'rank_title' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return redirect()->back()->with('success', 'User updated successfully!');
    }

    /**
     * Ban/Unban a user.
     */
    public function toggleBan(User $user): RedirectResponse
    {
        $user->is_banned = !$user->is_banned;
        $user->banned_at = $user->is_banned ? now() : null;
        $user->save();

        $message = $user->is_banned ? 'User has been banned.' : 'User has been unbanned.';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}
