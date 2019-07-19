<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
    	return $this->morphTo();
    }

    public static function feed($user)
    {
    	return static::where('user_id', $user->id)->with('subject')->take(10)->latest()->get()->groupBy(function($query){
			return $query->created_at->format('Y-m-d');
		});
    }
}
