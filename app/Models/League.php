<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    //
    protected $fillable = [
        'language_id',
        'country_id',
        'name',
        'slug',
        'custom_permalink',
        'visit',
        'description',
        'status'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
