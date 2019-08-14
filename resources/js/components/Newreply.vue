<template>
	<div v-if="signedIn">
        <!-- <form action="{{ $thread->path().'/replies' }}" method="POST"> -->
            <div class="form-group">
                <textarea name="body" rows="5" class="form-control" placeholder="Have something to say?" v-model = "body"></textarea>
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
	export default{
		data(){
			return{
				body: ''
			}
		},
		methods: {
			addReply(){
				axios.post(window.location.pathname + "/replies", {body: this.body})
				.then(res => {
					flash("Reply created.")

					this.body = ''
					//console.log(res.data)
					this.$emit("created", res.data)
					//window.events.$emit("added", res.data)
					window.scrollTo(0, 0)
				})
			}
		},
		computed:{
			signedIn(){
				return window.App.signedIn
			}
		}

	}
</script>