<x-admin-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">Admin Dashboard</h1>
        <p class="text-gray-400 mt-2">Overview of your Level Up platform</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-8">
        <div class="game-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-blue-500/20 flex items-center justify-center text-2xl">👥</div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($stats['totalUsers']) }}</div>
                    <div class="text-sm text-gray-400">Total Users</div>
                </div>
            </div>
        </div>
        <div class="game-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-green-500/20 flex items-center justify-center text-2xl">✅</div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($stats['activeUsers']) }}</div>
                    <div class="text-sm text-gray-400">Active (7 days)</div>
                </div>
            </div>
        </div>
        <div class="game-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-orange-500/20 flex items-center justify-center text-2xl">🔥</div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($stats['totalHabits']) }}</div>
                    <div class="text-sm text-gray-400">Total Habits</div>
                </div>
            </div>
        </div>
        <div class="game-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-purple-500/20 flex items-center justify-center text-2xl">⚔️</div>
                <div>
                    <div class="text-2xl font-bold text-white">{{ number_format($stats['totalQuests']) }}</div>
                    <div class="text-sm text-gray-400">Total Quests</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="stat-card">
            <div class="stat-value text-green-400">{{ $stats['newUsersToday'] }}</div>
            <div class="stat-label">New Today</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-blue-400">{{ $stats['newUsersThisWeek'] }}</div>
            <div class="stat-label">This Week</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-purple-400">{{ $stats['newUsersThisMonth'] }}</div>
            <div class="stat-label">This Month</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-yellow-400">{{ number_format($stats['totalXpAwarded']) }}</div>
            <div class="stat-label">Total XP Awarded</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-pink-400">{{ $stats['averageLevel'] }}</div>
            <div class="stat-label">Avg Level</div>
        </div>
    </div>

    <!-- Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Users -->
        <div class="game-card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Recent Users</h2>
                <a href="{{ route('admin.users.index') }}" class="text-purple-400 hover:text-purple-300 text-sm">View All →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="game-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Level</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentUsers as $user)
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-purple-500/30 flex items-center justify-center text-sm font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-medium">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-purple-400 font-semibold">Lv.{{ $user->level ?? 1 }}</span>
                                </td>
                                <td class="text-gray-400 text-sm">{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-gray-500 py-4">No users yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Users -->
        <div class="game-card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Top Users</h2>
                <span class="text-sm text-gray-400">By Level</span>
            </div>
            <div class="overflow-x-auto">
                <table class="game-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Level</th>
                            <th>XP</th>
                            <th>Streak</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topUsers as $index => $user)
                            <tr>
                                <td>
                                    @if($index === 0)
                                        <span class="text-yellow-400">🥇</span>
                                    @elseif($index === 1)
                                        <span class="text-gray-400">🥈</span>
                                    @elseif($index === 2)
                                        <span class="text-orange-400">🥉</span>
                                    @else
                                        <span class="text-gray-500">{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <div class="font-medium">{{ $user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $user->rank_title ?? 'Novice' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-purple-400 font-bold">{{ $user->level ?? 1 }}</span>
                                </td>
                                <td class="text-gray-400">{{ number_format($user->total_xp ?? 0) }}</td>
                                <td>
                                    <span class="streak-badge text-xs">🔥 {{ $user->current_streak ?? 0 }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">No users yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="mt-8 game-card">
        <h2 class="text-xl font-bold mb-4">Quest Completion</h2>
        <div class="flex items-center gap-8">
            <div>
                <div class="text-3xl font-bold text-green-400">{{ $stats['completedQuests'] }}</div>
                <div class="text-sm text-gray-400">Completed</div>
            </div>
            <div class="flex-1">
                <div class="xp-bar-container h-6">
                    @php
                        $completionRate = $stats['totalQuests'] > 0 ? ($stats['completedQuests'] / $stats['totalQuests']) * 100 : 0;
                    @endphp
                    <div class="xp-bar-fill" style="width: {{ $completionRate }}%"></div>
                </div>
            </div>
            <div>
                <div class="text-3xl font-bold text-gray-400">{{ $stats['totalQuests'] }}</div>
                <div class="text-sm text-gray-400">Total</div>
            </div>
        </div>
    </div>
</x-admin-layout>
