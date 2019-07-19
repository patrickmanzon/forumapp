@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @foreach($threads as $thread)
            <div class="card mb-3">                
                <div class="card-header">
                    <div class="d-flex justify-content-center"> 
                        <div class="flex-grow-1">
                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
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
            </div>
        @endforeach
        {{ $threads->links() }}
        </div>
    </div> 
</div>
@endsection
