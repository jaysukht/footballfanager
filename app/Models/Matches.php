<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
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
    public function match_injured_players()
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
    public function match_head_to_heads()
    {
        return $this->hasMany(MatchHeadToHead::class, 'match_id', 'id');
    }
    public function tv_channels()
    {
        return $this->hasMany(MatchTvChannel::class, 'match_id', 'id');
    }
    public function round()
    {
        return $this->belongsTo(Round::class, 'round_id', 'id');
    }
    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team_id');
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
