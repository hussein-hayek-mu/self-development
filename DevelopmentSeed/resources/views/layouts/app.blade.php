<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Level Up') }} - Gamify Your Life</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0a0a0f]">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <aside class="sidebar" id="sidebar">
                <div class="logo mb-8">LEVEL UP</div>
                
                <!-- User Info -->
                <div class="flex items-center gap-3 mb-8 p-3 bg-purple-500/10 rounded-lg">
                    <div class="level-badge">{{ Auth::user()->level ?? 1 }}</div>
                    <div>
                        <div class="font-semibold text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-gray-400">{{ Auth::user()->rank_title ?? 'Novice' }}</div>
                    </div>
                </div>

                <!-- XP Progress -->
                <div class="mb-8 px-2">
                    <div class="flex justify-between text-sm text-gray-400 mb-2">
                        <span>XP Progress</span>
                        <span>{{ Auth::user()->xp ?? 0 }} / {{ Auth::user()->xp_to_next_level ?? 1000 }}</span>
                    </div>
                    <div class="xp-bar-container">
                        @php
                            $xpProgress = Auth::user()->xp_to_next_level ? min(100, (Auth::user()->xp / Auth::user()->xp_to_next_level) * 100) : 0;
                        @endphp
                        <div class="xp-bar-fill" style="width: {{ $xpProgress }}%"></div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-2">
                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('habits.index') }}" class="sidebar-link {{ request()->routeIs('habits.*') ? 'active' : '' }}">
                        Habits
                    </a>
                    <a href="{{ route('quests.index') }}" class="sidebar-link {{ request()->routeIs('quests.*') ? 'active' : '' }}">
                        Quests
                    </a>
                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        Profile
                    </a>
                    @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.*') ? 'active' : '' }}">
                        Admin Panel
                    </a>
                    @endif
                </nav>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="mt-auto">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-red-400 hover:text-red-300 hover:bg-red-500/10">
                        Logout
                    </button>
                </form>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 ml-64 p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success animate-fade-in">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error animate-fade-in">
                        {{ session('error') }}
                    </div>
                @endif

                {{ $slot }}
            </main>
        </div>

        <!-- Level Up Modal -->
        <div id="levelUpModal" class="modal-overlay">
            <div class="modal-content text-center">
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

        @stack('scripts')
    </body>
</html>
