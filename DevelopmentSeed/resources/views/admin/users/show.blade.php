<x-admin-layout>
    <!-- Breadcrumb -->
    <x-slot name="breadcrumb">
        <a href="{{ route('admin.users.index') }}" class="hover:text-purple-400">Users</a>
        <span class="mx-2">→</span>
        <span class="text-white">{{ $user->name }}</span>
    </x-slot>

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white text-2xl font-bold">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">{{ $user->name }}</h1>
                <p class="text-gray-400">{{ $user->email }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <form action="{{ route('admin.users.toggle-ban', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="{{ $user->is_banned ? 'btn-success' : 'btn-danger' }} btn-small">
                    {{ $user->is_banned ? 'Unban User' : 'Ban User' }}
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- User Info Card -->
        <div class="lg:col-span-1">
            <div class="game-card">
                <h2 class="text-lg font-bold mb-4">User Information</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Role</span>
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-500/20 text-purple-400' : 'bg-gray-500/20 text-gray-400' }}">
                            {{ ucfirst($user->role ?? 'user') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Status</span>
                        @if($user->is_banned)
                            <span class="px-2 py-1 rounded text-xs font-semibold bg-red-500/20 text-red-400">Banned</span>
                        @else
                            <span class="px-2 py-1 rounded text-xs font-semibold bg-green-500/20 text-green-400">Active</span>
                        @endif
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Level</span>
                        <span class="text-purple-400 font-bold">{{ $user->level ?? 1 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Title</span>
                        <span>{{ $user->rank_title ?? 'Novice' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Current XP</span>
                        <span>{{ number_format($user->xp ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Total XP</span>
                        <span>{{ number_format($user->total_xp ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Current Streak</span>
                        <span class="streak-badge text-xs">🔥 {{ $user->current_streak ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Longest Streak</span>
                        <span>{{ $user->longest_streak ?? 0 }} days</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Joined</span>
                        <span>{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="game-card mt-6">
                <h2 class="text-lg font-bold mb-4">Activity Stats</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="stat-card">
                        <div class="stat-value text-sm">{{ $userStats['totalHabits'] }}</div>
                        <div class="stat-label text-xs">Habits</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value text-sm">{{ $userStats['completedHabitsToday'] }}</div>
                        <div class="stat-label text-xs">Done Today</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value text-sm">{{ $userStats['totalQuests'] }}</div>
                        <div class="stat-label text-xs">Quests</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value text-sm">{{ $userStats['completedQuests'] }}</div>
                        <div class="stat-label text-xs">Completed</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="game-card">
                <h2 class="text-lg font-bold mb-4">Edit User</h2>
                
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Rank Title</label>
                            <input type="text" name="rank_title" value="{{ $user->rank_title }}" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Level</label>
                            <input type="number" name="level" value="{{ $user->level ?? 1 }}" min="1" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">XP</label>
                            <input type="number" name="xp" value="{{ $user->xp ?? 0 }}" min="0" class="form-input">
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- User's Habits -->
            <div class="game-card mt-6">
                <h2 class="text-lg font-bold mb-4">User's Habits ({{ $user->habits->count() }})</h2>
                @if($user->habits->isEmpty())
                    <p class="text-gray-500 text-center py-4">No habits</p>
                @else
                    <div class="space-y-2">
                        @foreach($user->habits->take(5) as $habit)
                            <div class="flex items-center justify-between p-3 bg-[#1a1a25] rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span>{{ $habit->icon ?? '🎯' }}</span>
                                    <span>{{ $habit->title }}</span>
                                </div>
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="text-purple-400">+{{ $habit->xp_reward }} XP</span>
                                    <span class="streak-badge text-xs">🔥 {{ $habit->current_streak }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- User's Quests -->
            <div class="game-card mt-6">
                <h2 class="text-lg font-bold mb-4">User's Quests ({{ $user->quests->count() }})</h2>
                @if($user->quests->isEmpty())
                    <p class="text-gray-500 text-center py-4">No quests</p>
                @else
                    <div class="space-y-2">
                        @foreach($user->quests->take(5) as $quest)
                            <div class="flex items-center justify-between p-3 bg-[#1a1a25] rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="quest-badge {{ $quest->type }}">{{ ucfirst($quest->type) }}</span>
                                    <span>{{ $quest->title }}</span>
                                </div>
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="text-purple-400">+{{ $quest->xp_reward }} XP</span>
                                    @if($quest->status === 'completed')
                                        <span class="text-green-400">✓</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
