<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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
            <div class="stat-value"><?php echo e($habits->count()); ?></div>
            <div class="stat-label">Total Habits</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?php echo e($habits->where('completed_today', true)->count()); ?></div>
            <div class="stat-label">Completed Today</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?php echo e($habits->max('current_streak') ?? 0); ?></div>
            <div class="stat-label">Best Streak</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?php echo e($habits->sum('xp_reward')); ?></div>
            <div class="stat-label">Potential XP Today</div>
        </div>
    </div>

    <!-- Perfect Day Banner -->
    <?php if($habits->count() > 0 && $habits->where('completed_today', true)->count() === $habits->count()): ?>
        <div class="game-card mb-8 text-center py-6 bg-gradient-to-r from-yellow-500/20 to-orange-500/20 border-yellow-500/30">
            <div class="text-4xl mb-2">🎉</div>
            <h2 class="text-2xl font-bold text-yellow-400">PERFECT DAY!</h2>
            <p class="text-gray-400">You completed all your habits! +500 Bonus XP</p>
        </div>
    <?php endif; ?>

    <!-- Habits List -->
    <?php if($habits->isEmpty()): ?>
        <div class="game-card text-center py-12">
            <div class="text-6xl mb-4">🎯</div>
            <h2 class="text-2xl font-bold mb-2">No Habits Yet</h2>
            <p class="text-gray-400 mb-6">Start building your daily routine by adding your first habit!</p>
            <button onclick="openHabitModal()" class="btn-primary">Create Your First Habit</button>
        </div>
    <?php else: ?>
        <div class="space-y-4">
            <?php $__currentLoopData = $habits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $habit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="habit-card <?php echo e($habit->completed_today ? 'completed' : ''); ?>">
                    <div class="flex items-center gap-4">
                        <!-- Toggle Completion -->
                        <form action="<?php echo e(route('habits.toggle', $habit)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="w-10 h-10 rounded-full border-2 flex items-center justify-center transition-all text-lg <?php echo e($habit->completed_today ? 'bg-green-500 border-green-500 text-white' : 'border-purple-500/50 hover:border-purple-500 hover:bg-purple-500/10'); ?>">
                                <?php if($habit->completed_today): ?>
                                    ✓
                                <?php else: ?>
                                    <?php echo e($habit->icon ?? '🎯'); ?>

                                <?php endif; ?>
                            </button>
                        </form>
                        
                        <!-- Habit Info -->
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg <?php echo e($habit->completed_today ? 'line-through text-gray-500' : ''); ?>">
                                <?php echo e($habit->title); ?>

                            </h3>
                            <?php if($habit->description): ?>
                                <p class="text-sm text-gray-500"><?php echo e($habit->description); ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- XP & Streak -->
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <div class="text-purple-400 font-semibold">+<?php echo e($habit->xp_reward); ?> XP</div>
                                <div class="text-sm text-gray-500"><?php echo e($habit->frequency ?? 'Daily'); ?></div>
                            </div>
                            <div class="streak-badge">
                                🔥 <?php echo e($habit->current_streak); ?>

                            </div>
                            
                            <!-- Actions -->
                            <div class="flex gap-2">
                                <button onclick="editHabit(<?php echo e(json_encode($habit)); ?>)" class="p-2 text-gray-400 hover:text-white hover:bg-purple-500/20 rounded-lg transition-colors">
                                    ✏️
                                </button>
                                <form action="<?php echo e(route('habits.destroy', $habit)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this habit?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/20 rounded-lg transition-colors">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <!-- Habit Modal -->
    <div id="habitModal" class="modal-overlay">
        <div class="modal-content">
            <h2 id="habitModalTitle" class="text-2xl font-bold mb-6" style="font-family: 'Orbitron', sans-serif;">Add New Habit</h2>
            
            <form id="habitForm" method="POST" action="<?php echo e(route('habits.store')); ?>">
                <?php echo csrf_field(); ?>
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

    <?php $__env->startPush('scripts'); ?>
    <script>
        function openHabitModal() {
            document.getElementById('habitModal').classList.add('active');
            document.getElementById('habitModalTitle').textContent = 'Add New Habit';
            document.getElementById('habitForm').action = '<?php echo e(route("habits.store")); ?>';
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
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /Users/root1/Desktop/U/Github/Self_Dev/self-development/DevelopmentSeed/resources/views/habits/index.blade.php ENDPATH**/ ?>