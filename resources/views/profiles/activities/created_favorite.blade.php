@component('profiles.activities.activity')

	@slot('title')
		<div class="flex-grow-1">
		    <a href="{{ $subject->favorited->path() }}"> {{ $subject->favorited->owner->name }} favorited a reply </a>
		</div>
		
	@endslot
	
	@slot('body')
		{{ $subject->favorited->body }}
		
	@endslot

@endcomponent