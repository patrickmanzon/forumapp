<template>
	<li class="nav-item dropdown" v-if="notifications.length > 0">
		<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fa fa-bell"></i>
		</a>
		<div class="dropdown-menu" aria-labelledby="navbarDropdown">
			<a class="dropdown-item" v-for="notification in notifications" @click="markAsRead(notification)" :href="notification.data.link">{{ notification.data.message }}</a>
		</div>
	 </li>
</template>

<script>
	export default{
		data(){
			return{
				endpoint: '/profiles/notifications',
				notifications: []
			}
		},
		methods:{
			markAsRead(notification){
				axios.delete(`${this.endpoint}/${notification.id}`)
			},
			async getNotifications()
			{	
				let response = await axios.get(this.endpoint)
				let {data} = response
				this.notifications = data 
			}
		},
		created(){
			this.getNotifications()
		}
	}
</script>