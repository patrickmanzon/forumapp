
<reply :attributes="{{ $reply }}" inline-template v-cloak>
	<div class="card mb-3" id="#reply-{{ $reply->id }}">                
	    <div class="card-header">
	    	<div class="d-flex justify-content-center align-self-center">
	    		<div class="flex-grow-1">
			       <a href="#">{{ $reply->owner->name }}</a> 
			       said {{ $reply->created_at->diffForHumans() }}...
		       </div>
		       <div >
		     		@auth
		     		<favorite :attributes = "{{ $reply }}"></favorite>
		       		{{-- <form action="{{ route('replies.favorites.store', $reply->id) }}" method="POST">
		       			@csrf
		       			<button class="btn btn-primary btn-sm">{{ $reply->favorites_count }} {{ str_plural('Favorite', $reply->favorites_count) }}</button>
		       		</form> --}}
		       		@else
		       			<span class="btn btn-sm btn-secondary">{{ $reply->favorites_count }} <i class="fa fa-heart"></i></span>
		       		@endauth
		       </div>
	       </div>
	    </div>
	    <div class="card-body" v-if="updating">
	    	<div class="form-group">
	    		<textarea class="form-control" v-model="body">{{ $reply->body }}</textarea>
	    	</div>
	    	<div class="d-flex">
	    		@can('update', $reply)
		    		<button class="btn btn-primary btn-sm mr-1" @click = "saveReply">Save</button>
		    		<button class="btn btn-danger btn-sm" @click = "updating = false">Cancel</button>
	    		@endcan
	    	</div>
	    </div>
	    <div class="card-body" v-else>
	    	<p v-text="body"></p>
	    </div>   
	    <div class="card-footer text-muted">
	    	<div class="d-flex">
		    	@can('update', $reply)
			    	<button class="btn btn-warning btn-sm mr-1" @click = "updating = true">Edit</button>
			    	<button class="btn btn-danger btn-sm" @click = "deleteReply">delete</button>
			   		{{-- <form action="{{ route('replies.delete', $reply) }}" method="POST">
			   			@csrf
			   			@method("DELETE")
			   			<button class="btn btn-danger btn-sm">delete</button>
			   		</form> --}}
		   		@endcan
		   	</div>
	  	</div>
	</div>      
</reply>
