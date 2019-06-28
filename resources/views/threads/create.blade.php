@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">                
                <div class="card-header">
                    Create a thread
                </div>
                <div class="card-body">
                   <form action="{{ route('threads.store') }}" method="POST">
                       @csrf
                       <div class="form-group">
                           <input type="text" class="form-control" placeholder="Title" name="title" value="{{ old('title') }}" required="">
                       </div>
                       <div class="form-group">
                           <select name="channel" class="form-control" required="">
                                <option value="">Choose a channel..</option>
                               @foreach($channels as $channel)
                               <option value="{{ $channel->id }}" {{ old('channel') == $channel->id ? 'selected' : ''}}>{{ $channel->name }}</option>
                               @endforeach
                           </select>
                       </div>
                       <div class="form-group">
                           <textarea name="body" rows="5" class="form-control" placeholder="Your description here." required="">{{ old('body') }}</textarea>
                       </div>
                      <div class="form-group">
                        <button type="submit" class="btn btn-primary">Post</button>
                      </div>
                      @if(count($errors))
                      <ul class="alert alert-danger">
                        @foreach($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                      @endif
                   </form>
                </div>          
            </div>
        </div>
    </div> 
</div>
@endsection
