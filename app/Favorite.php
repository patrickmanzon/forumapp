<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
	use RecordsActivity;

	//protected $with = ['favorited'];

	protected $guarded = [];
    //
	public function favorited()
	{
		return $this->morphTo();
	}

}
