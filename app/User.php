<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Mail\SendVerificationCode;

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
        'name', 'email', 'password', 'profile_image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $appends = ['isAdmin'];

    protected static function boot(){ 
        parent::boot();
    }

    public function isAdmin(){
        $admins = ['johnWick'];
        return in_array($this->name, $admins);
    }

    public function getIsAdminAttribute(){
        return $this->isAdmin();
    }

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

    public function getProfileImageAttribute($avatar){
        return asset($avatar !== null ? "storage/".$avatar : "images/default.png");
    }

    public function createVerificationToken()
    {
        $this->confirmation_token = md5($this->email);
        $this->save();
    }

    public function sendVerificationCode()
    {
        return \Mail::to($this)->send(new sendVerificationCode($this));
    }

    public function verified()
    {
        $this->is_verified = 1;
        $this->save();
    }

}
