<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class QuestManagementController extends Controller
{
    /**
     * Display a listing of all quests.
     */
    public function index(Request $request): Response
    {
        $query = Quest::with('user');

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

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty) {
            $query->where('difficulty', $request->difficulty);
        }

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $quests = $query->paginate(15)->withQueryString();

        // Get statistics
        $totalQuests = Quest::count();
        $stats = [
            'totalQuests' => $totalQuests,
            'dailyQuests' => Quest::where('type', 'daily')->count(),
            'weeklyQuests' => Quest::where('type', 'weekly')->count(),
            'bossQuests' => Quest::where('type', 'boss')->count(),
            'activeQuests' => Quest::where('status', 'active')->count(),
            'completedQuests' => Quest::where('status', 'completed')->count(),
            'completionRate' => $totalQuests > 0
                ? round((Quest::where('status', 'completed')->count() / $totalQuests) * 100, 1)
                : 0,
            'totalXpRewarded' => Quest::where('status', 'completed')->sum('xp_reward'),
        ];

        return Inertia::render('Admin/Quests/Index', [
            'quests' => $quests,
            'stats' => $stats,
            'filters' => [
                'search' => $request->search,
                'type' => $request->type,
                'status' => $request->status,
                'difficulty' => $request->difficulty,
                'sort' => $sortField,
                'direction' => $sortDirection,
            ],
        ]);
    }

    /**
     * Display the specified quest.
     */
    public function show(Quest $quest): Response
    {
        $quest->load(['user', 'completions']);

        return Inertia::render('Admin/Quests/Show', [
            'quest' => $quest,
        ]);
    }

    /**
     * Remove the specified quest.
     */
    public function destroy(Quest $quest): RedirectResponse
    {
        $quest->delete();

        return redirect()->route('admin.quests.index')->with('success', 'Quest deleted successfully!');
    }
}
