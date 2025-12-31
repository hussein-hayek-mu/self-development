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
            <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">User Management</h1>
            <p class="text-gray-400 mt-2">Manage all registered users</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="game-card mb-6">
        <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Search</label>
                <input type="text" name="search" value="<?php echo e($filters['search'] ?? ''); ?>" class="form-input" placeholder="Search by name or email...">
            </div>
            <div class="w-40">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    <option value="user" <?php echo e(($filters['role'] ?? '') === 'user' ? 'selected' : ''); ?>>User</option>
                    <option value="admin" <?php echo e(($filters['role'] ?? '') === 'admin' ? 'selected' : ''); ?>>Admin</option>
                </select>
            </div>
            <div class="w-40">
                <label class="form-label">Sort By</label>
                <select name="sort" class="form-select">
                    <option value="created_at" <?php echo e(($filters['sort'] ?? '') === 'created_at' ? 'selected' : ''); ?>>Date Joined</option>
                    <option value="name" <?php echo e(($filters['sort'] ?? '') === 'name' ? 'selected' : ''); ?>>Name</option>
                    <option value="level" <?php echo e(($filters['sort'] ?? '') === 'level' ? 'selected' : ''); ?>>Level</option>
                </select>
            </div>
            <button type="submit" class="btn-primary btn-small">Filter</button>
            <a href="<?php echo e(route('admin.users.index')); ?>" class="btn-secondary btn-small">Reset</a>
        </form>
    </div>

    <!-- Users Table -->
    <div class="game-card overflow-x-auto">
        <table class="game-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Level</th>
                    <th>XP</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white font-bold">
                                    <?php echo e(substr($user->name, 0, 1)); ?>

                                </div>
                                <div>
                                    <div class="font-medium"><?php echo e($user->name); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($user->email); ?></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="px-2 py-1 rounded text-xs font-semibold <?php echo e($user->role === 'admin' ? 'bg-purple-500/20 text-purple-400' : 'bg-gray-500/20 text-gray-400'); ?>">
                                <?php echo e(ucfirst($user->role ?? 'user')); ?>

                            </span>
                        </td>
                        <td>
                            <span class="text-purple-400 font-bold">Lv.<?php echo e($user->level ?? 1); ?></span>
                        </td>
                        <td class="text-gray-400"><?php echo e(number_format($user->total_xp ?? 0)); ?></td>
                        <td>
                            <?php if($user->is_banned): ?>
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-red-500/20 text-red-400">Banned</span>
                            <?php else: ?>
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-green-500/20 text-green-400">Active</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-gray-400 text-sm"><?php echo e($user->created_at->format('M d, Y')); ?></td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="<?php echo e(route('admin.users.show', $user)); ?>" class="p-2 text-gray-400 hover:text-white hover:bg-purple-500/20 rounded-lg transition-colors" title="View">
                                    👁️
                                </a>
                                <form action="<?php echo e(route('admin.users.toggle-ban', $user)); ?>" method="POST" class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <button type="submit" class="p-2 text-gray-400 hover:text-<?php echo e($user->is_banned ? 'green' : 'red'); ?>-400 hover:bg-<?php echo e($user->is_banned ? 'green' : 'red'); ?>-500/20 rounded-lg transition-colors" title="<?php echo e($user->is_banned ? 'Unban' : 'Ban'); ?>">
                                        <?php echo e($user->is_banned ? '✅' : '🚫'); ?>

                                    </button>
                                </form>
                                <?php if($user->id !== auth()->id()): ?>
                                    <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/20 rounded-lg transition-colors" title="Delete">
                                            🗑️
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-8">No users found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        <?php echo e($users->links()); ?>

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
<?php /**PATH /Users/root1/Desktop/U/Github/Self_Dev/self-development/DevelopmentSeedBlade/resources/views/admin/users/index.blade.php ENDPATH**/ ?>