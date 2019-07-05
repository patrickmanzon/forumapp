<?php

namespace App\Filters;

use App\User;

class ThreadsFilter extends Filters {


	protected $filter = ['by', 'popular'];

	protected function by($username)
	{	
		$user = User::where('name', $username)->first();
		return $this->builder->where('user_id', $user->id);
	}

	protected function popular()
	{	
		$this->builder->getQuery()->orders = null;
		return $this->builder->orderBy('replies_count', 'DESC');
	}

}