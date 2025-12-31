<x-app-layout>
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">Habits</h1>
            <p class="text-gray-400 mt-2">Build streaks and earn XP with daily habits</p>
        </div>
        <button onclick="openHabitModal()" class="btn-primary">
            + Add Habit
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <div class="stat-value">{{ $habits->count() }}</div>
            <div class="stat-label">Total Habits</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $habits->where('completed_today', true)->count() }}</div>
            <div class="stat-label">Completed Today</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $habits->max('current_streak') ?? 0 }}</div>
            <div class="stat-label">Best Streak</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ $habits->sum('xp_reward') }}</div>
            <div class="stat-label">Potential XP Today</div>
        </div>
    </div>

    <!-- Perfect Day Banner -->
    @if($habits->count() > 0 && $habits->where('completed_today', true)->count() === $habits->count())
        <div class="game-card mb-8 text-center py-6 bg-gradient-to-r from-yellow-500/20 to-orange-500/20 border-yellow-500/30">
            <div class="text-4xl mb-2">🎉</div>
            <h2 class="text-2xl font-bold text-yellow-400">PERFECT DAY!</h2>
            <p class="text-gray-400">You completed all your habits! +500 Bonus XP</p>
        </div>
    @endif

    <!-- Habits List -->
    @if($habits->isEmpty())
        <div class="game-card text-center py-12">
            <div class="text-6xl mb-4">🎯</div>
            <h2 class="text-2xl font-bold mb-2">No Habits Yet</h2>
            <p class="text-gray-400 mb-6">Start building your daily routine by adding your first habit!</p>
            <button onclick="openHabitModal()" class="btn-primary">Create Your First Habit</button>
        </div>
    @else
        <div class="space-y-4">
            @foreach($habits as $habit)
                <div class="habit-card {{ $habit->completed_today ? 'completed' : '' }}">
                    <div class="flex items-center gap-4">
                        <!-- Toggle Completion -->
                        <form action="{{ route('habits.toggle', $habit) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-10 h-10 rounded-full border-2 flex items-center justify-center transition-all text-lg {{ $habit->completed_today ? 'bg-green-500 border-green-500 text-white' : 'border-purple-500/50 hover:border-purple-500 hover:bg-purple-500/10' }}">
                                @if($habit->completed_today)
                                    ✓
                                @else
                                    {{ $habit->icon ?? '🎯' }}
                                @endif
                            </button>
                        </form>
                        
                        <!-- Habit Info -->
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg {{ $habit->completed_today ? 'line-through text-gray-500' : '' }}">
                                {{ $habit->title }}
                            </h3>
                            @if($habit->description)
                                <p class="text-sm text-gray-500">{{ $habit->description }}</p>
                            @endif
                        </div>

                        <!-- XP & Streak -->
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <div class="text-purple-400 font-semibold">+{{ $habit->xp_reward }} XP</div>
                                <div class="text-sm text-gray-500">{{ $habit->frequency ?? 'Daily' }}</div>
                            </div>
                            <div class="streak-badge">
                                🔥 {{ $habit->current_streak }}
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex gap-2">
                                <button onclick="editHabit({{ json_encode($habit) }})" class="p-2 text-gray-400 hover:text-white hover:bg-purple-500/20 rounded-lg transition-colors">
                                    ✏️
                                </button>
                                <form action="{{ route('habits.destroy', $habit) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this habit?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/20 rounded-lg transition-colors">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Habit Modal -->
    <div id="habitModal" class="modal-overlay">
        <div class="modal-content">
            <h2 id="habitModalTitle" class="text-2xl font-bold mb-6" style="font-family: 'Orbitron', sans-serif;">Add New Habit</h2>
            
            <form id="habitForm" method="POST" action="{{ route('habits.store') }}">
                @csrf
                <input type="hidden" id="habitMethod" name="_method" value="POST">
                
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Habit Title</label>
                        <input type="text" name="title" id="habitTitle" class="form-input" placeholder="e.g. Morning Jog" required>
                    </div>
                    
                    <div>
                        <label class="form-label">Description (Optional)</label>
                        <input type="text" name="description" id="habitDescription" class="form-input" placeholder="e.g. Run for 30 minutes">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">XP Reward</label>
                            <input type="number" name="xp_reward" id="habitXp" class="form-input" value="50" min="1" max="1000" required>
                        </div>
                        <div>
                            <label class="form-label">Frequency</label>
                            <select name="frequency" id="habitFrequency" class="form-select">
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Icon</label>
                            <select name="icon" id="habitIcon" class="form-select">
                                <option value="🎯">🎯 Target</option>
                                <option value="💪">💪 Exercise</option>
                                <option value="📚">📚 Study</option>
                                <option value="🧘">🧘 Meditation</option>
                                <option value="💧">💧 Water</option>
                                <option value="🥗">🥗 Healthy Eating</option>
                                <option value="😴">😴 Sleep</option>
                                <option value="✍️">✍️ Writing</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Color</label>
                            <select name="color" id="habitColor" class="form-select">
                                <option value="purple">Purple</option>
                                <option value="blue">Blue</option>
                                <option value="green">Green</option>
                                <option value="orange">Orange</option>
                                <option value="pink">Pink</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeHabitModal()" class="btn-secondary btn-small">Cancel</button>
                    <button type="submit" class="btn-primary btn-small">Save Habit</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        function openHabitModal() {
            document.getElementById('habitModal').classList.add('active');
            document.getElementById('habitModalTitle').textContent = 'Add New Habit';
            document.getElementById('habitForm').action = '{{ route("habits.store") }}';
            document.getElementById('habitMethod').value = 'POST';
            document.getElementById('habitForm').reset();
        }

        function closeHabitModal() {
            document.getElementById('habitModal').classList.remove('active');
        }

        function editHabit(habit) {
            document.getElementById('habitModal').classList.add('active');
            document.getElementById('habitModalTitle').textContent = 'Edit Habit';
            document.getElementById('habitForm').action = '/habits/' + habit.id;
            document.getElementById('habitMethod').value = 'PUT';
            document.getElementById('habitTitle').value = habit.title;
            document.getElementById('habitDescription').value = habit.description || '';
            document.getElementById('habitXp').value = habit.xp_reward;
            document.getElementById('habitFrequency').value = habit.frequency || 'daily';
            document.getElementById('habitIcon').value = habit.icon || '🎯';
            document.getElementById('habitColor').value = habit.color || 'purple';
        }

        // Close modal on outside click
        document.getElementById('habitModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeHabitModal();
            }
        });
    </script>
    @endpush
</x-app-layout>
