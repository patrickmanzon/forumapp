@extends('layouts.app')

@section('content')
<thread-show :replies-count = "{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">                
                    <div class="card-header">
                        <div class="d-flex">
                            <a href="{{ $thread->path() }}" class="flex-grow-1">{{ $thread->title }}</a>
                            @can('update', $thread)
                            <form action="{{ route('threads.destroy', $thread) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete Thread</button>
                            </form>
                            @endcan
                        </div>
                       
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>            
                </div>
                

               {{--  @foreach($replies as $reply)
                    @include('threads.replies')
                @endforeach --}}
                

                <replies @removed = "repCount--" @added = "repCount++"></replies>            
                {{-- {{ $replies->links() }} --}}
                
            </div>

            <div class="col-4">
                <div class="card mb-3">                
                    <div class="card-body">
                        <p>This thread is created {{ $thread->created_at->diffForHumans() }} by 
                        <a href="{{ route('profiles.show', $thread->creator) }}">{{ $thread->creator->name }}</a> with <span v-text = "repCount"></span> comments{{-- {{ $thread->replies_count }} --}} {{-- {{str_plural('comment',$thread->replies_count)}} --}}
                        </p>
                        <p>
                            <subscribe-button :active="@json($thread->isSubscribeTo)"></subscribe-button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-show>
@endsection
