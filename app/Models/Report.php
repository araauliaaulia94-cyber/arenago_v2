<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'report_type',
        'reported_id',
        'reason',
        'status',
    ];

    /**
     * A report belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}