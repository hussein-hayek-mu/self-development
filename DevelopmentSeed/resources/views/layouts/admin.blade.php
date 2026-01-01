<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin - {{ config('app.name', 'Level Up') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#0a0a0f]">
        <div class="min-h-screen flex">
            <!-- Admin Sidebar -->
            <aside class="sidebar border-r-purple-600/30">
                <div class="logo mb-2">LEVEL UP</div>
                <div class="text-xs text-purple-400 font-semibold mb-8">ADMIN PANEL</div>
                
                <!-- Admin Info -->
                <div class="flex items-center gap-3 mb-8 p-3 bg-purple-500/10 rounded-lg">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-semibold text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm text-purple-400">Administrator</div>
                    </div>
                </div>

                <!-- Admin Navigation -->
                <nav class="flex-1 space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="sidebar-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        Users
                    </a>
                    <a href="{{ route('admin.habits.index') }}" class="sidebar-link {{ request()->routeIs('admin.habits.*') ? 'active' : '' }}">
                        Habits
                    </a>
                    <a href="{{ route('admin.quests.index') }}" class="sidebar-link {{ request()->routeIs('admin.quests.*') ? 'active' : '' }}">
                        Quests
                    </a>
                    
                    <div class="border-t border-purple-500/20 my-4"></div>
                    
                    <a href="{{ route('dashboard') }}" class="sidebar-link">
                         User Dashboard
                    </a>
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
                <!-- Breadcrumb -->
                @isset($breadcrumb)
                <div class="mb-6 text-sm text-gray-400">
                    {{ $breadcrumb }}
                </div>
                @endisset

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

        @stack('scripts')
    </body>
</html>