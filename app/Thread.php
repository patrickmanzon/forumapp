<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\ThreadReceiveReply;

class Thread extends Model
{
  use RecordsActivity;

	protected $guarded = [];

  protected $with = ['creator', 'channel'];

  protected $appends = ["isSubscribeTo"];

  protected $casts = [
    'is_locked' => 'boolean'
  ];
    //
  protected static function boot(){
    parent::boot();

    static::addGlobalScope('repliesCount',function($builder){
      return $builder->withCount('replies');
    });

    // static::creating(function ($thread){
    //   $thread->createSlug();
    // });

    static::deleted(function($thread){
      return $thread->replies->each->delete();
    });

    static::created(function($thread){
      $thread->createSlug();
    });

  }

 	public function path(){

 		return "/threads/{$this->channel->slug}/{$this->slug}";

 	}

 	public function replies()
  {
  	return $this->hasMany(Reply::class);
  }

  public function addReply($reply)
  {
  	
    $reply = $this->replies()->create($reply);

    event(new ThreadReceiveReply($reply));
    
    return $reply;
  }

  // public function notify($reply)
  // {
  //   $this->subscriptions->filter( function ($subscription) use ($reply) {
  //       return $subscription->user_id != $reply->user_id;
  //   })->each->notify($reply);

  // }

  public function creator()
  {
  	return $this->belongsTo(User::class, "user_id");
  }

  public function channel(){
    return $this->belongsTo(Channel::class);
  }

  public function subscriptions()
  {
    return $this->hasMany(SubscribeThread::class);
  }

  public function subscribe()
  {
    return $this->subscriptions()->create([
      "user_id" => auth()->id()
    ]);
  }

  public function unsubscribe()
  {
    return $this->subscriptions()
            ->where("user_id", auth()->id())
            ->delete();
  }

  public function hasReadBy(){
    return $this->updated_at > cache(auth()->user()->visitedThreadKeyCache($this));
  }

  public function scopeFilter($query, $filter){
    return $filter->apply($query);
  }

  public function getIsSubscribeToAttribute()
  {
    return $this->subscriptions()
            ->where("user_id", auth()->id())
            ->exists();
  }

  // public function setSlugAttribute($value)
  // {
  //   $this->attribute['slug'] = $this->createSlug();
  // }

  public function createSlug()
  {
    $slug = str_slug($this->title);

    while (static::where('slug', '=', $slug)->exists()) {
      $slug = str_slug($this->title) .'-'.$this->id;
    }

    $this->slug = $slug;
    $this->save();
  }

  public function getRouteKeyName(){
    return 'slug';
  }

  public function locked(){
    $this->update(['is_locked' => true]);
  }

  public function unlocked(){
    $this->update(['is_locked' => false]);
  }

}
