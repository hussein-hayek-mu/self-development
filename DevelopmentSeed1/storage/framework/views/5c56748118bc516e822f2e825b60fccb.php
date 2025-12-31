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
            <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">Quests</h1>
            <p class="text-gray-400 mt-2">Complete quests to earn XP and level up</p>
        </div>
        <button onclick="openQuestModal()" class="btn-primary">
            + Add Quest
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <div class="stat-value"><?php echo e($dailyQuests->count() + $weeklyQuests->count() + $bossQuests->count()); ?></div>
            <div class="stat-label">Total Quests</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?php echo e($dailyQuests->where('status', 'active')->count() + $weeklyQuests->where('status', 'active')->count() + $bossQuests->where('status', 'active')->count()); ?></div>
            <div class="stat-label">Active</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?php echo e($dailyQuests->where('status', 'completed')->count() + $weeklyQuests->where('status', 'completed')->count() + $bossQuests->where('status', 'completed')->count()); ?></div>
            <div class="stat-label">Completed</div>
        </div>
        <div class="stat-card">
            <div class="stat-value"><?php echo e($dailyQuests->sum('xp_reward') + $weeklyQuests->sum('xp_reward') + $bossQuests->sum('xp_reward')); ?></div>
            <div class="stat-label">Total XP Available</div>
        </div>
    </div>

    <!-- Daily Quests -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            <span class="text-blue-400">📋</span> Daily Quests
            <span class="text-sm font-normal text-gray-500">(<?php echo e($dailyQuests->count()); ?>)</span>
        </h2>
        
        <?php if($dailyQuests->isEmpty()): ?>
            <div class="game-card text-center py-6 border-blue-500/20">
                <p class="text-gray-400">No daily quests. Add some quick tasks!</p>
            </div>
        <?php else: ?>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $dailyQuests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('quests._quest-card', ['quest' => $quest], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Weekly Quests -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            <span class="text-purple-400">📅</span> Weekly Quests
            <span class="text-sm font-normal text-gray-500">(<?php echo e($weeklyQuests->count()); ?>)</span>
        </h2>
        
        <?php if($weeklyQuests->isEmpty()): ?>
            <div class="game-card text-center py-6 border-purple-500/20">
                <p class="text-gray-400">No weekly quests. Set some weekly goals!</p>
            </div>
        <?php else: ?>
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                <?php $__currentLoopData = $weeklyQuests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('quests._quest-card', ['quest' => $quest], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Boss Quests -->
    <div class="mb-8">
        <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
            <span class="text-red-400">👹</span> Boss Quests
            <span class="text-sm font-normal text-gray-500">(<?php echo e($bossQuests->count()); ?>)</span>
        </h2>
        
        <?php if($bossQuests->isEmpty()): ?>
            <div class="game-card text-center py-6 border-red-500/20">
                <p class="text-gray-400">No boss quests. Challenge yourself with a big goal!</p>
            </div>
        <?php else: ?>
            <div class="grid gap-4 md:grid-cols-2">
                <?php $__currentLoopData = $bossQuests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('quests._quest-card', ['quest' => $quest, 'isBoss' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Quest Modal -->
    <div id="questModal" class="modal-overlay">
        <div class="modal-content">
            <h2 id="questModalTitle" class="text-2xl font-bold mb-6" style="font-family: 'Orbitron', sans-serif;">Add New Quest</h2>
            
            <form id="questForm" method="POST" action="<?php echo e(route('quests.store')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" id="questMethod" name="_method" value="POST">
                
                <div class="space-y-4">
                    <div>
                        <label class="form-label">Quest Title</label>
                        <input type="text" name="title" id="questTitle" class="form-input" placeholder="e.g. Finish Report" required>
                    </div>
                    
                    <div>
                        <label class="form-label">Description (Optional)</label>
                        <input type="text" name="description" id="questDescription" class="form-input" placeholder="e.g. Complete the quarterly report">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Quest Type</label>
                            <select name="type" id="questType" class="form-select">
                                <option value="daily">Daily Quest</option>
                                <option value="weekly">Weekly Quest</option>
                                <option value="boss">Boss Quest</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Difficulty</label>
                            <select name="difficulty" id="questDifficulty" class="form-select">
                                <option value="easy">Easy (1x XP)</option>
                                <option value="medium">Medium (1.5x XP)</option>
                                <option value="hard">Hard (2x XP)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Base XP Reward</label>
                            <input type="number" name="xp_reward" id="questXp" class="form-input" value="100" min="1" max="5000" required>
                        </div>
                        <div>
                            <label class="form-label">Due Date (Optional)</label>
                            <input type="date" name="due_date" id="questDueDate" class="form-input">
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Icon</label>
                        <select name="icon" id="questIcon" class="form-select">
                            <option value="⚔️">⚔️ Sword</option>
                            <option value="📝">📝 Task</option>
                            <option value="💼">💼 Work</option>
                            <option value="📚">📚 Study</option>
                            <option value="🏃">🏃 Fitness</option>
                            <option value="🎨">🎨 Creative</option>
                            <option value="🏠">🏠 Home</option>
                            <option value="💰">💰 Finance</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="closeQuestModal()" class="btn-secondary btn-small">Cancel</button>
                    <button type="submit" class="btn-primary btn-small">Save Quest</button>
                </div>
            </form>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function openQuestModal() {
            document.getElementById('questModal').classList.add('active');
            document.getElementById('questModalTitle').textContent = 'Add New Quest';
            document.getElementById('questForm').action = '<?php echo e(route("quests.store")); ?>';
            document.getElementById('questMethod').value = 'POST';
            document.getElementById('questForm').reset();
        }

        function closeQuestModal() {
            document.getElementById('questModal').classList.remove('active');
        }

        function editQuest(quest) {
            document.getElementById('questModal').classList.add('active');
            document.getElementById('questModalTitle').textContent = 'Edit Quest';
            document.getElementById('questForm').action = '/quests/' + quest.id;
            document.getElementById('questMethod').value = 'PUT';
            document.getElementById('questTitle').value = quest.title;
            document.getElementById('questDescription').value = quest.description || '';
            document.getElementById('questType').value = quest.type;
            document.getElementById('questDifficulty').value = quest.difficulty;
            document.getElementById('questXp').value = quest.xp_reward;
            document.getElementById('questDueDate').value = quest.due_date ? quest.due_date.split('T')[0] : '';
            document.getElementById('questIcon').value = quest.icon || '⚔️';
        }

        // Close modal on outside click
        document.getElementById('questModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeQuestModal();
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
<?php /**PATH /Users/root1/Desktop/U/Github/Self_Dev/self-development/DevelopmentSeedBlade/resources/views/quests/index.blade.php ENDPATH**/ ?>