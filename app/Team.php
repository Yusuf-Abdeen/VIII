<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    public function creator()
    {
        return $this->belongsTo('App\User', 'creator_id');
    }

    public function members()
    {
        return $this->hasMany('App\TeamMembers', 'member_id');
    }

    protected $fillable = ['name', 'creator_id'];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $with = ['creator', 'members'];
}
