<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\AchievementCompletion;


class Achievement extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'xp_reward',
        'requirement_type',
        'requirement_value',
        'is_hidden',
    ];

    protected $casts = [
        'xp_reward' => 'integer',
        'requirement_value' => 'integer',
        'is_hidden' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_achievements')
                    ->withPivot('progress', 'is_completed', 'completed_at')
                    ->withTimestamps();
    }

    public function checkAndAward(User $user): bool
    {
        $pivot = $user->achievements()
            ->where('achievement_id', $this->id)
            ->first();

        if ($pivot && $pivot->pivot->is_completed) {
            return false;
        }

        $meetsRequirement = match($this->requirement_type) {
            'first_habit' => $user->habits()->count() >= 1,
            'first_quest' => $user->quests()->count() >= 1,
            'perfect_day' => $this->checkPerfectDay($user),
            'join_guild' => $user->guilds()->count() >= 1,
            'boss_quest' => $user->questCompletions()->whereHas('quest', function($q) {
                $q->where('type', 'boss');
            })->count() >= 1,
            'level' => $user->level >= $this->requirement_value,
            default => false,
        };

        if ($meetsRequirement) {
            $user->achievements()->syncWithoutDetaching([
                $this->id => [
                    'is_completed' => true,
                    'completed_at' => now(),
                    'progress' => $this->requirement_value ?? 1,
                ]
            ]);

            
            $user->addXP($this->xp_reward);

            return true;
        }

        return false;
    }

    private function checkPerfectDay(User $user): bool
    {
        $today = now()->toDateString();
        $totalHabits = $user->habits()->where('is_active', true)->count();
        $completedToday = $user->habitCompletions()
            ->where('completed_date', $today)
            ->count();

        return $totalHabits > 0 && $completedToday === $totalHabits;
    }
}
