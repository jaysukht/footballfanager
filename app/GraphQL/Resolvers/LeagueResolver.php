<?php
namespace App\GraphQL\Resolvers;
use Illuminate\Support\Facades\Cache;
use App\Models\League;

class LeagueResolver
{
    public function list($root, array $args)
    {
        $cacheKey = 'leagues_all';
        if (Cache::has($cacheKey)) {
            $GLOBALS['cache_status'] = 'HIT';
        } else {
            $GLOBALS['cache_status'] = 'MISS';
        }
        return Cache::remember($cacheKey, 300, function () {
            return League::all();
        });
    }
}
