<?php 

namespace App;

trait Favoritable{

	protected static function bootFavoritable()
	{
		static::deleted(function($model) {
			$model->favorites->each->delete();
		});

		// static::created(function($model){
		// 	dd($model);
		// });
	}

	public function favorites()
    {
    	return $this->morphMany(Favorite::class, 'favorited');
    }

	public function favorite($user_id){
    	$attribute = ['user_id' => $user_id];
    	
    	if(!$this->isFavorited($attribute)) {
    		$this->favorites()->create($attribute);
    	};
    }

    public function unfavorite($user_id)
    {
        $attribute = ['user_id' => $user_id];
        return $this->favorites()->where($attribute)->get()->each->delete();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited(["user_id" => auth()->id()]);
    }

    public function isFavorited($attribute)
    {
        return $this->favorites()->where($attribute)->exists();
    }

}



?>