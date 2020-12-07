<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallengeStatistics extends Model
{
    public function challenge()
    {
        return $this->belongsTo('App\Challenge');
    }

    protected $fillable = [
        'sender_correct_answers',
        'sender_wrong_answers',
        'reciver_correct_answers',
        'reciver_wrong_answers',
        'winner_id',
        'challenge_id',
    ];
}
