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
        'location',
        'description',
        'status',
    ];

    /**
     * Relationship to Owner.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    public function photos()
    {
        return $this->hasMany(PhotoOfField::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}