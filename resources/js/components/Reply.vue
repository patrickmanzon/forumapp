<template>
	<div :class="['card mb-3']" :id="'#reply-'+id">                
	    <div :class="['card-header', isBest ? 'bg-success text-white' : '']">
	    	<div class="d-flex justify-content-center align-self-center">
				<div class="flex-grow-1">
					<img :src="reply.owner.profile_image" :alt="reply.owner.name" width="30" height="30" class="mr-2">
				   <a :href="'/profiles/'+reply.owner.name" v-text="this.reply.owner.name"></a> 
				   said {{ ago }}...
				</div>
				<div v-if="authorize('isLoggedIn')">
						<favorite :favorite = "reply" ></favorite>
				</div>
				<div v-else>
						<span class="btn btn-sm btn-secondary">{{reply.favorites_count }} <i class="fa fa-heart"></i></span>
				</div>
	       </div>
	    </div>
	    <div class="card-body" v-if="updating">
	    	<form @submit.prevent="saveReply">
		    	<div class="form-group">
		    		<textarea class="form-control" v-model="body" required></textarea>
		    	</div>
		    	<div class="d-flex" v-if="authorize('owns', reply)">
			    		<button class="btn btn-primary btn-sm mr-1" type="submit">Save</button>
			    		<button class="btn btn-danger btn-sm" @click = "updating = false" type="button">Cancel</button>
		    	</div>
	    	</form>
	    </div>
	    <div class="card-body" v-else>
	    	<p v-html="body" class="card-text"></p>
	    </div>   
	    <div class="card-footer text-muted d-flex" v-if="authorize('owns', reply)">
	    	<div class="d-flex">
		    	<button class="btn btn-warning btn-sm mr-1" @click = "updating = true">Edit</button>
		    	<button class="btn btn-danger btn-sm" @click = "deleteReply">delete</button>
		   	</div>
		   	<div class="flex-grow-1 d-flex justify-content-end">
		   		<button :class="['btn', isBest ? 'btn-success' : 'btn-secondary']" @click = "markBest">Best</button>
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
		props: ['reply'],
		data(){
			return {
				body: this.reply.body,
				updating: false,
				id: this.reply.id,
				isBest: this.reply.isBest,
			}
		},
		methods: {
			saveReply(){
				if(this.body != "")
				{
					axios.patch("/replies/" + this.reply.id, {
							body: this.body 
						}).then((res) => {
							this.updating = false
							flash(res.data.message, 'success')
						}).catch(err => {	
							flash(err.response.data, "danger")
						})
				}
			},
			deleteReply(){
                axios.delete('/replies/' + this.reply.id)
	                .then(res => {
	                	flash(res.data.message, "success")
	                	this.$emit('delete', this.reply.id)
	                })
            },
            markBest() {
            	axios.post('/best-reply/' + this.reply.id)
            		.then(() => {
            			window.events.$emit('mark-best-reply', this.reply.id)
            		});
            }
		},
		computed:{
			ago(){
				return moment(this.reply.created_at).fromNow()
			}
		},
		created(){
			window.events.$on('mark-best-reply', id => {
				this.isBest = (id === this.reply.id)
			})
		}
	}	

</script>