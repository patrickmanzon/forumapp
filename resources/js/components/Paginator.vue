<template>
	<ul class="pagination" v-show="shouldPaginate">
	    <li class="page-item" v-if="prev">
	      <a class="page-link" @click.prevent = "page--" href="">Previous</a>
	    </li>
	    <li class="page-item" v-if="next">
	      <a class="page-link" @click.prevent = "page++" href="">Next</a>
	    </li>
  	</ul>
</template>

<script>
	export default{
		props: ["dataSet"],
		data(){
			return {
				next: false,
				prev: false,
				page: false
			}
		},
		methods:{
			dispatch(){
				this.$emit('paginate', this.page)
				history.pushState(null, null, "?page=" + this.page)
			}
		},
		computed:{
			shouldPaginate()
			{
				return !!this.next || !!this.prev
			}
		},
		watch: {
			dataSet(){
				this.next = this.dataSet.next_page_url
				this.prev =  this.dataSet.prev_page_url
				this.page = this.dataSet.current_page
			},
			page(){
				this.dispatch()
			}
		},
		mounted(){

		},
		created(){
			
		}
	}
</script>