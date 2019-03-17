<template>
    <div class="side">
        <div class="my_modal" v-if="msg">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" @click.prevent="msg=''" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{msg}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" @click.prevent="msg=''" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div><a href="/">Моя стоінка</a></div>
        <div><a href="/news">Знайомства</a></div>
        <div><a href="/chats">Повідомлення</a></div>
        <div><a href="/">Налаштування</a></div>
    </div>
</template>

<script>
    export default {
        name: "MenuComponent",
        data:function(){
              return {
                  msg:'',
                  user_id:''
              }
        },
        props:[
        ],
        // created: function () {
        //     console.log('createe');
        //     axios({
        //         method:'post',
        //         url:'/get_id',
        //     })
        //     .then((response)=>{
        //         console.log(response.data);
        //         this.user_id = response.data;
        //         console.log(this.user_id);
        //         //this.textMessage = '';
        //     });
        //    console.log('-----');
        // },
        // beforeMount(){
        //     console.log('before');
        //     axios({
        //         method:'post',
        //         url:'/get_id',
        //     })
        //     .then((response)=>{
        //         console.log('heredfdf');
        //          console.log(response.data);
        //         this.user_id = response.data;
        //         // console.log(this.user_id);
        //         //this.textMessage = '';
        //     });
        //     console.log(this.user_id);
        //     console.log('-------------');
        // },
        mounted() {
             this.get_user_id();
             // this.socket();
        },
        methods:{
            get_user_id:function () {
                axios({
                    method:'post',
                    url:'/get_id',
                })
                .then((response)=>{
                    // console.log(response.data);
                    this.user_id = response.data;
                    var socket = io('http://localhost:3000');
                    socket.on('like.'+this.user_id, function (data) {
                        this.msg = data.message;
                    }.bind(this));
                    // console.log('Ok');
                    // console.log(this.user_id);
                    //this.textMessage = '';
                })
            },
        }
    }
</script>

<style scoped>
    .side {
        background: #dddddd;
        width: 14rem;
        text-align: left;
        padding-left: 2rem;
        padding-top: 2rem;
    }

    .my_modal{
        position: absolute;
        margin: 9rem auto;
        width: 100%;
    }
</style>