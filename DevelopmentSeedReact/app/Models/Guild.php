<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Guild extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'owner_id',
        'member_count',
        'max_members',
        'total_xp',
        'is_public',
    ];

    protected $casts = [
        'member_count' => 'integer',
        'max_members' => 'integer',
        'total_xp' => 'integer',
        'is_public' => 'boolean',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'guild_members')
            ->withPivot('role', 'contribution_xp', 'joined_at')
            ->withTimestamps();
    }

    public function addMember(User $user, string $role = 'member'): void
    {
        if ($this->member_count >= $this->max_members) {
            throw new \Exception('Guild is full');
        }

        $this->members()->attach($user->id, [
            'role' => $role,
            'joined_at' => now(),
            'contribution_xp' => 0,
        ]);

        $this->increment('member_count');
    }

    public function removeMember(User $user): void
    {
        $this->members()->detach($user->id);
        $this->decrement('member_count');
    }

    public function isFull(): bool
    {
        return $this->member_count >= $this->max_members;
    }
    
}
