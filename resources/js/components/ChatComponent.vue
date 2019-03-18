<template>
    <div class="container">
        <div v-if="!is_select">
            <div class="photo">
                <div v-for="chat in chats" v-if="!chat['lst_msg']">
                    <a @click="open_chat(chat)" href.prevent=""><img class="rounded-circle" :src="chat['avatar']" alt=""></a>
                </div>
            </div>
            <div class="chats">
                <div v-for="chat in chats" v-if="chat['lst_msg']">
                    <div class="chat">
                        <div><a  href.prevent=""><img class="rounded-circle" :src="chat['avatar']" alt=""></a></div>
                        <div @click="open_chat(chat)" class="chat-msg" >
                            <div class="header">
                                <div class="name"><b>{{chat['username']}}</b></div>
                                <div class="date">15:10</div>
                            </div>
                            <div class="msg">{{chat['lst_msg']}}</div>
                        </div>
                    </div>
                    <div class="line"><hr></div>
                </div>
            </div>
        </div>
        <div v-if="is_select" class="col-sm-12">
            <div class="msg-header">
                <a href="javascript:void(0);" @click="go_back()">Чати</a>
               <div>
                   {{select_chat['username']}}
                   <img class="rounded-circle" :src="select_chat['avatar']" alt="">
               </div>
            </div>
            <!--<textarea readonly rows="10" class="form-control">{{messages.join('\n')}}</textarea>-->
            <div>
                <div v-for="message in messages">
                    <div :class="put_class(message['user_id'])">{{message['message']}}</div>
                </div>
            </div>
            <hr>
            <input type="text" class="form-control" v-model="textMessage" @keyup.enter="sendMessage">
        </div>
    </div>
</template>

<script>
    export default {
        name: "ChatComponent",
        data:function () {
            return {
                is_select:false,
                select_chat:[],
                user_id:'',
                chats:[],
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
                    this.user_id = response.data;
                });
            },
            get_all_chat:function () {
                axios({
                    method:'post',
                    url:'/get_chats',
                })
                .then((response)=>{
                    // console.log('kkk');
                    // console.log(response.data);
                     this.chats = response.data;
                })
            },
            open_chat:function(chat){
                window.socket.removeListener('chats.'+this.select_chat['chat_id']+'.'+this.select_chat['user_id']);
                this.is_select = true;
                this.select_chat = chat;
                this.get_message();
                window.socket.on('chats.'+this.select_chat['chat_id']+'.'+this.select_chat['user_id'], (data) => {
                    let new_msg = {
                        message:data.message,
                        user_id:this.select_chat['user_id']
                    };
                    this.messages.push(new_msg);
                });
            },
            get_message:function(){
                axios({
                    method:'post',
                    url:'/get_messages',
                    params: {
                        chat: this.select_chat['chat_id']
                    }
                })
                .then((response)=>{
                     this.messages = response.data;
                         console.log(this.messages[0]);
                })
            },
            sendMessage: function () {
                console.log("here"+this.textMessage);
                let new_msg = {
                    message:this.textMessage,
                    user_id:this.user_id
                };
                this.messages.push(new_msg);
                console.log(this.messages);
                axios({
                    method:'post',
                    url:'/message',
                    params: {
                        message:this.textMessage,
                        channels:'chats.'+this.select_chat['chat_id']+'.'+this.user_id,
                        chat: this.select_chat['chat_id']
                    }
                })
                .then((response)=>{
                    // console.log(response.data);
                    this.textMessage = '';
                });
            },
            go_back: function () {
                // console.log('here_close');
                // window.socket.removeListener('chats.'+this.chat_id+'.'+this.user_id);
                this.is_select = false;
                this.messages = [];
            },
            put_class:function (id) {
                console.log(this.user_id);
                if (id == this.user_id)
                    return "right";
                else
                    return "left";
            }
        },
        computed:{

        }
    }
</script>

<style scoped>
    .photo {
        display: flex;
        width: 100%;
        margin-bottom: 2rem;
    }
    .photo img {
        width: 5rem;
    }

    .container {
        margin: 3rem auto;
    }

    .chats img {
        width: 3rem;
    }

    .chat {
        display: flex;
        margin-bottom: 1rem;
    }

    .msg {
        font-size: 0.7rem;
        font-family: monospace;
    }

    .chat-msg {
        display: flex;
        flex-direction: column;
        margin-left: 1rem;
        width: 100%;
    }

    .header {
        display: flex;
        justify-content: space-between;
    }

    .date {
        font-family: monospace;
    }

    .line {
        margin-left: 4rem;
    }
    .msg-header {
        display: flex;
        justify-content: space-between;
    }

    .msg-header img {
        width: 3rem;
    }

    .left {
        display: flex;
        justify-content: flex-end;
    }

    .right {
        display: flex;
        justify-content: flex-start;
        background-color: greenyellow;
    }
</style>