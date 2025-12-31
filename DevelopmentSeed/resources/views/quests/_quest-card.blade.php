@php
    $isBoss = $isBoss ?? false;
    $isCompleted = $quest->status === 'completed';
@endphp

<div class="quest-card {{ $isCompleted ? 'completed' : '' }} {{ $isBoss ? 'border-red-500/30' : '' }}">
    <!-- Header -->
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-2">
            <span class="quest-badge {{ $quest->type }}">
                {{ $quest->type === 'boss' ? '👹' : '' }} {{ ucfirst($quest->type) }}
            </span>
            <span class="difficulty-badge {{ $quest->difficulty }}">{{ ucfirst($quest->difficulty) }}</span>
        </div>
        <div class="flex items-center gap-1">
            <button onclick="editQuest({{ json_encode($quest) }})" class="p-1.5 text-gray-400 hover:text-white hover:bg-purple-500/20 rounded transition-colors">
                ✏️
            </button>
            <form action="{{ route('quests.destroy', $quest) }}" method="POST" class="inline" onsubmit="return confirm('Delete this quest?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-400 hover:bg-red-500/20 rounded transition-colors">
                    🗑️
                </button>
            </form>
        </div>
    </div>

    <!-- Content -->
    <div class="flex items-start gap-3 mb-3">
        <span class="text-2xl">{{ $quest->icon ?? '⚔️' }}</span>
        <div class="flex-1">
            <h3 class="font-semibold {{ $isCompleted ? 'line-through text-gray-500' : '' }}">{{ $quest->title }}</h3>
            @if($quest->description)
                <p class="text-sm text-gray-500 mt-1">{{ $quest->description }}</p>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="flex items-center justify-between pt-3 border-t border-purple-500/10">
        <div class="flex items-center gap-4 text-sm">
            <span class="text-purple-400 font-semibold">+{{ $quest->xp_reward }} XP</span>
            @if($quest->due_date)
                <span class="text-gray-500">
                    📅 {{ $quest->due_date->format('M d, Y') }}
                </span>
            @endif
        </div>

        @if(!$isCompleted)
            <form action="{{ route('quests.complete', $quest) }}" method="POST">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-success btn-small text-sm">
                    Complete ✓
                </button>
            </form>
        @else
            <span class="text-green-400 text-sm font-semibold">✓ Completed</span>
        @endif
    </div>
</div>
