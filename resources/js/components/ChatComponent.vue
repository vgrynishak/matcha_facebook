<template>
    <div class="container">
        <div class="row">
            <div class="photo">
                <div v-for="chat in chats">
                    <!--{{chat['username']}}-->
                    <a @click="open_chat(chat)" href.prevent=""><img class="rounded-circle" :src="chat['avatar']" alt=""></a>
                </div>
            </div>
            <div v-if="is_select" class="col-sm-12">
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
                is_select:false,
                chats:[],
                chat_id:'',
                chat_user:'',
                datas:'',
                messages:[],
                textMessage:''
            }
        },
        mounted() {
            this.get_all_chat();
            this.get_axios();
        },
        methods:{
            get_axios:function(){
                axios({
                    method:'post',
                    url:'/get_id',
                })
                .then((response)=>{
                    // console.log(response.data);
                    this.user_id = response.data;
                    console.log('chats.'+this.chat_id+'.'+this.user_id);
                    var socket = io('http://localhost:3000');
                    socket.on('chats.'+this.chat_id+'.'+this.user_id, function (data) {
                        console.log('lol'+data.message);
                        this.messages.push(data.message);
                    }.bind(this));
                });
            },
            get_all_chat:function () {
                axios({
                    method:'post',
                    url:'/get_chats',
                })
                .then((response)=>{
                     this.chats = response.data;
                })
            },
            open_chat:function(chat){
                this.get_axios();
                this.messages = [];
                this.is_select = true;
                this.chat_id = chat['chat_id'];
                this.chat_user = chat['user_id'];
            },
            sendMessage: function () {
                console.log("here"+this.textMessage);
                this.messages.push(this.textMessage);
                axios({
                    method:'post',
                    url:'/message',
                    params: {
                        message:this.textMessage,
                        channels:'chats.'+this.chat_id+'.'+this.chat_user,
                        chat: this.chat_id
                    }
                })
                .then((response)=>{
                    console.log(response.data);
                    this.textMessage = '';
                });
            }
        }
    }
</script>

<style scoped>
    .photo {
        display: flex;
        width: 100%;
    }
    .photo img {
        width: 5rem;
    }

    .container {
        margin: 3rem auto;
    }


</style>