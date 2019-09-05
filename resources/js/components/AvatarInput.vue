<template>
	<input type="file" accept="image/*" @change = "uploaded">
</template>

<script>
	export default{
		methods: {
			uploaded(e){
				const file = e.target.files[0]
				const reader = new FileReader()
				reader.readAsDataURL(file)
				reader.addEventListener("load", () => {
			    	const src = reader.result
					this.$emit('uploaded', {src,file})
			  	}, false);
			}
		}
	}
</script>