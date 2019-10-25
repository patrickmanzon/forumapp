<template>
	<div>
		<div class="d-flex align-items-center mb-3">
			<img :src="avatar" :alt="this.user.name">
        	<h2 v-text="user.name" class="ml-3"> </h2>
		</div>
		
		<avatar-input name="avatar" @uploaded="avatarUpload" v-show="authorize('owns', user)"></avatar-input>
        
	</div>
</template>

<script>
	import AvatarInput from './AvatarInput'
	export default{
		components: {AvatarInput},
		props: ["user"],
		data(){
			return {
				avatar: this.user.profile_image
			}
		},
		methods:{
			avatarUpload(avatar){
				const data = new FormData()
				data.append('avatar', avatar.file)
				this.avatar = avatar.src
				//axios
				this.persist(data)
			},

			persist(data){
				axios.post(`/api/users/${this.user.name}/avatar`, data)
					.then(res => {
						flash('Uploaded!', 'Success')
					})
			}
		}
		
	}
</script>

<style scoped>
	div img {
		width: 50px;
		height: 50px;
	}
</style>