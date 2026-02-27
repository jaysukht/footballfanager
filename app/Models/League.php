<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
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
    public function matches()
    {
        return $this->hasMany(Matches::class, 'league_id', 'id');   
    }
    protected static function booted()
    {
        static::saved(function () {
            Cache::flush(); // clears all cache
        });

        static::deleted(function () {
            Cache::flush();
        });
    }
}
