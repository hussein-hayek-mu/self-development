<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Habit;
use App\Models\Quest;
use App\Models\Badge;
use App\Models\Achievement;
use App\Models\Guild;




class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
        'xp',
        'xp_to_next',
        'total_xp',
        'current_streak',
        'longest_streak',
        'last_activity_date',
        'rank_title',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [ //convert attributes to common data types
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_activity_date' => 'date',
        'level' => 'integer',
        'xp' => 'integer',
        'xp_to_next' => 'integer',
        'total_xp' => 'integer',
        'current_streak' => 'integer',
        'longest_streak' => 'integer',
    ];

    public function habits()
    {
        return $this->hasMany(Habit::class);
    }

    public function quests()
    {
        return $this->hasMany(Quest::class);
    }

    public function habitCompletions()
    {
        return $this->hasMany(HabitCompletion::class);
    }

    public function questCompletions()
    {
        return $this->hasMany(QuestCompletion::class);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class, 'user_badges')
            ->withPivot('earned_at')
            ->withTimestamps();
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'user_achievements')
            ->withPivot('progress', 'is_completed', 'completed_at')
            ->withTimestamps();
    }

    public function guilds()
    {
        return $this->belongsToMany(Guild::class, 'guild_members')
            ->withPivot('role', 'contribution_xp', 'joined_at')
            ->withTimestamps();
    }

    public function ownedGuilds()
    {
        return $this->hasMany(Guild::class, 'owner_id');
    }

     public function addXP(int $amount): void
    {
        $this->xp += $amount;
        $this->total_xp += $amount;

        // Check for level up
        while ($this->xp >= $this->xp_to_next) {
            $this->xp -= $this->xp_to_next;
            $this->level++;
            $this->xp_to_next = $this->calculateNextLevelXP();
        }

        $this->save();
    }

    public function calculateNextLevelXP(): int
    {
        return (int) floor(1000 * pow(1.2, $this->level - 1));
    }

    public function updateStreak(): void
    {
        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        if ($this->last_activity_date === $yesterday) {
            // Continue streak
            $this->current_streak++;
        } elseif ($this->last_activity_date !== $today) {
            // Streak broken
            $this->current_streak = 1;
        }

        if ($this->current_streak > $this->longest_streak) {
            $this->longest_streak = $this->current_streak;
        }

        $this->last_activity_date = $today;
        $this->save();
    }

    public function getTodayHabits()
    {
        return $this->habits()
            ->with(['completions' => function ($query) {
                $query->whereDate('completed_date', now()->toDateString());
            }])
            ->get()
            ->map(function ($habit) {
                $habit->completed_today = $habit->completions->isNotEmpty();
                unset($habit->completions);
                return $habit;
            });
    }

    public function getActiveQuests()
    {
        return $this->quests()
            ->where('status', 'active')
            ->orderBy('due_date')
            ->get();
    }
}
