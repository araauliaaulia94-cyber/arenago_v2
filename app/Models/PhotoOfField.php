<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoOfField extends Model
{
    protected $fillable = [
        'field_id',
        'photo_path',
    ];

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}
