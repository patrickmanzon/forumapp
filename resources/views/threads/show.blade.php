@extends('layouts.app')

@section('content')
<div class="container">
   
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">                
                <div class="card-header">
                   <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                </div>
                <div class="card-body">
                    {{ $thread->body }}
                </div>            
            </div>
       

            @foreach($replies as $reply)
                @include('threads.replies')
            @endforeach
        
            {{ $replies->links() }}

            <form action="{{ $thread->path().'/replies' }}" method="POST">
                @csrf
                <div class="form-group">
                    <textarea name="body" rows="5" class="form-control" placeholder="Have something to say?"></textarea>
                </div>
                <button class="btn btn-primary" type="submit">Post</button>
            </form>
        </div>

        <div class="col-4">
            <div class="card mb-3">                
                <div class="card-body">
                    This thread is created {{ $thread->created_at->diffForHumans() }} by 
                    <a href="#">{{ $thread->creator->name }}</a> with {{ $thread->replies_count }} {{str_plural('comment',$thread->replies_count)}}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
