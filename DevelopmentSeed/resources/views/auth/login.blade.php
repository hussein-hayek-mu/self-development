<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-xl font-bold mb-6 text-center text-white" style="font-family: 'Orbitron', sans-serif;">Welcome Back!</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" required autofocus autocomplete="username" placeholder="your@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-input" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between mb-6">
            <label for="remember_me" class="flex items-center gap-2">
                <input id="remember_me" type="checkbox" class="rounded border-purple-500/30 bg-[#1a1a25] text-purple-600 focus:ring-purple-500" name="remember">
                <span class="text-sm text-gray-400">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-purple-400 hover:text-purple-300" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="btn-primary w-full">
            🎮 Login
        </button>
    </form>

    <p class="text-center text-gray-400 text-sm mt-6">
        Don't have an account? 
        <a href="{{ route('register') }}" class="text-purple-400 hover:text-purple-300">Start your journey</a>
    </p>
</x-guest-layout>
