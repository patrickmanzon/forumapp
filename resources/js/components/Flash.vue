<template>
    <div class="flash" v-show="show">
        <div class="alert alert-success" role="alert">
          Success! {{ body }}
        </div>
    </div>
</template>

<script>
    export default {
        props: ['message'],
        data(){
            return {
                body: '',
                show: false
            }
        },
        methods: {
            flash(message){
                this.body = message
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
            window.events.$on('flash', (message) => {
                this.flash(message)
            })
        },
        created()
        {
            if(this.message){
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