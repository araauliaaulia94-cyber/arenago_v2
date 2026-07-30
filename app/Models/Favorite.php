<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'field_id',
    ];

    /**
     * A favorite belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A favorite belongs to a field.
     */
    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}