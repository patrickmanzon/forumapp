<template>
	<div class="card mb-3" :id="'#reply-'+id">                
	    <div class="card-header">
	    	<div class="d-flex justify-content-center align-self-center">
	    		<div class="flex-grow-1">
			       <a :href="'/profiles/'+this.data.owner.name" v-text="this.data.owner.name"><!-- {{ $reply->owner->name }} --></a> 
			       said {{ ago }}<!-- {{ $reply->created_at->diffForHumans() }} -->...
		       </div>
		       <div v-if="signedIn">
		     		<!-- @auth -->
		     		<favorite :favorite = "this.data" ></favorite>
		       		<!-- @else -->
		       			<!-- <span class="btn btn-sm btn-secondary">3 <i class="fa fa-heart"></i></span> -->
		       		<!-- @endauth -->
		       </div>
		       <div v-else>
		       		<span class="btn btn-sm btn-secondary">{{ this.data.favorites_count }} <i class="fa fa-heart"></i></span>
		       </div>
	       </div>
	    </div>
	    <div class="card-body" v-if="updating">
	    	<div class="form-group">
	    		<textarea class="form-control" v-model="body"></textarea>
	    	</div>
	    	<div class="d-flex" v-if="canUpdate">
		    		<button class="btn btn-primary btn-sm mr-1" @click = "saveReply">Save</button>
		    		<button class="btn btn-danger btn-sm" @click = "updating = false">Cancel</button>
	    	</div>
	    </div>
	    <div class="card-body" v-else>
	    	<p v-text="body"></p>
	    </div>   
	    <div class="card-footer text-muted">
	    	<div class="d-flex" v-if="canUpdate">
			    	<button class="btn btn-warning btn-sm mr-1" @click = "updating = true">Edit</button>
			    	<button class="btn btn-danger btn-sm" @click = "deleteReply">delete</button>
		   	</div>
	  	</div>
	</div>    
</template>

<script>
	import Favorite from "./Favorite"
	import moment from "moment"
	export default{
		name: 'Reply',
		components: {
			Favorite
		},
		props: ['data'],
		data(){
			return {
				body: this.data.body,
				updating: false,
				id: this.data.id,
				signedIn: window.App.signedIn,
			}
		},
		methods: {
			saveReply(){
				if(this.body != "")
				{
					axios.patch("/replies/" + this.data.id, {
						body: this.body 
					}).then((res) => {
						console.log(res)
						this.updating = false
						flash(res.data.message)
					})
				}
			},
			deleteReply(){
                axios.delete('/replies/' + this.data.id)
                .then(res => {
                	flash(res.data.message)
                	this.$emit('delete', this.data.id)
                })
            },
		},
		computed:{
			canUpdate(){
				return this.authorize(user => user.id === this.data.user_id)
			},
			ago(){
				return moment(this.data.created_at).fromNow()
			}
		},
		created(){
		}
	}	

</script>