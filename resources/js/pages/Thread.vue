<script>
	
	import Replies from '../components/Replies.vue'
	import SubscribeButton from '../components/SubscribeButton.vue'

	export default{
		components:{
			Replies,
			SubscribeButton
		},
		props: ["thread"],
		data () {
			return {
				repCount: this.thread.replies_count,
				isLocked: this.thread.is_locked
			}
		},
		methods: {
			lock() {
				axios[this.isLocked ? 'delete' : 'patch'](`/lock-thread/${this.thread.slug}`);
				this.isLocked = !this.isLocked
			}
		},
		created()
		{
			// window.events.$on('removed', () => {
			// 	this.repCount--
			// })
		}
	}
</script>