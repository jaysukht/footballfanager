<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    //
    protected $table = 'teams';
    protected $guarded = [];

    public function players()
    {
        return $this->hasMany(TeamPlayer::class, 'team_id', 'id')
                    ->where('language_id', $this->language_id);
    }

    public function league()
    {
        return $this->belongsTo(League::class, 'league_id', 'id');
    }

    public function season()
    {
        return $this->belongsTo(Season::class, 'season_id', 'id');
    }

}
