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
        'timestamps',
        'Field',
    ]
}
