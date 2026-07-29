<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'badge',
        'points',
        'earned_at',
    ];

    protected function casts(): array
    {
        return [
            'points' => 'integer',
            'earned_at' => 'datetime',
        ];
    }

    /**
     * A user achievement belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}