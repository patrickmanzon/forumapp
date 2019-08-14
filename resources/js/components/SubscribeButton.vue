<template>
	<button :class="classes" @click="subscribe" v-text="textValue">Subscribe</button>
</template>

<script>
	export default{
		props: ["active"],
		data(){
			return {
				isActive: this.active,
			}
		},
		computed:{
			classes(){
				return ['btn', this.isActive ? "btn-primary" : "btn-secondary"]
			},
			textValue()
			{
				return this.isActive ? "Subscribed" : "Subscribe"
 			}
		},
		methods:{
			subscribe(){
				axios[this.isActive ? 'delete' : 'post'](`${location.pathname}/subscribe`)
				.then((res) => {
					//flash("Subscribe")
					this.isActive = !this.isActive
				})
			}
		}
	}
</script>