<x-admin-layout>
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold" style="font-family: 'Orbitron', sans-serif;">User Management</h1>
            <p class="text-gray-400 mt-2">Manage all registered users</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="game-card mb-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="form-label">Search</label>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" class="form-input" placeholder="Search by name or email...">
            </div>
            <div class="w-40">
                <label class="form-label">Role</label>
                <select name="role" class="form-select">
                    <option value="">All Roles</option>
                    <option value="user" {{ ($filters['role'] ?? '') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ ($filters['role'] ?? '') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="w-40">
                <label class="form-label">Sort By</label>
                <select name="sort" class="form-select">
                    <option value="created_at" {{ ($filters['sort'] ?? '') === 'created_at' ? 'selected' : '' }}>Date Joined</option>
                    <option value="name" {{ ($filters['sort'] ?? '') === 'name' ? 'selected' : '' }}>Name</option>
                    <option value="level" {{ ($filters['sort'] ?? '') === 'level' ? 'selected' : '' }}>Level</option>
                </select>
            </div>
            <button type="submit" class="btn-primary btn-small">Filter</button>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary btn-small">Reset</a>
        </form>
    </div>

    <!-- Users Table -->
    <div class="game-card overflow-x-auto">
        <table class="game-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th>Level</th>
                    <th>XP</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-600 to-pink-500 flex items-center justify-center text-white font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium">{{ $user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="px-2 py-1 rounded text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-500/20 text-purple-400' : 'bg-gray-500/20 text-gray-400' }}">
                                {{ ucfirst($user->role ?? 'user') }}
                            </span>
                        </td>
                        <td>
                            <span class="text-purple-400 font-bold">Lv.{{ $user->level ?? 1 }}</span>
                        </td>
                        <td class="text-gray-400">{{ number_format($user->total_xp ?? 0) }}</td>
                        <td>
                            @if($user->is_banned)
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-red-500/20 text-red-400">Banned</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-green-500/20 text-green-400">Active</span>
                            @endif
                        </td>
                        <td class="text-gray-400 text-sm">{{ $user->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="p-2 text-gray-400 hover:text-white hover:bg-purple-500/20 rounded-lg transition-colors" title="View">
                                    👁️
                                </a>
                                <form action="{{ route('admin.users.toggle-ban', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 text-gray-400 hover:text-{{ $user->is_banned ? 'green' : 'red' }}-400 hover:bg-{{ $user->is_banned ? 'green' : 'red' }}-500/20 rounded-lg transition-colors" title="{{ $user->is_banned ? 'Unban' : 'Ban' }}">
                                        {{ $user->is_banned ? '✅' : '🚫' }}
                                    </button>
                                </form>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-gray-400 hover:text-red-400 hover:bg-red-500/20 rounded-lg transition-colors" title="Delete">
                                            🗑️
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-gray-500 py-8">No users found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $users->links() }}
    </div>
</x-admin-layout>
