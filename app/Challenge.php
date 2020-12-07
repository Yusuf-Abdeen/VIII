<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function matrial()
    {
        return $this->belongsTo('App\Matrial');
    }

    public function chapters()
    {
        return $this->hasMany('App\ChallengesChapters');
    }

    public function statistics()
    {
        return $this->hasOne('App\ChallengeStatistics');
    }

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $fillable = [
        'difficulty',
        'sender_id',
        'reciver_id',
        'matrial_id',
        'challenge_type'
    ];

    // protected $with = ['chapters'];
}
