<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $guarded = [];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
}
