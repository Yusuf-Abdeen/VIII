<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    public function matrial()
    {
        return $this->belongsTo('App\Matrial');
    }

    public function quetions()
    {
        return $this->hasMany('App\Quetion')->where('deleted_at', null)->limit(2);
    }
    
    protected $fillable = ['name', 'matrial_id'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $with = ['quetions.answers'];
}
