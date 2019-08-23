<?php

namespace App\Inspections;

class DetectKeywords {

	protected $keywords = [
		"Yahoo Customer Support"
	];

	public function detect($body){

		foreach($this->keywords as $keyword){
			if(stripos($body, $keyword) !== false){
				throw new \Exception("You message contains a spam");
			}
		}
		return false;
	}

}