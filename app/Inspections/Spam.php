<?php
namespace App\Inspections;

class Spam{

	private $classes = [
		DetectKeywords::class
	];

	public function detect($body){
		foreach ($this->classes as $class) {
			resolve($class)->detect($body);
		}
	}

}