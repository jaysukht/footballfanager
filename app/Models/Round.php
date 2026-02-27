<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{
    //
    protected $table = 'rounds';
    protected $guarded = [];
    public function matches()
    {
        return $this->hasMany(Matches::class, 'round_id', 'id');
    }
}
