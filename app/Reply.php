<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    //
    protected $guarded = [];
    protected $with = ['owner', 'favorites'];
    protected $withCount = ['favorites'];

    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites()
    {
    	return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite($user_id){
    	$attribute = ['user_id' => $user_id];
    	
    	if($this->favorites()->where($attribute)->exists()) {
    		return $this->favorites()->where($attribute)->delete();
    	};

    	return $this->favorites()->create($attribute);
    }
    
}
