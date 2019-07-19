<script>
	
	import Replies from '../components/Replies.vue'

	export default{
		components:{
			Replies
		},
		props: ["repliesCount"],
		data(){
			return {
				repCount: this.repliesCount
			}
		},
		methods: {
		},
		created()
		{
			// window.events.$on('removed', () => {
			// 	this.repCount--
			// })
		}
	}
</script>