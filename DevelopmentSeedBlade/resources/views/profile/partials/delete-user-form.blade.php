<section class="space-y-6">
    <header>
        <h2 class="text-lg font-bold text-red-400" style="font-family: 'Orbitron', sans-serif;">
            ⚠️ Danger Zone
        </h2>
        <p class="mt-1 text-sm text-gray-400">
            Once your account is deleted, all of your progress, XP, habits, and quests will be permanently lost. This action cannot be undone.
        </p>
    </header>

    <button
        type="button"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="btn-danger"
    >Delete Account</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 bg-[#12121a]">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-white mb-4" style="font-family: 'Orbitron', sans-serif;">
                Are you sure you want to delete your account?
            </h2>

            <p class="text-sm text-gray-400 mb-6">
                All your progress (Level {{ auth()->user()->level ?? 1 }}, {{ number_format(auth()->user()->total_xp ?? 0) }} XP) will be permanently lost. Enter your password to confirm.
            </p>

            <div>
                <label for="password" class="form-label">Password</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="form-input"
                    placeholder="Enter your password"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="btn-secondary">
                    Cancel
                </button>
                <button type="submit" class="btn-danger">
                    🗑️ Delete Forever
                </button>
            </div>
        </form>
    </x-modal>
</section>
