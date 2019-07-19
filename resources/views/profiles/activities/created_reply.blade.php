@component('profiles.activities.activity')

	@slot('title')
		<div class="flex-grow-1">
		    {{ $subject->owner->name }} replied to a thread <a href="{{ $subject->thread->path() }}">{{ $subject->thread->title }}</a>
		</div>
	@endslot
	
	@slot('body')
		{{ $subject->body }}
	@endslot

@endcomponent