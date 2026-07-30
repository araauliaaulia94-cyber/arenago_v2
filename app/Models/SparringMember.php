<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SparringMember extends Model
{
    protected $fillable = [
        'sparring_post_id',
        'user_id',
        'status',
        'joined_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
    ];

    public function sparringPost()
    {
        return $this->belongsTo(SparringPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
