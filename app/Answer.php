<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	public function quetion()
    {
        return $this->belongsTo('App\Quetion');
    }

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
