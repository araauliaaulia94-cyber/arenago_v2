<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity',
        'module',
        'description',
        'reference_id',
    ];

    /**
     * An activity history belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}