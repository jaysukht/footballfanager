<?php

namespace App\GraphQL\Resolvers;

use Illuminate\Support\Facades\Cache;
use App\Models\Matches;

class MatchResolver
{
    public function byFilter($root, array $args)
    {
        $cacheKey = "matches_{$args['league_id']}_{$args['round_id']}_{$args['season_id']}";

        // Check cache status
        if (Cache::has($cacheKey)) {
            $GLOBALS['cache_status'] = 'HIT';
        } else {
            $GLOBALS['cache_status'] = 'MISS';
        }
        return Cache::remember($cacheKey, 300, function () use ($args) {
            return Matches::where('league_id', $args['league_id'])
                ->where('round_id', $args['round_id'])
                ->where('season_id', $args['season_id'])
                ->orderBy('match_date')
                ->get();
        });
    }
    public function matchDetail($_, array $args)
    {
        $cacheKey = "matches_byid{$args['id']}";

        // Check cache status
        if (Cache::has($cacheKey)) {
            $GLOBALS['cache_status'] = 'HIT';
        } else {
            $GLOBALS['cache_status'] = 'MISS';
        }
        return Cache::remember($cacheKey, 300, function () use ($args) {
            return Matches::find($args['id']);
        });
    }
    public function matchDetailByHomeAway($_, array $args)
    {
        $homeTeamId = $args['home_team_id'] ?? null;
        $awayTeamId = $args['away_team_id'] ?? null;
        if (!$homeTeamId || !$awayTeamId) {
            return collect(); // return empty collection if invalid input
        }
        $cacheKey = "matches_byhomeaway_{$homeTeamId}_{$awayTeamId}";
        // Check cache status
        if (Cache::has($cacheKey)) {
            $GLOBALS['cache_status'] = 'HIT';
        } else {
            $GLOBALS['cache_status'] = 'MISS';
        }
        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($homeTeamId, $awayTeamId) {
            return Matches::query()
                ->where('home_team_id', $homeTeamId)
                ->where('away_team_id', $awayTeamId)
                ->orderByDesc('match_date') // better readable
                ->limit(6)
                ->get();
        });
    }
}
