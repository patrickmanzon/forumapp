<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
  use RecordsActivity;

	protected $guarded = [];

  protected $with = ['creator', 'channel'];
    //
  protected static function boot(){
    parent::boot();

    static::addGlobalScope('repliesCount',function($builder){
      return $builder->withCount('replies');
    });

    static::deleted(function($thread){
      return $thread->replies->each->delete();
    });

    // static::creating(function($thread){
    //   dd($thread);
    // });

  }

 	public function path(){
 		return "/threads/{$this->channel->slug}/{$this->id}";
 	}

 	public function replies()
  {
  	return $this->hasMany(Reply::class);
  }

  public function addReply($reply)
  {
  	return $this->replies()->create($reply);
  }

  public function creator()
  {
  	return $this->belongsTo(User::class, "user_id");
  }

  public function channel(){
    return $this->belongsTo(Channel::class);
  }

  public function scopeFilter($query, $filter){
    return $filter->apply($query);
  }

}
