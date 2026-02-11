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

    public function injured_players()
    {
        return $this->hasMany(MatchInjuredPlayer::class, 'match_id', 'id');
    }

    public function match_team_lineups()
    {
        return $this->hasMany(MatchTeamLineUp::class, 'match_id', 'id');
    }

    public function headtoheads()
    {
        return $this->hasMany(MatchHeadToHead::class, 'match_id', 'id');
    }

    public function tv_channels()
    {
        return $this->hasMany(MatchTvChannel::class, 'match_id', 'id');
    }
}
