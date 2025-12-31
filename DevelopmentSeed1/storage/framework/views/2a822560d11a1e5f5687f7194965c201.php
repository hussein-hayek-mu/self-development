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
                    <div class="text-2xl font-bold text-white"><?php echo e(number_format($stats['totalUsers'])); ?></div>
                    <div class="text-sm text-gray-400">Total Users</div>
                </div>
            </div>
        </div>
        <div class="game-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-green-500/20 flex items-center justify-center text-2xl">✅</div>
                <div>
                    <div class="text-2xl font-bold text-white"><?php echo e(number_format($stats['activeUsers'])); ?></div>
                    <div class="text-sm text-gray-400">Active (7 days)</div>
                </div>
            </div>
        </div>
        <div class="game-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-orange-500/20 flex items-center justify-center text-2xl">🔥</div>
                <div>
                    <div class="text-2xl font-bold text-white"><?php echo e(number_format($stats['totalHabits'])); ?></div>
                    <div class="text-sm text-gray-400">Total Habits</div>
                </div>
            </div>
        </div>
        <div class="game-card">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-lg bg-purple-500/20 flex items-center justify-center text-2xl">⚔️</div>
                <div>
                    <div class="text-2xl font-bold text-white"><?php echo e(number_format($stats['totalQuests'])); ?></div>
                    <div class="text-sm text-gray-400">Total Quests</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Stats -->
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div class="stat-card">
            <div class="stat-value text-green-400"><?php echo e($stats['newUsersToday']); ?></div>
            <div class="stat-label">New Today</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-blue-400"><?php echo e($stats['newUsersThisWeek']); ?></div>
            <div class="stat-label">This Week</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-purple-400"><?php echo e($stats['newUsersThisMonth']); ?></div>
            <div class="stat-label">This Month</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-yellow-400"><?php echo e(number_format($stats['totalXpAwarded'])); ?></div>
            <div class="stat-label">Total XP Awarded</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-pink-400"><?php echo e($stats['averageLevel']); ?></div>
            <div class="stat-label">Avg Level</div>
        </div>
    </div>

    <!-- Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Users -->
        <div class="game-card">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold">Recent Users</h2>
                <a href="<?php echo e(route('admin.users.index')); ?>" class="text-purple-400 hover:text-purple-300 text-sm">View All →</a>
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
                        <?php $__empty_1 = true; $__currentLoopData = $recentUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-purple-500/30 flex items-center justify-center text-sm font-bold">
                                            <?php echo e(substr($user->name, 0, 1)); ?>

                                        </div>
                                        <div>
                                            <div class="font-medium"><?php echo e($user->name); ?></div>
                                            <div class="text-xs text-gray-500"><?php echo e($user->email); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-purple-400 font-semibold">Lv.<?php echo e($user->level ?? 1); ?></span>
                                </td>
                                <td class="text-gray-400 text-sm"><?php echo e($user->created_at->diffForHumans()); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="3" class="text-center text-gray-500 py-4">No users yet</td>
                            </tr>
                        <?php endif; ?>
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
                        <?php $__empty_1 = true; $__currentLoopData = $topUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <?php if($index === 0): ?>
                                        <span class="text-yellow-400">🥇</span>
                                    <?php elseif($index === 1): ?>
                                        <span class="text-gray-400">🥈</span>
                                    <?php elseif($index === 2): ?>
                                        <span class="text-orange-400">🥉</span>
                                    <?php else: ?>
                                        <span class="text-gray-500"><?php echo e($index + 1); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div>
                                        <div class="font-medium"><?php echo e($user->name); ?></div>
                                        <div class="text-xs text-gray-500"><?php echo e($user->rank_title ?? 'Novice'); ?></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-purple-400 font-bold"><?php echo e($user->level ?? 1); ?></span>
                                </td>
                                <td class="text-gray-400"><?php echo e(number_format($user->total_xp ?? 0)); ?></td>
                                <td>
                                    <span class="streak-badge text-xs">🔥 <?php echo e($user->current_streak ?? 0); ?></span>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="text-center text-gray-500 py-4">No users yet</td>
                            </tr>
                        <?php endif; ?>
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
                <div class="text-3xl font-bold text-green-400"><?php echo e($stats['completedQuests']); ?></div>
                <div class="text-sm text-gray-400">Completed</div>
            </div>
            <div class="flex-1">
                <div class="xp-bar-container h-6">
                    <?php
                        $completionRate = $stats['totalQuests'] > 0 ? ($stats['completedQuests'] / $stats['totalQuests']) * 100 : 0;
                    ?>
                    <div class="xp-bar-fill" style="width: <?php echo e($completionRate); ?>%"></div>
                </div>
            </div>
            <div>
                <div class="text-3xl font-bold text-gray-400"><?php echo e($stats['totalQuests']); ?></div>
                <div class="text-sm text-gray-400">Total</div>
            </div>
        </div>
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
<?php /**PATH /Users/root1/Desktop/U/Github/Self_Dev/self-development/DevelopmentSeedBlade/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>