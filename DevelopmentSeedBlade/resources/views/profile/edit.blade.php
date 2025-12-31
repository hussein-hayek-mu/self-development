<x-app-layout>
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">Profile Settings</h1>
        <p class="text-gray-400 mt-2">Manage your character information and account settings</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Character Card -->
        <div class="lg:col-span-1">
            <div class="game-card text-center">
                <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-4xl text-white font-bold mb-4">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <h2 class="text-xl font-bold">{{ auth()->user()->name }}</h2>
                <p class="text-purple-400">{{ auth()->user()->rank_title ?? 'Novice' }}</p>
                
                <div class="mt-6 space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Level</span>
                        <span class="text-purple-400 font-bold">{{ auth()->user()->level ?? 1 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Total XP</span>
                        <span>{{ number_format(auth()->user()->total_xp ?? 0) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Current Streak</span>
                        <span class="streak-badge text-xs">🔥 {{ auth()->user()->current_streak ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Longest Streak</span>
                        <span>{{ auth()->user()->longest_streak ?? 0 }} days</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Member Since</span>
                        <span>{{ auth()->user()->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Forms -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Update Profile Information -->
            <div class="game-card">
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Update Password -->
            <div class="game-card">
                @include('profile.partials.update-password-form')
            </div>

            <!-- Delete Account -->
            <div class="game-card border-red-500/30">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
