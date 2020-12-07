<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quetion extends Model
{
    public function chapter()
    {
        return $this->belongsTo('App\Chapter');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    // protected $with = ['matrial', 'chapter', 'answers'];
}
