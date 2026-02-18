<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerMaster extends Model
{
    //
    protected $table = 'player_master';
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
