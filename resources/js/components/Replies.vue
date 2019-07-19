<template>
	<div>
		<div v-for="(reply, index) in items">
			<reply :data = "reply" @delete = "deleted"></reply>
		</div>
		<paginator :data-set = "dataSet" @paginate = "fetch"></paginator>
		<newreply @created = "add"></newreply>
	</div>
</template>

<script>
	import Reply from "./Reply.vue"
	import Newreply from "./Newreply.vue"
	import mixins from "../mixins/mixins.js"
	export default{
		components: {
			Reply,
			Newreply
		},
		mixins: [mixins],
		data(){
			return {
				dataSet: []
			}
		},
		methods: {
			fetch(page){
				axios.get(this.url(page))
				.then(this.response)
			},

			response({data})
			{
				this.items = data.data
				this.dataSet = data
			},

			url(page){
				if(!page){
					let pageUrl = location.search.match(/page=(\d+)/)
					page = pageUrl ? pageUrl[1] : 1
				}
				return `${window.location.pathname}/replies?page=${page}`
			}
		},
		mounted(){

		},
		created(){
			this.fetch()
		}
	}
</script>