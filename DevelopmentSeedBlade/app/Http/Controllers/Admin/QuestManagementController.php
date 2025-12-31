<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuestManagementController extends Controller
{
    /**
     * Display a listing of all quests.
     */
    public function index(Request $request)
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

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $quests = $query->paginate(15)->withQueryString();

        // Get statistics
        $stats = [
            'total' => Quest::count(),
            'active' => Quest::where('status', 'active')->count(),
            'completed' => Quest::where('status', 'completed')->count(),
            'totalXpRewarded' => Quest::where('status', 'completed')->sum('xp_reward'),
        ];

        return view('admin.quests.index', [
            'quests' => $quests,
            'stats' => $stats,
            'filters' => [
                'search' => $request->search,
                'type' => $request->type,
                'status' => $request->status,
                'sort' => $sortField,
                'direction' => $sortDirection,
            ],
        ]);
    }

    /**
     * Display the specified quest.
     */
    public function show(Quest $quest)
    {
        $quest->load('user');

        return view('admin.quests.show', [
            'quest' => $quest,
        ]);
    }

    /**
     * Update the specified quest.
     */
    public function update(Request $request, Quest $quest): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:daily,weekly,boss',
            'status' => 'required|in:active,completed,failed',
            'xp_reward' => 'required|integer|min:1',
            'target' => 'required|integer|min:1',
            'progress' => 'nullable|integer|min:0',
            'due_date' => 'nullable|date',
        ]);

        $quest->update($validated);

        // If status changed to completed, set completed_at
        if ($validated['status'] === 'completed' && !$quest->completed_at) {
            $quest->completed_at = now();
            $quest->save();
        }

        return redirect()->back()->with('success', 'Quest updated successfully!');
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
