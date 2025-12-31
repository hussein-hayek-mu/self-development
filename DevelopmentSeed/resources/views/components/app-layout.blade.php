<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Level Up') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=orbitron:400,500,600,700,800,900|inter:300,400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" x-data="{ sidebarOpen: true }">
    <div class="min-h-screen bg-[#0a0a0f] flex">
        <!-- Sidebar -->
        <aside class="sidebar fixed left-0 top-0 h-full z-50 transition-transform duration-300" :class="{ '-translate-x-full': !sidebarOpen }">
            <!-- Logo -->
            <div class="px-6 py-6 border-b border-gray-800">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <span class="text-2xl">⚔️</span>
                    <h1 class="text-xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent" style="font-family: 'Orbitron', sans-serif;">
                        LEVEL UP
                    </h1>
                </a>
            </div>

            <!-- User Level & XP -->
            <div class="px-4 py-4 border-b border-gray-800">
                <div class="flex items-center gap-3 mb-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white font-bold text-lg">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-medium">{{ auth()->user()->name }}</div>
                        <div class="text-sm text-purple-400">{{ auth()->user()->rank_title ?? 'Novice' }}</div>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Level {{ auth()->user()->level ?? 1 }}</span>
                        <span class="text-purple-400">{{ auth()->user()->xp ?? 0 }} / {{ (auth()->user()->level ?? 1) * 100 }} XP</span>
                    </div>
                    <div class="xp-bar">
                        @php
                            $level = auth()->user()->level ?? 1;
                            $xp = auth()->user()->xp ?? 0;
                            $xpForLevel = $level * 100;
                            $progress = $xpForLevel > 0 ? min(100, ($xp / $xpForLevel) * 100) : 0;
                        @endphp
                        <div class="xp-progress" style="width: {{ $progress }}%"></div>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span>🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('habits.index') }}" class="sidebar-link {{ request()->routeIs('habits.*') ? 'active' : '' }}">
                    <span>🎯</span>
                    <span>Habits</span>
                </a>
                <a href="{{ route('quests.index') }}" class="sidebar-link {{ request()->routeIs('quests.*') ? 'active' : '' }}">
                    <span>⚔️</span>
                    <span>Quests</span>
                </a>
                <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <span>👤</span>
                    <span>Profile</span>
                </a>

                @if(auth()->user()->role === 'admin')
                    <div class="border-t border-gray-800 my-4 pt-4">
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-link">
                            <span>⚙️</span>
                            <span>Admin Panel</span>
                        </a>
                    </div>
                @endif
            </nav>

            <!-- Streak Badge -->
            <div class="absolute bottom-20 left-0 right-0 px-4">
                <div class="game-card !p-4 text-center">
                    <div class="text-2xl mb-1">🔥</div>
                    <div class="text-2xl font-bold text-orange-400">{{ auth()->user()->current_streak ?? 0 }}</div>
                    <div class="text-xs text-gray-400">Day Streak</div>
                </div>
            </div>

            <!-- Logout -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="sidebar-link w-full text-left text-red-400 hover:bg-red-500/10">
                        <span>🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 min-h-screen">
            <!-- Top Bar -->
            <header class="sticky top-0 z-40 bg-[#0a0a0f]/95 backdrop-blur-sm border-b border-gray-800 px-8 py-4">
                <div class="flex items-center justify-between">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 text-gray-400 hover:text-white lg:hidden">
                        ☰
                    </button>
                    
                    <div class="flex items-center gap-4">
                        <!-- Quick Stats -->
                        <div class="flex items-center gap-6 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="text-purple-400">⚡</span>
                                <span class="text-gray-400">{{ number_format(auth()->user()->total_xp ?? 0) }} Total XP</span>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-green-500/20 border border-green-500/50 text-green-400 animate-fade-in">
                        {{ session('success') }}
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 p-4 rounded-lg bg-red-500/20 border border-red-500/50 text-red-400">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 p-4 rounded-lg bg-red-500/20 border border-red-500/50 text-red-400">
                        <ul class="list-disc list-inside">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ $slot }}
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>
