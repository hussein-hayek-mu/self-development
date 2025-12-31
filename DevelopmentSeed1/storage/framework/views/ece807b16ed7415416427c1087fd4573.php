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
    <!-- Breadcrumb -->
     <?php $__env->slot('breadcrumb', null, []); ?> 
        <a href="<?php echo e(route('admin.users.index')); ?>" class="hover:text-purple-400">Users</a>
        <span class="mx-2">→</span>
        <span class="text-white"><?php echo e($user->name); ?></span>
     <?php $__env->endSlot(); ?>

    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white text-2xl font-bold">
                <?php echo e(substr($user->name, 0, 1)); ?>

            </div>
            <div>
                <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;"><?php echo e($user->name); ?></h1>
                <p class="text-gray-400"><?php echo e($user->email); ?></p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <form action="<?php echo e(route('admin.users.toggle-ban', $user)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <button type="submit" class="<?php echo e($user->is_banned ? 'btn-success' : 'btn-danger'); ?> btn-small">
                    <?php echo e($user->is_banned ? 'Unban User' : 'Ban User'); ?>

                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- User Info Card -->
        <div class="lg:col-span-1">
            <div class="game-card">
                <h2 class="text-lg font-bold mb-4">User Information</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Role</span>
                        <span class="px-2 py-1 rounded text-xs font-semibold <?php echo e($user->role === 'admin' ? 'bg-purple-500/20 text-purple-400' : 'bg-gray-500/20 text-gray-400'); ?>">
                            <?php echo e(ucfirst($user->role ?? 'user')); ?>

                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Status</span>
                        <?php if($user->is_banned): ?>
                            <span class="px-2 py-1 rounded text-xs font-semibold bg-red-500/20 text-red-400">Banned</span>
                        <?php else: ?>
                            <span class="px-2 py-1 rounded text-xs font-semibold bg-green-500/20 text-green-400">Active</span>
                        <?php endif; ?>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Level</span>
                        <span class="text-purple-400 font-bold"><?php echo e($user->level ?? 1); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Title</span>
                        <span><?php echo e($user->rank_title ?? 'Novice'); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Current XP</span>
                        <span><?php echo e(number_format($user->xp ?? 0)); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Total XP</span>
                        <span><?php echo e(number_format($user->total_xp ?? 0)); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Current Streak</span>
                        <span class="streak-badge text-xs">🔥 <?php echo e($user->current_streak ?? 0); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Longest Streak</span>
                        <span><?php echo e($user->longest_streak ?? 0); ?> days</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Joined</span>
                        <span><?php echo e($user->created_at->format('M d, Y')); ?></span>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="game-card mt-6">
                <h2 class="text-lg font-bold mb-4">Activity Stats</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="stat-card">
                        <div class="stat-value text-sm"><?php echo e($userStats['totalHabits']); ?></div>
                        <div class="stat-label text-xs">Habits</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value text-sm"><?php echo e($userStats['completedHabitsToday']); ?></div>
                        <div class="stat-label text-xs">Done Today</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value text-sm"><?php echo e($userStats['totalQuests']); ?></div>
                        <div class="stat-label text-xs">Quests</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value text-sm"><?php echo e($userStats['completedQuests']); ?></div>
                        <div class="stat-label text-xs">Completed</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="lg:col-span-2">
            <div class="game-card">
                <h2 class="text-lg font-bold mb-4">Edit User</h2>
                
                <form action="<?php echo e(route('admin.users.update', $user)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="<?php echo e($user->name); ?>" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="<?php echo e($user->email); ?>" class="form-input" required>
                        </div>
                        <div>
                            <label class="form-label">Role</label>
                            <select name="role" class="form-select">
                                <option value="user" <?php echo e($user->role === 'user' ? 'selected' : ''); ?>>User</option>
                                <option value="admin" <?php echo e($user->role === 'admin' ? 'selected' : ''); ?>>Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Rank Title</label>
                            <input type="text" name="rank_title" value="<?php echo e($user->rank_title); ?>" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Level</label>
                            <input type="number" name="level" value="<?php echo e($user->level ?? 1); ?>" min="1" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">XP</label>
                            <input type="number" name="xp" value="<?php echo e($user->xp ?? 0); ?>" min="0" class="form-input">
                        </div>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>

            <!-- User's Habits -->
            <div class="game-card mt-6">
                <h2 class="text-lg font-bold mb-4">User's Habits (<?php echo e($user->habits->count()); ?>)</h2>
                <?php if($user->habits->isEmpty()): ?>
                    <p class="text-gray-500 text-center py-4">No habits</p>
                <?php else: ?>
                    <div class="space-y-2">
                        <?php $__currentLoopData = $user->habits->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $habit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 bg-[#1a1a25] rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span><?php echo e($habit->icon ?? '🎯'); ?></span>
                                    <span><?php echo e($habit->title); ?></span>
                                </div>
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="text-purple-400">+<?php echo e($habit->xp_reward); ?> XP</span>
                                    <span class="streak-badge text-xs">🔥 <?php echo e($habit->current_streak); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- User's Quests -->
            <div class="game-card mt-6">
                <h2 class="text-lg font-bold mb-4">User's Quests (<?php echo e($user->quests->count()); ?>)</h2>
                <?php if($user->quests->isEmpty()): ?>
                    <p class="text-gray-500 text-center py-4">No quests</p>
                <?php else: ?>
                    <div class="space-y-2">
                        <?php $__currentLoopData = $user->quests->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center justify-between p-3 bg-[#1a1a25] rounded-lg">
                                <div class="flex items-center gap-3">
                                    <span class="quest-badge <?php echo e($quest->type); ?>"><?php echo e(ucfirst($quest->type)); ?></span>
                                    <span><?php echo e($quest->title); ?></span>
                                </div>
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="text-purple-400">+<?php echo e($quest->xp_reward); ?> XP</span>
                                    <?php if($quest->status === 'completed'): ?>
                                        <span class="text-green-400">✓</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
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
<?php /**PATH /Users/root1/Desktop/U/Github/Self_Dev/self-development/DevelopmentSeedBlade/resources/views/admin/users/show.blade.php ENDPATH**/ ?>