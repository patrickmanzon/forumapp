<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    
    use RecordsActivity, Favoritable;

    protected $guarded = [];
    protected $with = ['owner', 'favorites'];
    protected $withCount = ['favorites'];
    protected $appends = ["isFavorited"];

    protected static function boot()
    {   
        parent::boot();
        static::created(function($reply){
            $reply->thread()->increment('replies_count', 1);
        });

        static::deleted(function($reply){
            $reply->thread()->decrement('replies_count', 1);
        });

    }

    public function owner()
    {
    	return $this->belongsTo(User::class, 'user_id');
    }


    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }


    public function path()
    {
        return $this->thread->path().'#reply-'.$this->id; 
    }    
}
