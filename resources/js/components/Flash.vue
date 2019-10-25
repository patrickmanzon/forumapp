<template>
    <div class="flash" v-show="show">
        <div class="alert" :class="'alert-'+alert" role="alert" v-text="body">
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data(){
            return {
                body: '',
                show: false,
                alert: 'success'
            }
        },
        methods: {
            flash(data){
                this.body = data
                if(typeof data === 'object'){
                    this.body = data.message
                    this.alert = data.alert
                }
                this.show = true
                this.hide()
            },
            hide(){
                setTimeout(()=>{
                    this.show = false
                }, 3000)
            }
        },
        mounted() {
            window.events.$on('flash', (data) => {
                this.flash(data)

            })
        },
        created()
        {
            if(this.message){
                //console.log(this.message)
                this.flash(this.message)
            }
        }
    }
</script>


<style>
    .flash{
        width: 300px;
        position: fixed;
        bottom: 25px;
        right: 25px;
    }
</style>