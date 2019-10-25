@foreach($threads as $thread)
    <div class="card mb-3">                
        <div class="card-header">
            <div class="d-flex justify-content-center"> 
                <div class="flex-grow-1">
                    <a href="{{ $thread->path() }}">
                        @if(auth()->check() && $thread->hasReadBy())
                            <strong>{{ $thread->title }}</strong>
                        @else
                            {{ $thread->title }}
                        @endif
                    </a>
                    posted by 
                    <a href="{{ route('profiles.show', $thread->creator) }}">{{ $thread->creator->name }}</a>
                </div>
                <div>
                    <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{ $thread->body }}
        </div> 
        <div class="card-footer">
            {{ $thread->visits }} {{ str_plural('visit',$thread->visits) }}
        </div>         
    </div>
@endforeach