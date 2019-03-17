<template>
    <div class="container">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Заповніть всі поля</h5>
            </div>
            <div v-if="error_msg" class="alert alert-danger" role="alert">
                {{error_msg}}
            </div>
            <div class="modal-body">
                <form id="contactForm" action="handler.php" method="post">
                    <div class="form-group">
                        <label for="name">Username:</label>
                        <input id="name" class="form-control" required type="text" v-model="Profile.username">
                    </div>
                    <div class="form-group">
                        <label for="lastname">Lastname:</label>
                        <input id="lastname" class="form-control"  required type="text" v-model="Profile.lastname"  >
                    </div>
                    <div class="form-group">
                        <label for="message"> you biography</label>
                        <textarea id="message" class="form-control" required name="message" v-model="Profile.biography" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="message1"> you intereces</label>
                        <textarea id="message1" class="form-control" required name="message" placeholder="#vegan, #Kyiv, #lesbi" v-model="Profile.intereses" rows="1"></textarea>
                    </div>
                    <span>Your gender: </span>
                    <input type="radio" id="one" value="Male" v-model="Profile.gender">
                    <label for="one">Male</label>
                    <input type="radio" id="two" value="Femail" v-model="Profile.gender">
                    <label for="two">Femail</label>
                    <br>
                    <span>Your preferences: </span>
                    <input type="radio" id="one1" value="Man" name="lol" v-model="Profile.preferences">
                    <label for="one1">Man</label>
                    <input type="radio" id="two2" value="Women" name="lol2" v-model="Profile.preferences">
                    <label for="two2">Woman</label>
                    <br>
                    <div class="download">
                        <input id="image" @change="addfile"  type="file" accept=".jpg, .jpeg, .png">
                        <canvas v-show="canvas" id="canvas" width="200" height="200"></canvas>
                    </div>
                    <button class="btn btn-success" type="submit" @click.prevent="send">Отправить</button>
                    <div class="result">
                        <span id="answer"></span>
                        <span id="loader" style="display:none"><img  alt=""></span>
                    </div>
                </form>
            </div>
    </div>
</template>

<script>
    export default {
        name: "ProfilComponent",
        data:function(){
            return {
                error_msg:'',
                canvas:false,
                Profile: {
                    username:'',
                    lastname:'',
                    gender:'',
                    preferences:'',
                    intereses:'',
                    biography:'',
                    avatar:''
                }
            }
        },
        props:[
            'urldata'
        ],
        mounted() {
            this.Profile.username = this.urldata[0]['username'];
            this.Profile.lastname = this.urldata[0]['lastname'];
        },
        methods:{
            send:function () {
                if (!this.checkForm(this.Profile)){
                    this.error_msg = "Вам обовязково потрібно заповнити всі поля форми і вибарти фотографію";
                    this.delete();
                }
                else{
                    let personInfo = this.toFormData(this.Profile);
                    const options = {
                        method: 'POST',
                        headers: {'content-type': 'application/form-data'},
                        data: personInfo,
                        url: '/profile',
                    };
                    axios(options)
                        .then((response) => {
                            window.location.href = "/";
                            // console.log(response.data);
                        })
                        .catch(err => console.log(err));
                }
            },
            addfile:function (e) {
                if (!e.target.files.length)
                    return ;
                this.canvas = true;
                let canvas  = document.getElementById('canvas');
                let url = URL.createObjectURL(e.target.files[0]);
                let img = new Image();
                let self = this;
                img.onload = function() {

                    let ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0,200,200);
                    let image = canvas.toDataURL('image.png');
                    self.Profile.avatar=image.replace('data:image/png;base64,', '');
                };
                img.src = url;
            },
            checkForm: function (obj) {
                for(let key in obj){
                    if (!obj[key])
                        return false;
                }
                return true;
            },
            delete:function(){
                var self = this;
                setTimeout(function () {
                    self.error_msg = '';
                }, 5000);
            },
            toFormData: function (obj) {
                let formData = new FormData();
                for (let key in obj){
                    formData.append(key, obj[key]);
                }
                return formData;
            },
        }
    }
</script>

<style scoped>
    .download{
        display: flex;
        flex-flow: column;
        width: 200px;
        margin-bottom: 10px;
    }
</style>