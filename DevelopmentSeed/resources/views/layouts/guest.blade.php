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
        <div class="min-h-screen flex flex-col items-center justify-center p-6">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="logo text-4xl mb-8">LEVEL UP</a>

            <!-- Auth Card -->
            <div class="game-card w-full max-w-md">
                {{ $slot }}
            </div>

            <!-- Back to Home -->
            <a href="{{ route('home') }}" class="mt-6 text-gray-400 hover:text-purple-400 transition-colors">
                ← Back to Home
            </a>
        </div>
    </body>
</html>
