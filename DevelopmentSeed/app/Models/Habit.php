<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\HabitCompletion;

class Habit extends Model
{
use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'icon',
        'difficulty',
        'xp_reward',
        'frequency',
        'current_streak',
        'longest_streak',
        'times_completed',
        'is_active',
        'color',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'xp_reward' => 'integer',
        'current_streak' => 'integer',
        'longest_streak' => 'integer',
        'times_completed' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function completions()
    {
        return $this->hasMany(HabitCompletion::class);
    }

    public function complete(): HabitCompletion
    {
        $today = now()->toDateString();

        $existing = $this->completions()
            ->where('completion_date', $today)
            ->first();

        if ($existing) {
            return $existing;
        }

        // Create completion record
        $completion = $this->completions()->create([
            'user_id' => $this->user_id,
            'completion_date' => $today,
            'xp_earned' => $this->xp_reward,
        ]);

        // Update habit stats
        $this->increment('times_completed');
        $this->increment('current_streak');

        if ($this->current_streak > $this->longest_streak) {
            $this->longest_streak = $this->current_streak;
            $this->save();
        }

        // Add XP to user
        $this->user->addXP($this->xp_reward);
        $this->user->updateStreak();

        return $completion;
    }

    public function uncomplete(): void
    {
        $today = now()->toDateString();

        $completion = $this->completions()
            ->where('completion_date', $today)
            ->first();

        if ($completion) {
            // Remove XP from user
            $this->user->xp -= $this->xp_reward;
            $this->user->total_xp -= $this->xp_reward;
            $this->user->save();

            // Delete completion and update stats
            $completion->delete();
            $this->decrement('times_completed');
            $this->decrement('current_streak');
        }
    }

    public function isCompletedToday(): bool
    {
        return $this->completions()
            ->where('completion_date', now()->toDateString())
            ->exists();
    }
}
