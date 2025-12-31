<x-guest-layout>
    <h2 class="text-xl font-bold mb-6 text-center text-white" style="font-family: 'Orbitron', sans-serif;">Create Your Character</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="form-label">Character Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-input" required autofocus autocomplete="name" placeholder="Enter your hero name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-input" required autocomplete="username" placeholder="your@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label">Password</label>
            <input id="password" type="password" name="password" class="form-input" required autocomplete="new-password" placeholder="Min 8 characters" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" required autocomplete="new-password" placeholder="Repeat your password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="btn-primary w-full">
            ⚔️ Start Your Adventure
        </button>
    </form>

    <p class="text-center text-gray-400 text-sm mt-6">
        Already have an account? 
        <a href="{{ route('login') }}" class="text-purple-400 hover:text-purple-300">Login</a>
    </p>
</x-guest-layout>
