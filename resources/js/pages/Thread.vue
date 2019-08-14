<script>
	
	import Replies from '../components/Replies.vue'
	import SubscribeButton from '../components/SubscribeButton.vue'

	export default{
		components:{
			Replies,
			SubscribeButton
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