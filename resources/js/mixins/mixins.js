export default{
	data()
	{
		return {
			items: []
		}
	},
	methods: {
		deleted(index){
			this.$emit('removed')
			this.items = this.items.filter(d => d.id != index)
			flash('Reply Deleted')
		},
		add(item)
		{
			this.items.push(item)
			this.$emit('added')
		}
	}
}