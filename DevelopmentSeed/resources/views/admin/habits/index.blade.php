<x-admin-layout>
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">Habit Management</h1>
            <p class="text-gray-400 mt-2">Manage all habits across the platform</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="game-card mb-6">
        <form method="GET" action="{{ route('admin.habits.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Search</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" class="form-input" placeholder="Search habits...">
            </div>
            <div class="w-40">
                <label class="form-label">Difficulty</label>
                <select name="difficulty" class="form-select">
                    <option value="">All</option>
                    <option value="easy" {{ ($filters['difficulty'] ?? '') === 'easy' ? 'selected' : '' }}>Easy</option>
                    <option value="medium" {{ ($filters['difficulty'] ?? '') === 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="hard" {{ ($filters['difficulty'] ?? '') === 'hard' ? 'selected' : '' }}>Hard</option>
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
            <a href="{{ route('admin.habits.index') }}" class="btn-secondary btn-small">Reset</a>
        </form>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div>
                <div class="stat-value">{{ number_format($stats['total']) }}</div>
                <div class="stat-label">Total Habits</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div>
                <div class="stat-value">{{ number_format($stats['completedToday']) }}</div>
                <div class="stat-label">Completed Today</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🔥</div>
            <div>
                <div class="stat-value">{{ $stats['avgStreak'] }}</div>
                <div class="stat-label">Avg Streak</div>
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

    <!-- Habits Table -->
    <div class="game-card overflow-x-auto">
        <table class="game-table">
            <thead>
                <tr>
                    <th>Habit</th>
                    <th>User</th>
                    <th>Difficulty</th>
                    <th>XP</th>
                    <th>Streak</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($habits as $habit)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <span class="text-2xl">{{ $habit->icon ?? '🎯' }}</span>
                                <div>
                                    <div class="font-medium">{{ $habit->title }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($habit->description, 40) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.show', $habit->user) }}" class="text-purple-400 hover:text-purple-300">
                                {{ $habit->user->name }}
                            </a>
                        </td>
                        <td>
                            <span class="difficulty-badge {{ $habit->difficulty ?? 'medium' }}">
                                {{ ucfirst($habit->difficulty ?? 'medium') }}
                            </span>
                        </td>
                        <td class="text-purple-400 font-bold">+{{ $habit->xp_reward }}</td>
                        <td>
                            <span class="streak-badge text-xs">🔥 {{ $habit->current_streak }}</span>
                        </td>
                        <td class="text-gray-400 text-sm">{{ $habit->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.habits.show', $habit) }}" class="p-2 text-gray-400 hover:text-white hover:bg-purple-500/20 rounded-lg transition-colors" title="View">
                                    👁️
                                </a>
                                <form action="{{ route('admin.habits.destroy', $habit) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="7" class="text-center text-gray-500 py-8">No habits found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $habits->links() }}
    </div>
</x-admin-layout>
