<x-admin-layout>
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">Quest Management</h1>
            <p class="text-gray-400 mt-2">Manage all quests across the platform</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="game-card mb-6">
        <form method="GET" action="{{ route('admin.quests.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Search</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" class="form-input" placeholder="Search quests...">
            </div>
            <div class="w-40">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="daily" {{ ($filters['type'] ?? '') === 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="weekly" {{ ($filters['type'] ?? '') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                    <option value="boss" {{ ($filters['type'] ?? '') === 'boss' ? 'selected' : '' }}>Boss</option>
                </select>
            </div>
            <div class="w-40">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ ($filters['status'] ?? '') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="failed" {{ ($filters['status'] ?? '') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div class="w-40">
                <label class="form-label">Sort By</label>
                <select name="sort" class="form-select">
                    <option value="created_at" {{ ($filters['sort'] ?? '') === 'created_at' ? 'selected' : '' }}>Date Created</option>
                    <option value="title" {{ ($filters['sort'] ?? '') === 'title' ? 'selected' : '' }}>Title</option>
                    <option value="xp_reward" {{ ($filters['sort'] ?? '') === 'xp_reward' ? 'selected' : '' }}>XP Reward</option>
                </select>
            </div>
            <button type="submit" class="btn-primary btn-small">Filter</button>
            <a href="{{ route('admin.quests.index') }}" class="btn-secondary btn-small">Reset</a>
        </form>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <div class="stat-card">
            <div class="stat-icon">⚔️</div>
            <div>
                <div class="stat-value">{{ number_format($stats['total']) }}</div>
                <div class="stat-label">Total Quests</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🎯</div>
            <div>
                <div class="stat-value">{{ number_format($stats['active']) }}</div>
                <div class="stat-label">Active</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🏆</div>
            <div>
                <div class="stat-value">{{ number_format($stats['completed']) }}</div>
                <div class="stat-label">Completed</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚡</div>
            <div>
                <div class="stat-value">{{ number_format($stats['totalXpRewarded']) }}</div>
                <div class="stat-label">XP Rewarded</div>
            </div>
        </div>
    </div>

    <!-- Quests Table -->
    <div class="game-card overflow-x-auto">
        <table class="game-table">
            <thead>
                <tr>
                    <th>Quest</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>XP</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>Due</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($quests as $quest)
                    <tr>
                        <td>
                            <div class="font-medium">{{ $quest->title }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($quest->description, 40) }}</div>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $quest->user) }}" class="text-purple-400 hover:text-purple-300">
                                {{ $quest->user->name }}
                            </a>
                        </td>
                        <td>
                            <span class="quest-badge {{ $quest->type }}">{{ ucfirst($quest->type) }}</span>
                        </td>
                        <td class="text-purple-400 font-bold">+{{ $quest->xp_reward }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="w-20 h-2 bg-gray-700 rounded-full overflow-hidden">
                                    @php
                                        $progress = $quest->target > 0 ? round(($quest->progress / $quest->target) * 100) : 0;
                                    @endphp
                                    <div class="h-full bg-gradient-to-r from-purple-600 to-pink-500" style="width: {{ $progress }}%"></div>
                                </div>
                                <span class="text-xs text-gray-400">{{ $quest->progress }}/{{ $quest->target }}</span>
                            </div>
                        </td>
                        <td>
                            @if($quest->status === 'completed')
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-green-500/20 text-green-400">Completed</span>
                            @elseif($quest->status === 'failed')
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-red-500/20 text-red-400">Failed</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-blue-500/20 text-blue-400">Active</span>
                            @endif
                        </td>
                        <td class="text-gray-400 text-sm">
                            @if($quest->due_date)
                                {{ $quest->due_date->format('M d') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.quests.show', $quest) }}" class="p-2 text-gray-400 hover:text-white hover:bg-purple-500/20 rounded-lg transition-colors" title="View">
                                    👁️
                                </a>
                                <form action="{{ route('admin.quests.destroy', $quest) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/20 rounded-lg transition-colors" title="Delete">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-gray-500 py-8">No quests found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $quests->links() }}
    </div>
</x-admin-layout>
