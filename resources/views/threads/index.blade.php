@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
        @include("threads._lists")
        {{ $threads->render() }}
        </div>
        <div class="col-md-4">
            @if(count($trending))
                <div class="card mb-3">                
                    <div class="card-header text-center">
                        <h4>Trends right now</h4>
                    </div>
                    <div class="card-boy">
                        <ul class="list-group">
                            @foreach($trending as $thread)
                                <li class="list-group-item">
                                    <a href="{{ $thread->path }}">
                                        {{ $thread->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            
        </div>
    </div> 
</div>
@endsection
