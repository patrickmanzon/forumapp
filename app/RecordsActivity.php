<?php 

namespace App;

trait RecordsActivity{

	protected static function bootRecordsActivity()
	{	

		foreach (static::getEventsActivity() as $event) {
			static::$event(function($model) use ($event){
		        return $model->recordsActivity($event);
	      	});
		}

		static::deleting(function($model) {
			return $model->activities()->delete();
		});
		
	}

	protected function recordsActivity($event)
	{
		return $this->activities()->create([
          "user_id" => auth()->id(),
          "type" => $this->getActivityType($event)
        ]);
	}

	protected static function getEventsActivity()
	{
		return ['created'];
	}

	protected function getActivityType($event)
    { 
    	$type = strtolower((new \ReflectionClass($this))->getShortName());
    	return "{$event}_{$type}";
    }

    public function activities()
    {
      return $this->morphMany(Activity::class, 'subject');
    }

}


?>