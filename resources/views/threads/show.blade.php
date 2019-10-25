@extends('layouts.app')

@section('content')
<thread-show :thread = "{{ $thread }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">                
                    <div class="card-header">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <img src="{{ $thread->creator->profile_image }}" alt="{{ $thread->creator->name }}" width="30" height="30" class="mr-2">
                                <a href="{{ $thread->path() }}" >
                                        {{ $thread->title }}
                                </a>
                            </div>
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

                <replies @removed = "repCount--" @added = "repCount++"></replies>            
                
            </div>

            <div class="col-4">
                <div class="card mb-3">                
                    <div class="card-body">
                        <p>This thread is created {{ $thread->created_at->diffForHumans() }} by 
                        <a href="{{ route('profiles.show', $thread->creator) }}">{{ $thread->creator->name }}</a> with <span v-text = "repCount"></span> comments
                        </p>
                        <p v-if="authorize('isLoggedIn')" v-cloak>
                            <subscribe-button :active="@json($thread->isSubscribeTo)"></subscribe-button>
                            <button :class="['btn', isLocked ? 'btn-success' : 'btn-secondary']" @click="lock" v-show="authorize('isAdmin')" v-text = "isLocked ? 'Unlock' : 'lock'"></button>
                        </p>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-show>
@endsection
