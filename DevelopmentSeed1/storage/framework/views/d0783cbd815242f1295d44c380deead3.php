<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Level Up')); ?> - Gamify Your Life</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    </head>
    <body class="font-sans antialiased bg-[#0a0a0f]">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <aside class="sidebar" id="sidebar">
                <div class="logo mb-8">LEVEL UP</div>
                
                <!-- User Info -->
                <div class="flex items-center gap-3 mb-8 p-3 bg-purple-500/10 rounded-lg">
                    <div class="level-badge"><?php echo e(Auth::user()->level ?? 1); ?></div>
                    <div>
                        <div class="font-semibold text-white"><?php echo e(Auth::user()->name); ?></div>
                        <div class="text-sm text-gray-400"><?php echo e(Auth::user()->rank_title ?? 'Novice'); ?></div>
                    </div>
                </div>

                <!-- XP Progress -->
                <div class="mb-8 px-2">
                    <div class="flex justify-between text-sm text-gray-400 mb-2">
                        <span>XP Progress</span>
                        <span><?php echo e(Auth::user()->xp ?? 0); ?> / <?php echo e(Auth::user()->xp_to_next_level ?? 1000); ?></span>
                    </div>
                    <div class="xp-bar-container">
                        <?php
                            $xpProgress = Auth::user()->xp_to_next_level ? min(100, (Auth::user()->xp / Auth::user()->xp_to_next_level) * 100) : 0;
                        ?>
                        <div class="xp-bar-fill" style="width: <?php echo e($xpProgress); ?>%"></div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-2">
                    <a href="<?php echo e(route('dashboard')); ?>" class="sidebar-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                        <span>🏠</span> Dashboard
                    </a>
                    <a href="<?php echo e(route('habits.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('habits.*') ? 'active' : ''); ?>">
                        <span>🔥</span> Habits
                    </a>
                    <a href="<?php echo e(route('quests.index')); ?>" class="sidebar-link <?php echo e(request()->routeIs('quests.*') ? 'active' : ''); ?>">
                        <span>⚔️</span> Quests
                    </a>
                    <a href="<?php echo e(route('profile.edit')); ?>" class="sidebar-link <?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>">
                        <span>👤</span> Profile
                    </a>
                    <?php if(Auth::user()->role === 'admin'): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>" class="sidebar-link <?php echo e(request()->routeIs('admin.*') ? 'active' : ''); ?>">
                        <span>⚙️</span> Admin Panel
                    </a>
                    <?php endif; ?>
                </nav>

                <!-- Logout -->
                <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-auto">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="sidebar-link w-full text-red-400 hover:text-red-300 hover:bg-red-500/10">
                        <span>🚪</span> Logout
                    </button>
                </form>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 ml-64 p-8">
                <!-- Flash Messages -->
                <?php if(session('success')): ?>
                    <div class="alert alert-success animate-fade-in">
                        <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
                <?php if(session('error')): ?>
                    <div class="alert alert-error animate-fade-in">
                        <?php echo e(session('error')); ?>

                    </div>
                <?php endif; ?>

                <?php echo e($slot); ?>

            </main>
        </div>

        <!-- Level Up Modal -->
        <div id="levelUpModal" class="modal-overlay">
            <div class="modal-content text-center">
                <div class="text-6xl mb-4">🎉</div>
                <h2 class="text-3xl font-bold text-purple-400 mb-2" style="font-family: 'Orbitron', sans-serif;">LEVEL UP!</h2>
                <p class="text-xl text-gray-300 mb-6">You've reached Level <span id="newLevel">2</span>!</p>
                <button onclick="closeLevelUpModal()" class="btn-primary">Continue</button>
            </div>
        </div>

        <script>
            function closeLevelUpModal() {
                document.getElementById('levelUpModal').classList.remove('active');
            }
        </script>

        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html>
<?php /**PATH /Users/root1/Desktop/U/Github/Self_Dev/self-development/DevelopmentSeed/resources/views/layouts/app.blade.php ENDPATH**/ ?>