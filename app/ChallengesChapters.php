<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChallengesChapters extends Model
{
	public $timestamps = false;
    
    public function challenge()
    {
        return $this->belongsTo('App\Challenge');
    }

    public function chapter()
    {
        return $this->belongsTo('App\Chapter');
    }

	protected $hidden = [
        'id',
        'challenge_id',
         // 'chapter_id'
    ];

    protected $fillable = ['challenge_id', 'chapter_id'];

}
