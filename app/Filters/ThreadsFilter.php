<?php

namespace App\Filters;

use App\User;

class ThreadsFilter extends Filters {


	protected $filter = ['by'];

	public function by($username)
	{	
		$user = User::where('name', $username)->first();
		return $this->builder->where('user_id', $user->id);
	}

}