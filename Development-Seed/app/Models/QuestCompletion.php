<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Quest;
use App\Models\User;

class QuestCompletion extends Model
{
    use HasFactory;

    protected $fillable = [
        'quest_id',
        'user_id',
        'xp_earned',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'xp_earned' => 'integer',
    ];

    public function quest()
    {
        return $this->belongsTo(Quest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
