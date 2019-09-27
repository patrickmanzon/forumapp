@extends('layouts.app')

@section('content')
<div class="container">
    <div class="pb-2 mt-4 mb-2 border-bottom">
        <avatar-form :user="{{ $profile }}"></avatar-form>
    </div>
    <div class="row">
        <div class="col-md-8">
        @foreach($activities as $date => $activity)
            <div class="pb-2 mt-4 mb-2 border-bottom">
                <h4><small class="text-muted small">{{ $date }}</small></h4>
            </div>
            @foreach($activity as $act)
                @if(view()->exists("profiles.activities.{$act->type}"))
                    @include("profiles.activities.{$act->type}", ["subject" => $act->subject])
                @endif
            @endforeach
            {{-- <div class="card mb-3">                
                <div class="card-header">
                    <div class="d-flex justify-content-center"> 
                        <div class="flex-grow-1">
                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                        </div>
                        <div>
                            <a href="{{ $thread->path() }}">{{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {{ $thread->body }}
                </div>          
            </div> --}}
        @endforeach
        </div>
    </div> 
</div>
@endsection
