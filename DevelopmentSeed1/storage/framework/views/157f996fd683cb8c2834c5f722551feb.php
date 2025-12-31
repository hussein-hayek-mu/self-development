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
    <div class="mb-8">
        <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">Dashboard</h1>
        <p class="text-gray-400 mt-2">Welcome back, <?php echo e($user['name']); ?>! Ready to level up today?</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Level Card -->
        <div class="game-card text-center">
            <div class="level-badge mx-auto mb-3 w-16 h-16 text-2xl"><?php echo e($user['level']); ?></div>
            <div class="font-semibold text-lg"><?php echo e($user['title']); ?></div>
            <div class="text-sm text-gray-400">Current Level</div>
        </div>

        <!-- XP Progress Card -->
        <div class="game-card">
            <h3 class="text-sm text-gray-400 mb-2">XP Progress</h3>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-purple-400 font-semibold"><?php echo e(number_format($user['currentXp'])); ?> XP</span>
                <span class="text-gray-500"><?php echo e(number_format($user['xpForNextLevel'])); ?> XP</span>
            </div>
            <div class="xp-bar-container">
                <div class="xp-bar-fill" style="width: <?php echo e($user['xpProgress']); ?>%"></div>
            </div>
        </div>

        <!-- Streak Card -->
        <div class="game-card text-center">
            <div class="text-4xl mb-2">🔥</div>
            <div class="text-2xl font-bold text-orange-400"><?php echo e($user['currentStreak']); ?></div>
            <div class="text-sm text-gray-400">Day Streak</div>
        </div>

        <!-- Total XP Card -->
        <div class="game-card text-center">
            <div class="text-4xl mb-2">⭐</div>
            <div class="text-2xl font-bold text-purple-400"><?php echo e(number_format($user['totalXp'])); ?></div>
            <div class="text-sm text-gray-400">Total XP Earned</div>
        </div>
    </div>

    <!-- Today's Progress -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Today's Habits -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Today's Habits</h2>
                <a href="<?php echo e(route('habits.index')); ?>" class="text-purple-400 hover:text-purple-300 text-sm">View All →</a>
            </div>
            
            <?php if($habits->isEmpty()): ?>
                <div class="game-card text-center py-8">
                    <div class="text-4xl mb-3">🎯</div>
                    <p class="text-gray-400 mb-4">No habits yet. Start building your routine!</p>
                    <a href="<?php echo e(route('habits.index')); ?>" class="btn-primary btn-small">Add Habit</a>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $habits->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $habit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="habit-card <?php echo e($habit->completed_today ? 'completed' : ''); ?>">
                            <div class="flex items-center gap-3">
                                <form action="<?php echo e(route('habits.toggle', $habit)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="w-8 h-8 rounded-full border-2 flex items-center justify-center transition-all <?php echo e($habit->completed_today ? 'bg-green-500 border-green-500 text-white' : 'border-purple-500/50 hover:border-purple-500'); ?>">
                                        <?php if($habit->completed_today): ?>
                                            ✓
                                        <?php endif; ?>
                                    </button>
                                </form>
                                <div>
                                    <div class="font-medium <?php echo e($habit->completed_today ? 'line-through text-gray-500' : ''); ?>"><?php echo e($habit->title); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($habit->icon ?? '🎯'); ?> +<?php echo e($habit->xp_reward); ?> XP</div>
                                </div>
                            </div>
                            <div class="streak-badge">
                                🔥 <?php echo e($habit->current_streak); ?>

                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Active Quests -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Active Quests</h2>
                <a href="<?php echo e(route('quests.index')); ?>" class="text-purple-400 hover:text-purple-300 text-sm">View All →</a>
            </div>
            
            <?php if($activeQuests->isEmpty()): ?>
                <div class="game-card text-center py-8">
                    <div class="text-4xl mb-3">⚔️</div>
                    <p class="text-gray-400 mb-4">No active quests. Create your first quest!</p>
                    <a href="<?php echo e(route('quests.index')); ?>" class="btn-primary btn-small">Add Quest</a>
                </div>
            <?php else: ?>
                <div class="space-y-3">
                    <?php $__currentLoopData = $activeQuests->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="quest-card">
                            <div class="flex items-center justify-between mb-2">
                                <span class="quest-badge <?php echo e($quest->type); ?>"><?php echo e(ucfirst($quest->type)); ?></span>
                                <span class="difficulty-badge <?php echo e($quest->difficulty); ?>"><?php echo e(ucfirst($quest->difficulty)); ?></span>
                            </div>
                            <h3 class="font-medium mb-1"><?php echo e($quest->title); ?></h3>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-purple-400">+<?php echo e($quest->xp_reward); ?> XP</span>
                                <?php if($quest->due_date): ?>
                                    <span class="text-gray-500">Due: <?php echo e($quest->due_date->format('M d')); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
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
<?php /**PATH /Users/root1/Desktop/U/Github/Self_Dev/self-development/DevelopmentSeedBlade/resources/views/dashboard.blade.php ENDPATH**/ ?>