<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparringInvite extends Model
{
    use HasFactory;

    protected $fillable = [
        'sparring_post_id',
        'sender_id',
        'receiver_id',
        'status',
        'message',
        'responded_at',
    ];

    protected function casts(): array
    {
        return [
            'responded_at' => 'datetime',
        ];
    }

    /**
     * The related sparring post.
     */
    public function sparringPost()
    {
        return $this->belongsTo(SparringPost::class);
    }

    /**
     * User who sent the invitation.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * User who received the invitation.
     */
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}