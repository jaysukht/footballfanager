<?php

namespace App\GraphQL\Resolvers;

use Illuminate\Support\Facades\Cache;
use App\Models\Round;

class RoundResolver
{
    public function list($_, array $args)
    {
        // Unique cache key (safe for future filters)
        $cacheKey = 'rounds_' . md5(json_encode($args));

        // Optional: debug cache status
        $GLOBALS['cache_status'] = Cache::has($cacheKey) ? 'HIT' : 'MISS';

        return Cache::remember($cacheKey, 300, function () {
            return Round::all();
        });
    }
}