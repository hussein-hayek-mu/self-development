<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\User;

class Quest extends Model
{
       use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'type',
        'difficulty',
        'xp_reward',
        'status',
        'due_date',
        'completed_at',
        'progress',
        'target',
        'icon',
    ];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
        'xp_reward' => 'integer',
        'progress' => 'integer',
        'target' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function completions()
    {
        return $this->hasMany(QuestCompletion::class);
    }

    public function complete(): QuestCompletion
    {
        if ($this->status === 'completed') {
            return $this->completions()->first();
        }

        $completion = $this->completions()->create([
            'user_id' => $this->user_id,
            'xp_earned' => $this->xp_reward,
            'completed_at' => now(),
        ]);

        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'progress' => $this->target,
        ]);

        
        $this->user->addXP($this->xp_reward);

        return $completion;
    }

    public function updateProgress(int $amount): void
    {
        $this->progress = min($this->progress + $amount, $this->target);

        if ($this->progress >= $this->target) {
            $this->complete();
        } else {
            $this->save();
        }
    }

    public function isOverdue(): bool
    {
        return $this->due_date && 
               $this->due_date->isPast() && 
               $this->status !== 'completed';
    }

    public function getProgressPercentage(): int
    {
        if ($this->target === 0) {
            return 0;
        }

        return (int) (($this->progress / $this->target) * 100);
    }
}