<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Matrial extends Model
{
    public function chapters(){
        return $this->hasMany('App\Chapter')->where('deleted_at', null);
    }

    protected $fillable = ['name'];

    protected $hidden = [
		'created_at',
	 	'updated_at',
	 	'deleted_at'
 	];

    protected $with = ['chapters'];
}
