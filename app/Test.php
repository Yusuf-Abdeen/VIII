<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function matrial()
    {
        return $this->belongsTo('App\Matrial');
    }

    public function chapter()
    {
        return $this->belongsTo('App\Chapter');
    }

    public $fillable = ['stars', 'user_id', 'matrial_id', 'chapter_id'];

    // protected $with = ['user', 'matrial', 'chapter'];
}
