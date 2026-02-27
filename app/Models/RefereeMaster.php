<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefereeMaster extends Model
{
    protected $table = 'referee_master';
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
