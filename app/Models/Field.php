<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Field extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'owner_id',
        'field_name',
        'sport_category',
        'price_per_hour',
        'status',
    ];

    /**
     * Relationship to Owner.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }
}