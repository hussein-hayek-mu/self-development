<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Level Up - Gamify Your Life</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@700;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0a0a0f] text-white">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-[#0a0a0f]/90 backdrop-blur-sm border-b border-purple-500/20">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="logo text-2xl">LEVEL UP</a>
            <div class="flex items-center gap-6">
                <a href="#features" class="text-gray-400 hover:text-white transition-colors">Features</a>
                <a href="#about" class="text-gray-400 hover:text-white transition-colors">About</a>
                <a href="#contact" class="text-gray-400 hover:text-white transition-colors">Contact</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary btn-small">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-400 hover:text-white transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="btn-primary btn-small">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="min-h-screen flex items-center justify-center text-center px-6 pt-20">
        <div class="max-w-4xl">
            <h1 class="text-5xl md:text-7xl font-black mb-6 leading-tight" style="font-family: 'Orbitron', sans-serif;">
                Your Life Is a Game.<br>
                <span class="bg-gradient-to-r from-purple-500 to-pink-500 bg-clip-text text-transparent">Start Leveling Up.</span>
            </h1>
            <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto">
                Transform your habits into quests, earn XP, and become the hero of your own story.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn-primary text-lg px-8 py-4">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="btn-primary text-lg px-8 py-4 animate-pulse-glow">Start Your Journey</a>
                    <a href="{{ route('login') }}" class="btn-secondary text-lg px-8 py-4">Login</a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 px-6">
        <div class="max-w-6xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-16" style="font-family: 'Orbitron', sans-serif;">Why Level Up?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                @foreach($features as $feature)
                <div class="game-card text-center hover:scale-105 transform transition-transform">
                    <div class="text-5xl mb-4">{{ $feature['icon'] }}</div>
                    <h3 class="text-xl font-bold mb-3">{{ $feature['title'] }}</h3>
                    <p class="text-gray-400">{{ $feature['description'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 px-6 bg-gradient-to-b from-transparent to-purple-900/10">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-6">
                <div class="stat-card">
                    <div class="stat-value">10K+</div>
                    <div class="stat-label">Active Heroes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">500K+</div>
                    <div class="stat-label">Quests Completed</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">1M+</div>
                    <div class="stat-label">Habits Tracked</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value">99%</div>
                    <div class="stat-label">Heroes Leveled Up</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 px-6">
        <div class="max-w-3xl mx-auto">
            <div class="game-card text-center">
                <h2 class="text-4xl font-bold mb-6" style="font-family: 'Orbitron', sans-serif;">About Us</h2>
                <p class="text-gray-400 text-lg leading-relaxed">
                    Level Up is designed to help you gamify your personal development journey. 
                    We believe that achieving your goals should be fun, engaging, and rewarding. 
                    Transform boring tasks into exciting quests and watch as you level up in real life.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 px-6">
        <div class="max-w-xl mx-auto">
            <div class="game-card">
                <h2 class="text-4xl font-bold text-center mb-8" style="font-family: 'Orbitron', sans-serif;">Contact Us</h2>
                <div class="space-y-6">
                    <div class="flex items-center gap-4 p-4 bg-purple-500/10 rounded-lg">
                        <span class="text-2xl">📧</span>
                        <div>
                            <div class="text-sm text-gray-400">Email</div>
                            <div class="text-white">{{ $contact['email'] }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-purple-500/10 rounded-lg">
                        <span class="text-2xl">💬</span>
                        <div>
                            <div class="text-sm text-gray-400">Discord</div>
                            <div class="text-white">{{ $contact['discord'] }}</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 p-4 bg-purple-500/10 rounded-lg">
                        <span class="text-2xl">🐦</span>
                        <div>
                            <div class="text-sm text-gray-400">Twitter</div>
                            <div class="text-white">{{ $contact['twitter'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 px-6 border-t border-purple-500/20">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="logo text-xl">LEVEL UP</div>
            <div class="text-gray-400 text-sm">
                © {{ date('Y') }} Level Up. All rights reserved.
            </div>
            <div class="flex gap-6">
                <a href="#" class="text-gray-400 hover:text-purple-400 transition-colors">Privacy</a>
                <a href="#" class="text-gray-400 hover:text-purple-400 transition-colors">Terms</a>
            </div>
        </div>
    </footer>
</body>
</html>
