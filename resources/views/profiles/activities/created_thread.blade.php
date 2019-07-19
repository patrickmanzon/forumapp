@component('profiles.activities.activity')

	@slot('title')
		<div class="flex-grow-1">
		    {{ $subject->creator->name }} posted a thread <a href="{{ $subject->path() }}">{{ $subject->title }}</a>
		</div>
	@endslot
	
	@slot('body')
		{{ $subject->body }}
	@endslot

@endcomponent

