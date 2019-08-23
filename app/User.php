<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //protected $with = ['activities'];
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function activities(){
        return $this->hasMany(Activity::class);
    }

    public function read($thread)
    {
        cache()->forever(
            $this->visitedThreadKeyCache($thread),
            Carbon::now()
        );
    }

    public function visitedThreadKeyCache($thread){
        return sprintf("user.%s.visited.%s", $this->id, $thread->id);
    }

    public function checkReply()
    {
        return $this->hasOne(Reply::class)->latest();
    }

}
