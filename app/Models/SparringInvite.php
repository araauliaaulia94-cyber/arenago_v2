<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SparringInvite extends Model
{
    use HasFactory;

    protected $fillable = [
        'sparring_post_id',
        'sender_user_id',
        'team_name',
        'message',
        'status',
    ];

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
        return $this->belongsTo(User::class, 'sender_user_id');
    }
}