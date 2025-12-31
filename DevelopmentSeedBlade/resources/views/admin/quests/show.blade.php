<x-admin-layout>
    <!-- Breadcrumb -->
    <x-slot name="breadcrumb">
        <a href="{{ route('admin.quests.index') }}" class="hover:text-purple-400">Quests</a>
        <span class="mx-2">→</span>
        <span class="text-white">{{ $quest->title }}</span>
    </x-slot>

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-xl bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center">
                <span class="quest-badge {{ $quest->type }} text-sm">{{ ucfirst($quest->type) }}</span>
            </div>
            <div>
                <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">{{ $quest->title }}</h1>
                <p class="text-gray-400">Owned by <a href="{{ route('admin.users.show', $quest->user) }}" class="text-purple-400 hover:text-purple-300">{{ $quest->user->name }}</a></p>
            </div>
        </div>
        <form action="{{ route('admin.quests.destroy', $quest) }}" method="POST" onsubmit="return confirm('Are you sure?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn-danger btn-small">Delete Quest</button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Quest Info -->
        <div class="lg:col-span-1">
            <div class="game-card">
                <h2 class="text-lg font-bold mb-4">Quest Details</h2>
                
                <div class="space-y-4">
                    <div>
                        <span class="text-gray-400 text-sm">Description</span>
                        <p class="mt-1">{{ $quest->description ?? 'No description' }}</p>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Type</span>
                        <span class="quest-badge {{ $quest->type }}">{{ ucfirst($quest->type) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Status</span>
                        @if($quest->status === 'completed')
                            <span class="px-2 py-1 rounded text-xs font-semibold bg-green-500/20 text-green-400">Completed</span>
                        @elseif($quest->status === 'failed')
                            <span class="px-2 py-1 rounded text-xs font-semibold bg-red-500/20 text-red-400">Failed</span>
                        @else
                            <span class="px-2 py-1 rounded text-xs font-semibold bg-blue-500/20 text-blue-400">Active</span>
                        @endif
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">XP Reward</span>
                        <span class="text-purple-400 font-bold">+{{ $quest->xp_reward }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Progress</span>
                        <span>{{ $quest->progress }} / {{ $quest->target }}</span>
                    </div>
                    <div>
                        <div class="w-full h-3 bg-gray-700 rounded-full overflow-hidden">
                            @php
                                $progress = $quest->target > 0 ? round(($quest->progress / $quest->target) * 100) : 0;
                            @endphp
                            <div class="h-full bg-gradient-to-r from-purple-600 to-pink-500" style="width: {{ $progress }}%"></div>
                        </div>
                        <p class="text-xs text-gray-500 mt-1">{{ $progress }}% complete</p>
                    </div>
                    @if($quest->due_date)
                        <div class="flex justify-between">
                            <span class="text-gray-400">Due Date</span>
                            <span class="{{ $quest->due_date->isPast() ? 'text-red-400' : '' }}">
                                {{ $quest->due_date->format('M d, Y') }}
                            </span>
                        </div>
                    @endif
                    @if($quest->completed_at)
                        <div class="flex justify-between">
                            <span class="text-gray-400">Completed At</span>
                            <span class="text-green-400">{{ $quest->completed_at->format('M d, Y H:i') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-400">Created</span>
                        <span>{{ $quest->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="game-card">
                <h2 class="text-lg font-bold mb-4">Edit Quest</h2>
                
                <form action="{{ route('admin.quests.update', $quest) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" value="{{ $quest->title }}" class="form-input" required>
                        </div>
                        <div class="md:col-span-2">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-input" rows="3">{{ $quest->description }}</textarea>
                        </div>
                        <div>
                            <label class="form-label">Type</label>
                            <select name="type" class="form-select">
                                <option value="daily" {{ $quest->type === 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="weekly" {{ $quest->type === 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="boss" {{ $quest->type === 'boss' ? 'selected' : '' }}>Boss</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" {{ $quest->status === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ $quest->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ $quest->status === 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">XP Reward</label>
                            <input type="number" name="xp_reward" value="{{ $quest->xp_reward }}" min="1" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Target</label>
                            <input type="number" name="target" value="{{ $quest->target }}" min="1" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Current Progress</label>
                            <input type="number" name="progress" value="{{ $quest->progress }}" min="0" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Due Date</label>
                            <input type="date" name="due_date" value="{{ $quest->due_date?->format('Y-m-d') }}" class="form-input">
                        </div>
                    </div>

                    <div class="flex justify-end mt-6 gap-3">
                        @if($quest->status !== 'completed')
                            <button type="button" onclick="document.getElementById('complete-form').submit()" class="btn-success">Mark Complete</button>
                        @endif
                        <button type="submit" class="btn-primary">Save Changes</button>
                    </div>
                </form>

                <form id="complete-form" action="{{ route('admin.quests.update', $quest) }}" method="POST" class="hidden">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="completed">
                    <input type="hidden" name="progress" value="{{ $quest->target }}">
                    <input type="hidden" name="title" value="{{ $quest->title }}">
                    <input type="hidden" name="xp_reward" value="{{ $quest->xp_reward }}">
                    <input type="hidden" name="target" value="{{ $quest->target }}">
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
