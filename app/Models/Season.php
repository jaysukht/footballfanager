<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    //
    protected $table = 'seasons';
    protected $guarded = [];
    public function matches()
    {
        return $this->hasMany(Matches::class, 'season_id');
    }
}
