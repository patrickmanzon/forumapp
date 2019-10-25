<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reply extends Model
{
    
    use RecordsActivity, Favoritable;

    protected $guarded = [];
    protected $with = ['owner', 'favorites'];
    protected $withCount = ['favorites'];
    protected $appends = ['isFavorited', 'isBest'];

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

    public function ifWasJustPublished()
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    } 

    public function setBodyAttribute($body)
    {
        $this->attributes["body"] = preg_replace('/@([\w\-]+)/', '<a href="/profiles/$1">$0</a>', $body);
    }

    public function mentionedUsers()
    {   
        preg_match_all('/@([\w\-]+)/', $this->body, $matches);
        return $matches[1];
    }

    public function markBest(){
        $this->thread->update(['best_reply' => $this->id]);
    }

    public function isBest(){
        return $this->thread->best_reply == $this->id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }
}
