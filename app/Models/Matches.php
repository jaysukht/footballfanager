<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matches extends Model
{
    //
    protected $table = 'match_master';
    protected $guarded = [];

    public function league()
    {
        return $this->belongsTo(League::class, 'league_id', 'id');
    }

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id', 'id');
    }
}
