<div class="card mb-3">                
    <div class="card-header">
        <div class="d-flex justify-content-center"> 
            {{ $title }}
        </div>
    </div>
    <div class="card-body">
        {{ $body }}
    </div>          
</div>

{{-- <div class="flex-grow-1">
    <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
</div>
<div>
    <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}</a>
</div> --}}