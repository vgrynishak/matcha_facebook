<template>
    <div class="container">
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <textarea readonly rows="10" class="form-control">{{messages.join('\n')}}</textarea>
                <hr>
                <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage">
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChatComponent",
        data:function () {
            return {
                messages:[],
                textMessage:''
            }
        },
        mounted() {
            console.log('Ok');
        },
        methods:{
            sendMessage(){
                axios.post('/messages', {body: this.textMessage});
                this.messages.push(this.textMessage);
                this.textMessage = '';
            }
        }
    }
</script>

<style scoped>

</style>