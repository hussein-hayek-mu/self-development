<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Badge extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'rarity',
        'required_value',
        'requirement_type',
    ];
    
    protected $casts = [
        'required_value' => 'integer',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_badges')
                    ->withPivot('earned_at')
                    ->withTimestamps();
    }

    public function checkAndAward(User $user): bool
    {
        
        if ($user->badges()->where('badge_id', $this->id)->exists()) {
            return false;
        }

        
        $meetsRequirement = match($this->requirement_type) {
            'habits_completed' => $user->habitCompletions()->count() >= $this->required_value,
            'quests_completed' => $user->questCompletions()->count() >= $this->required_value,
            'streak' => $user->current_streak >= $this->required_value,
            'level' => $user->level >= $this->required_value,
            'total_xp' => $user->total_xp >= $this->required_value,
            default => false,
        };

        if ($meetsRequirement) {
            $user->badges()->attach($this->id, ['earned_at' => now()]);
            return true;
        }

        return false;
    }
}
