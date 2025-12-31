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
<body class="font-sans antialiased">
    <div class="min-h-screen bg-[#0a0a0f] flex items-center justify-center p-4">
        <!-- Background Effects -->
        <div class="fixed inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-1/4 -left-1/4 w-1/2 h-1/2 bg-purple-600/20 rounded-full blur-[150px]"></div>
            <div class="absolute bottom-1/4 -right-1/4 w-1/2 h-1/2 bg-pink-600/20 rounded-full blur-[150px]"></div>
        </div>

        <!-- Auth Card -->
        <div class="w-full max-w-md relative z-10">
            <!-- Logo -->
            <div class="text-center mb-8">
                <a href="/" class="inline-block">
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-purple-400 to-pink-400 bg-clip-text text-transparent" style="font-family: 'Orbitron', sans-serif;">
                        ⚔️ LEVEL UP
                    </h1>
                </a>
                <p class="text-gray-400 mt-2">{{ $subtitle ?? 'Gamify your life' }}</p>
            </div>

            <!-- Card Content -->
            <div class="game-card">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <p class="text-center text-gray-500 text-sm mt-6">
                {{ $footer ?? '' }}
            </p>
        </div>
    </div>
</body>
</html>
