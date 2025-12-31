<x-admin-layout>
    <!-- Breadcrumb -->
    <x-slot name="breadcrumb">
        <a href="{{ route('admin.habits.index') }}" class="hover:text-purple-400">Habits</a>
        <span class="mx-2">→</span>
        <span class="text-white">{{ $habit->title }}</span>
    </x-slot>

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-3xl">
                {{ $habit->icon ?? '🎯' }}
            </div>
            <div>
                <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">{{ $habit->title }}</h1>
                <p class="text-gray-400">Owned by <a href="{{ route('admin.users.show', $habit->user) }}" class="text-purple-400 hover:text-purple-300">{{ $habit->user->name }}</a></p>
            </div>
        </div>
        <form action="{{ route('admin.habits.destroy', $habit) }}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger btn-small">Delete Habit</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Habit Info -->
        <div class="lg:col-span-1">
            <div class="game-card">
                <h2 class="text-lg font-bold mb-4">Habit Details</h2>
                
                <div class="space-y-4">
                    <div>
                        <span class="text-gray-400 text-sm">Description</span>
                        <p class="mt-1">{{ $habit->description ?? 'No description' }}</p>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Difficulty</span>
                        <span class="difficulty-badge {{ $habit->difficulty ?? 'medium' }}">
                            {{ ucfirst($habit->difficulty ?? 'medium') }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">XP Reward</span>
                        <span class="text-purple-400 font-bold">+{{ $habit->xp_reward }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Frequency</span>
                        <span>{{ ucfirst($habit->frequency ?? 'daily') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Current Streak</span>
                        <span class="streak-badge text-xs">🔥 {{ $habit->current_streak }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Longest Streak</span>
                        <span>{{ $habit->longest_streak ?? 0 }} days</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Times Completed</span>
                        <span>{{ $habit->times_completed ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Created</span>
                        <span>{{ $habit->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form & Stats -->
        <div class="lg:col-span-2">
            <div class="game-card">
                <h2 class="text-lg font-bold mb-4">Edit Habit</h2>
                
                <form action="{{ route('admin.habits.update', $habit) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" value="{{ $habit->title }}" class="form-input" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-input" rows="3">{{ $habit->description }}</textarea>
                        </div>
                        <div>
                            <label class="form-label">Icon (emoji)</label>
                            <input type="text" name="icon" value="{{ $habit->icon }}" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Difficulty</label>
                            <select name="difficulty" class="form-select">
                                <option value="easy" {{ $habit->difficulty === 'easy' ? 'selected' : '' }}>Easy</option>
                                <option value="medium" {{ $habit->difficulty === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="hard" {{ $habit->difficulty === 'hard' ? 'selected' : '' }}>Hard</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">XP Reward</label>
                            <input type="number" name="xp_reward" value="{{ $habit->xp_reward }}" min="1" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Frequency</label>
                            <select name="frequency" class="form-select">
                                <option value="daily" {{ ($habit->frequency ?? 'daily') === 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ ($habit->frequency ?? 'daily') === 'weekly' ? 'selected' : '' }}>Weekly</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- Recent Completions -->
            <div class="game-card mt-6">
                <h2 class="text-lg font-bold mb-4">Recent Completions</h2>
                @if($recentCompletions->isEmpty())
                    <p class="text-gray-500 text-center py-4">No completions yet</p>
                @else
                    <div class="space-y-2">
                        @foreach($recentCompletions as $completion)
                            <div class="flex items-center justify-between p-3 bg-[#1a1a25] rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="text-green-400">✓</span>
                                    <span class="text-gray-400">Completed</span>
                                </div>
                                <span class="text-sm text-gray-500">{{ $completion->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
