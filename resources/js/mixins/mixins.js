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
		},
		add(item)
		{
			this.items.push(item)
			this.$emit('added')
		}
	}
}