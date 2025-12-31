<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - {{ config('app.name', 'Level Up') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=orbitron:400,500,600,700,800,900|inter:300,400,500,600,700" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-[#0a0a0f]">
        <!-- Admin Sidebar -->
        <aside class="sidebar fixed left-0 top-0 h-full z-50">
            <!-- Logo -->
            <a href="{{ route('admin.dashboard') }}" class="block px-6 py-6 border-b border-gray-800">
                <h1 class="text-xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent" style="font-family: 'Orbitron', sans-serif;">
                    ⚙️ ADMIN
                </h1>
            </a>

            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <span>📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <span>👥</span>
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.habits.index') }}" class="sidebar-link {{ request()->routeIs('admin.habits.*') ? 'active' : '' }}">
                    <span>🎯</span>
                    <span>Habits</span>
                </a>
                <a href="{{ route('admin.quests.index') }}" class="sidebar-link {{ request()->routeIs('admin.quests.*') ? 'active' : '' }}">
                    <span>⚔️</span>
                    <span>Quests</span>
                </a>

                <div class="border-t border-gray-800 my-4 pt-4">
                    <a href="{{ route('dashboard') }}" class="sidebar-link">
                        <span>🏠</span>
                        <span>Back to App</span>
                    </a>
                </div>
            </nav>

            <!-- Admin User -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-800">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-medium text-sm truncate">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-purple-400">Administrator</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="ml-64 min-h-screen">
            <!-- Top Bar -->
            <header class="sticky top-0 z-40 bg-[#0a0a0f]/95 backdrop-blur-sm border-b border-gray-800 px-8 py-4">
                <div class="flex items-center justify-between">
                    <!-- Breadcrumb -->
                    <div class="text-gray-400 text-sm">
                        {{ $breadcrumb ?? '' }}
                    </div>

                    <!-- Right Side -->
                    <div class="flex items-center gap-4">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-white text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-8">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 rounded-lg bg-green-500/20 border border-green-500/50 text-green-400">
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
</body>
</html>
