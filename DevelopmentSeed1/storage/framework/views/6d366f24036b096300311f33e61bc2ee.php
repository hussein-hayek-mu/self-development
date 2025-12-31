<?php if (isset($component)) { $__componentOriginale0f1cdd055772eb1d4a99981c240763e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0f1cdd055772eb1d4a99981c240763e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">Habit Management</h1>
            <p class="text-gray-400 mt-2">Manage all habits across the platform</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="game-card mb-6">
        <form method="GET" action="<?php echo e(route('admin.habits.index')); ?>" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Search</label>
                <input type="text" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" class="form-input" placeholder="Search habits...">
            </div>
            <div class="w-40">
                <label class="form-label">Difficulty</label>
                <select name="difficulty" class="form-select">
                    <option value="">All</option>
                    <option value="easy" <?php echo e(($filters['difficulty'] ?? '') === 'easy' ? 'selected' : ''); ?>>Easy</option>
                    <option value="medium" <?php echo e(($filters['difficulty'] ?? '') === 'medium' ? 'selected' : ''); ?>>Medium</option>
                    <option value="hard" <?php echo e(($filters['difficulty'] ?? '') === 'hard' ? 'selected' : ''); ?>>Hard</option>
                </select>
            </div>
            <div class="w-40">
                <label class="form-label">Sort By</label>
                <select name="sort" class="form-select">
                    <option value="created_at" <?php echo e(($filters['sort'] ?? '') === 'created_at' ? 'selected' : ''); ?>>Date Created</option>
                    <option value="title" <?php echo e(($filters['sort'] ?? '') === 'title' ? 'selected' : ''); ?>>Title</option>
                    <option value="xp_reward" <?php echo e(($filters['sort'] ?? '') === 'xp_reward' ? 'selected' : ''); ?>>XP Reward</option>
                </select>
            </div>
            <button type="submit" class="btn-primary btn-small">Filter</button>
            <a href="<?php echo e(route('admin.habits.index')); ?>" class="btn-secondary btn-small">Reset</a>
        </form>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div>
                <div class="stat-value"><?php echo e(number_format($stats['total'])); ?></div>
                <div class="stat-label">Total Habits</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div>
                <div class="stat-value"><?php echo e(number_format($stats['completedToday'])); ?></div>
                <div class="stat-label">Completed Today</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🔥</div>
            <div>
                <div class="stat-value"><?php echo e($stats['avgStreak']); ?></div>
                <div class="stat-label">Avg Streak</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">⚡</div>
            <div>
                <div class="stat-value"><?php echo e(number_format($stats['totalXpRewarded'])); ?></div>
                <div class="stat-label">XP Rewarded</div>
            </div>
        </div>
    </div>

    <!-- Habits Table -->
    <div class="game-card overflow-x-auto">
        <table class="game-table">
            <thead>
                <tr>
                    <th>Habit</th>
                    <th>User</th>
                    <th>Difficulty</th>
                    <th>XP</th>
                    <th>Streak</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $habits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $habit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <span class="text-2xl"><?php echo e($habit->icon ?? '🎯'); ?></span>
                                <div>
                                    <div class="font-medium"><?php echo e($habit->title); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e(Str::limit($habit->description, 40)); ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.users.show', $habit->user)); ?>" class="text-purple-400 hover:text-purple-300">
                                <?php echo e($habit->user->name); ?>

                            </a>
                        </td>
                        <td>
                            <span class="difficulty-badge <?php echo e($habit->difficulty ?? 'medium'); ?>">
                                <?php echo e(ucfirst($habit->difficulty ?? 'medium')); ?>

                            </span>
                        </td>
                        <td class="text-purple-400 font-bold">+<?php echo e($habit->xp_reward); ?></td>
                        <td>
                            <span class="streak-badge text-xs">🔥 <?php echo e($habit->current_streak); ?></span>
                        </td>
                        <td class="text-gray-400 text-sm"><?php echo e($habit->created_at->format('M d, Y')); ?></td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('admin.habits.show', $habit)); ?>" class="p-2 text-gray-400 hover:text-white hover:bg-purple-500/20 rounded-lg transition-colors" title="View">
                                    👁️
                                </a>
                                <form action="<?php echo e(route('admin.habits.destroy', $habit)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/20 rounded-lg transition-colors" title="Delete">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-8">No habits found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        <?php echo e($habits->links()); ?>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $attributes = $__attributesOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__attributesOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale0f1cdd055772eb1d4a99981c240763e)): ?>
<?php $component = $__componentOriginale0f1cdd055772eb1d4a99981c240763e; ?>
<?php unset($__componentOriginale0f1cdd055772eb1d4a99981c240763e); ?>
<?php endif; ?>
<?php /**PATH /Users/root1/Desktop/U/Github/Self_Dev/self-development/DevelopmentSeedBlade/resources/views/admin/habits/index.blade.php ENDPATH**/ ?>