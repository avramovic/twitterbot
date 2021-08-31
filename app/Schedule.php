<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $table = 'schedules';
    protected $fillable = ['date','time','text'];

    public function media()
    {
        return $this->hasMany(Media::class);
    }

}
