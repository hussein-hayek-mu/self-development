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
        <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">Profile Settings</h1>
        <p class="text-gray-400 mt-2">Manage your character information and account settings</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Character Card -->
        <div class="lg:col-span-1">
            <div class="game-card text-center">
                <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-4xl text-white font-bold mb-4">
                    <?php echo e(substr(auth()->user()->name, 0, 1)); ?>

                </div>
                <h2 class="text-xl font-bold"><?php echo e(auth()->user()->name); ?></h2>
                <p class="text-purple-400"><?php echo e(auth()->user()->rank_title ?? 'Novice'); ?></p>
                
                <div class="mt-6 space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Level</span>
                        <span class="text-purple-400 font-bold"><?php echo e(auth()->user()->level ?? 1); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Total XP</span>
                        <span><?php echo e(number_format(auth()->user()->total_xp ?? 0)); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Current Streak</span>
                        <span class="streak-badge text-xs">🔥 <?php echo e(auth()->user()->current_streak ?? 0); ?></span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Longest Streak</span>
                        <span><?php echo e(auth()->user()->longest_streak ?? 0); ?> days</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Member Since</span>
                        <span><?php echo e(auth()->user()->created_at->format('M Y')); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Update Profile Information -->
            <div class="game-card">
                <?php echo $__env->make('profile.partials.update-profile-information-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <!-- Update Password -->
            <div class="game-card">
                <?php echo $__env->make('profile.partials.update-password-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <!-- Delete Account -->
            <div class="game-card border-red-500/30">
                <?php echo $__env->make('profile.partials.delete-user-form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>
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
<?php /**PATH /Users/root1/Desktop/U/Github/Self_Dev/self-development/DevelopmentSeedBlade/resources/views/profile/edit.blade.php ENDPATH**/ ?>