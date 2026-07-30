<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparringPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'sport_category',
        'location',
        'field_id',
        'event_date',
        'start_time',
        'end_time',
        'team_name',
        'cost',
        'contact',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
        ];
    }

    /**
     * A sparring post belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }

    public function members()
    {
        return $this->hasMany(SparringMember::class);
    }

    public function invites()
    {
        return $this->hasMany(SparringInvite::class);
    }
}