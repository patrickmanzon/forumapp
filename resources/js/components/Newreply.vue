<template>
	<div v-if="signedIn">
        <!-- <form action="{{ $thread->path().'/replies' }}" method="POST"> -->
            <div class="form-group">
            	<vue-tribute :options="options">
				    <textarea name="body" id="reply-input" rows="5" class="form-control" placeholder="Have something to say?" v-model = "body" @tribute-replaced="updateFromTribute"></textarea>
				</vue-tribute>
                
            </div>
            <button class="btn btn-primary" type="submit" @click="addReply">Post</button>
        <!-- </form> -->
    </div>
    <div v-else>
    	<p>
    		<a href="/login">login</a> to comment!
    	</p>
    </div>
</template>

<script>
	import VueTribute from 'vue-tribute'
	import _ from "lodash"
	export default{
		data(){
			return{
				body: '',
				options: {
					trigger: '@',
					values: _.debounce(function(text, cb){
						axios.get('/api/users', { params:{search : text} })
						.then(res => {
							console.log(res.data)

							cb(res.data)
						})
					}, 500)
				}
			}
		},
		methods: {
			addReply(){
	
				axios.post(window.location.pathname + "/replies", {body: this.body})
				.then(res => {
					flash("Reply created.", 'success')

					this.body = ''
					//console.log(res.data)
					this.$emit("created", res.data)
					//window.events.$emit("added", res.data)
					window.scrollTo(0, 0)
				}).catch(err => {
					flash(err.response.data, "danger")
				})
			},

			updateFromTribute(e){
				this.body = e.target.value
			}
		},
		computed:{
			signedIn(){
				return window.App.signedIn
			}
		}

	}
</script>