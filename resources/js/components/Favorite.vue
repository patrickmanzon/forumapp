<template>
	<button class="btn btn-sm" @click="send" :class="isActive" >{{ count }} <i class="fa fa-heart"></i></button>
</template>

<script>
	export default{
		name: "Favorite",
		props: ["favorite"],
		data(){
			return {
				count: this.favorite.favorites_count,
				active: this.favorite.isFavorited
			}
		},
		methods: {
			send(){
				if(this.active){
					axios.delete("/favorites/" + this.favorite.id)
					.then(res => {
						this.count--
						this.active = false
					})
				}else{
					axios.post("/favorites/" + this.favorite.id)
					.then(res => {
						this.count++
						this.active = true
					})
				}
			},

		},
		computed: {
			isActive(){
				return [this.active ? "btn-primary" : "btn-dark"]
			}
		},
		created(){
			
		}

	}
</script>