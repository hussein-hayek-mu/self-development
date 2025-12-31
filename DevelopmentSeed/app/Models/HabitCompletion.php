<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Habit;
use App\Models\User;


class HabitCompletion extends Model
{
   use HasFactory;

    protected $fillable = [
        'habit_id',
        'user_id',
        'completion_date',
        'xp_earned',
        'notes',
    ];

    protected $casts = [
        'completion_date' => 'date',
        'xp_earned' => 'integer',
    ];

    
    public function habit()
    {
        return $this->belongsTo(Habit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}  

