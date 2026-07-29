<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparringPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sport',
        'title',
        'location',
        'match_date',
        'match_time',
        'players_needed',
        'description',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'match_date' => 'date',
            'match_time' => 'datetime:H:i',
        ];
    }

    /**
     * A sparring post belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}