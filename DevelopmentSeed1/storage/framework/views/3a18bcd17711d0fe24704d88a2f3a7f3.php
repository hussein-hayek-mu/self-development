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
            <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">Quest Management</h1>
            <p class="text-gray-400 mt-2">Manage all quests across the platform</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="game-card mb-6">
        <form method="GET" action="<?php echo e(route('admin.quests.index')); ?>" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Search</label>
                <input type="text" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" class="form-input" placeholder="Search quests...">
            </div>
            <div class="w-40">
                <label class="form-label">Type</label>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="daily" <?php echo e(($filters['type'] ?? '') === 'daily' ? 'selected' : ''); ?>>Daily</option>
                    <option value="weekly" <?php echo e(($filters['type'] ?? '') === 'weekly' ? 'selected' : ''); ?>>Weekly</option>
                    <option value="boss" <?php echo e(($filters['type'] ?? '') === 'boss' ? 'selected' : ''); ?>>Boss</option>
                </select>
            </div>
            <div class="w-40">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" <?php echo e(($filters['status'] ?? '') === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="completed" <?php echo e(($filters['status'] ?? '') === 'completed' ? 'selected' : ''); ?>>Completed</option>
                    <option value="failed" <?php echo e(($filters['status'] ?? '') === 'failed' ? 'selected' : ''); ?>>Failed</option>
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
            <a href="<?php echo e(route('admin.quests.index')); ?>" class="btn-secondary btn-small">Reset</a>
        </form>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6">
        <div class="stat-card">
            <div class="stat-icon">⚔️</div>
            <div>
                <div class="stat-value"><?php echo e(number_format($stats['total'])); ?></div>
                <div class="stat-label">Total Quests</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🎯</div>
            <div>
                <div class="stat-value"><?php echo e(number_format($stats['active'])); ?></div>
                <div class="stat-label">Active</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🏆</div>
            <div>
                <div class="stat-value"><?php echo e(number_format($stats['completed'])); ?></div>
                <div class="stat-label">Completed</div>
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

    <!-- Quests Table -->
    <div class="game-card overflow-x-auto">
        <table class="game-table">
            <thead>
                <tr>
                    <th>Quest</th>
                    <th>User</th>
                    <th>Type</th>
                    <th>XP</th>
                    <th>Progress</th>
                    <th>Status</th>
                    <th>Due</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $quests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="font-medium"><?php echo e($quest->title); ?></div>
                            <div class="text-sm text-gray-500"><?php echo e(Str::limit($quest->description, 40)); ?></div>
                        </td>
                        <td>
                            <a href="<?php echo e(route('admin.users.show', $quest->user)); ?>" class="text-purple-400 hover:text-purple-300">
                                <?php echo e($quest->user->name); ?>

                            </a>
                        </td>
                        <td>
                            <span class="quest-badge <?php echo e($quest->type); ?>"><?php echo e(ucfirst($quest->type)); ?></span>
                        </td>
                        <td class="text-purple-400 font-bold">+<?php echo e($quest->xp_reward); ?></td>
                        <td>
                            <div class="flex items-center gap-2">
                                <div class="w-20 h-2 bg-gray-700 rounded-full overflow-hidden">
                                    <?php
                                        $progress = $quest->target > 0 ? round(($quest->progress / $quest->target) * 100) : 0;
                                    ?>
                                    <div class="h-full bg-gradient-to-r from-purple-600 to-pink-500" style="width: <?php echo e($progress); ?>%"></div>
                                </div>
                                <span class="text-xs text-gray-400"><?php echo e($quest->progress); ?>/<?php echo e($quest->target); ?></span>
                            </div>
                        </td>
                        <td>
                            <?php if($quest->status === 'completed'): ?>
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-green-500/20 text-green-400">Completed</span>
                            <?php elseif($quest->status === 'failed'): ?>
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-red-500/20 text-red-400">Failed</span>
                            <?php else: ?>
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-blue-500/20 text-blue-400">Active</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-gray-400 text-sm">
                            <?php if($quest->due_date): ?>
                                <?php echo e($quest->due_date->format('M d')); ?>

                            <?php else: ?>
                                -
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('admin.quests.show', $quest)); ?>" class="p-2 text-gray-400 hover:text-white hover:bg-purple-500/20 rounded-lg transition-colors" title="View">
                                    👁️
                                </a>
                                <form action="<?php echo e(route('admin.quests.destroy', $quest)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure?')">
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
                        <td colspan="8" class="text-center text-gray-500 py-8">No quests found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        <?php echo e($quests->links()); ?>

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
<?php /**PATH /Users/root1/Desktop/U/Github/Self_Dev/self-development/DevelopmentSeedBlade/resources/views/admin/quests/index.blade.php ENDPATH**/ ?>