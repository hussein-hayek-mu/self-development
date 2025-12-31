<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">Dashboard</h1>
        <p class="text-gray-400 mt-2">Welcome back, {{ $user['name'] }}! Ready to level up today?</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Level Card -->
        <div class="game-card text-center">
            <div class="level-badge mx-auto mb-3 w-16 h-16 text-2xl">{{ $user['level'] }}</div>
            <div class="font-semibold text-lg">{{ $user['title'] }}</div>
            <div class="text-sm text-gray-400">Current Level</div>
        </div>

        <!-- XP Progress Card -->
        <div class="game-card">
            <h3 class="text-sm text-gray-400 mb-2">XP Progress</h3>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-purple-400 font-semibold">{{ number_format($user['currentXp']) }} XP</span>
                <span class="text-gray-500">{{ number_format($user['xpForNextLevel']) }} XP</span>
            </div>
            <div class="xp-bar-container">
                <div class="xp-bar-fill" style="width: {{ $user['xpProgress'] }}%"></div>
            </div>
        </div>

        <!-- Streak Card -->
        <div class="game-card text-center">
            <div class="text-4xl mb-2">🔥</div>
            <div class="text-2xl font-bold text-orange-400">{{ $user['currentStreak'] }}</div>
            <div class="text-sm text-gray-400">Day Streak</div>
        </div>

        <!-- Total XP Card -->
        <div class="game-card text-center">
            <div class="text-4xl mb-2">⭐</div>
            <div class="text-2xl font-bold text-purple-400">{{ number_format($user['totalXp']) }}</div>
            <div class="text-sm text-gray-400">Total XP Earned</div>
        </div>
    </div>

    <!-- Today's Progress -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Today's Habits -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Today's Habits</h2>
                <a href="{{ route('habits.index') }}" class="text-purple-400 hover:text-purple-300 text-sm">View All →</a>
            </div>
            
            @if($habits->isEmpty())
                <div class="game-card text-center py-8">
                    <div class="text-4xl mb-3">🎯</div>
                    <p class="text-gray-400 mb-4">No habits yet. Start building your routine!</p>
                    <a href="{{ route('habits.index') }}" class="btn-primary btn-small">Add Habit</a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($habits->take(5) as $habit)
                        <div class="habit-card {{ $habit->completed_today ? 'completed' : '' }}">
                            <div class="flex items-center gap-3">
                                <form action="{{ route('habits.toggle', $habit) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-8 h-8 rounded-full border-2 flex items-center justify-center transition-all {{ $habit->completed_today ? 'bg-green-500 border-green-500 text-white' : 'border-purple-500/50 hover:border-purple-500' }}">
                                        @if($habit->completed_today)
                                            ✓
                                        @endif
                                    </button>
                                </form>
                                <div>
                                    <div class="font-medium {{ $habit->completed_today ? 'line-through text-gray-500' : '' }}">{{ $habit->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $habit->icon ?? '🎯' }} +{{ $habit->xp_reward }} XP</div>
                                </div>
                            </div>
                            <div class="streak-badge">
                                🔥 {{ $habit->current_streak }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Active Quests -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Active Quests</h2>
                <a href="{{ route('quests.index') }}" class="text-purple-400 hover:text-purple-300 text-sm">View All →</a>
            </div>
            
            @if($activeQuests->isEmpty())
                <div class="game-card text-center py-8">
                    <div class="text-4xl mb-3">⚔️</div>
                    <p class="text-gray-400 mb-4">No active quests. Create your first quest!</p>
                    <a href="{{ route('quests.index') }}" class="btn-primary btn-small">Add Quest</a>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($activeQuests->take(5) as $quest)
                        <div class="quest-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="quest-badge {{ $quest->type }}">{{ ucfirst($quest->type) }}</span>
                                <span class="difficulty-badge {{ $quest->difficulty }}">{{ ucfirst($quest->difficulty) }}</span>
                            </div>
                            <h3 class="font-medium mb-1">{{ $quest->title }}</h3>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-purple-400">+{{ $quest->xp_reward }} XP</span>
                                @if($quest->due_date)
                                    <span class="text-gray-500">Due: {{ $quest->due_date->format('M d') }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
