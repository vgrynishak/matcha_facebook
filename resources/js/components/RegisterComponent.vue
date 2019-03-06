<template>
    <!--<div role="tabpanel" class="tab-pane fade" id="Section2">-->
    <div>
        <form class="form-horizontal">
            <div v-if="msg_error" class="alert alert-danger" role="alert">
                {{msg_error}}
            </div>
            <div v-if="msg_nice" class="alert alert-success" role="alert">
                {{msg_nice}}
            </div>
            <div class="form-group">
                <label :class="error_name?'red':''" for="exampleInputEmail">First Name {{error_name}}</label>
                <input v-model="newPerson.username" type="text" class="form-control" id="exampleInputEmail">
            </div>
            <div class="form-group">
                <label :class="error_lastname?'red':''" for="exampleInputEmail12">Last Name {{error_lastname}}</label>
                <input v-model="newPerson.lastname" type="text" class="form-control" id="exampleInputEmail12">
            </div>
            <div class="form-group">
                <label :class="error_email?'red':''" for="exampleInputEmail13">Email address {{error_email}}</label>
                <input v-model="newPerson.email" type="email" class="form-control" id="exampleInputEmail13">
            </div>
            <div class="form-group">
                <label :class="error_pas?'red':''" for="exampleInputPassword1">Password {{error_pas}}</label>
                <input v-model="newPerson.password" type="password" class="form-control" id="exampleInputPassword1">
            </div>
            <div class="form-group">
                <label :class="error_pas?'red':''" for="exampleInputPassword12">Password Confirm</label>
                <input v-model="newPerson.confirm_pas" type="password" class="form-control" id="exampleInputPassword12">
            </div>
            <div class="form-group">
                <button type="submit" @click.prevent="register" class="btn btn-default">Реєстрація</button>
            </div>
        </form>
    </div>
    <!--</div>-->
</template>

<script>
    export default {
        name: "RegisterComponent",
        data:function () {
            return{
                error_name:'',
                error_pas:'',
                error_lastname:'',
                error_email:'',
                msg_error:'',
                msg_nice:'',
                newPerson: {
                    username: '',
                    lastname: '',
                    password: '',
                    confirm_pas: '',
                    email: ''
                }
            }
        },
        methods:{
            register: function () {
                if (this.checkForm(this.newPerson)) {
                    let personInfo = this.toFormData(this.newPerson);
                    const options = {
                        method: 'POST',
                        headers: {'content-type': 'application/form-data'},
                        data: personInfo,
                        url: '/register',
                    };
                    axios(options)
                        .then((response) => {
                            if (response.data){
                                console.log(response.data);
                                this.error_msg(response.data);
                            }
                            else {
                                this.all_nice();
                                this.msg_nice = "Для успішної реєстріція перейдіть на вашу пошту і підтвердіть ваш акаунт";
                                this.delete();
                            }
                        })
                        .catch(err => console.log(err));
                }
                else{
                    this.msg_error = "Заповніть всі поля форми";
                    this.delete(this.msg_error);
                }
            },
            delete:function(){
                var self = this;
                setTimeout(function () {
                    self.msg_error = '';
                    self.msg_nice = '';
                }, 3000);
            },
            toFormData: function (obj) {
                let formData = new FormData();
                for (let key in obj){
                    formData.append(key, obj[key]);
                }
                return formData;
            },
            checkForm: function (obj) {
                for(let key in obj){
                    if (!obj[key])
                        return false;
                }
                return true;
            },
            error_msg:function (msg) {
                this.error_name = msg["username"];
                this.error_lastname = msg["lastname"];
                this.error_email = msg["email"];
                this.error_pas = msg["pas"];
            },
            all_nice:function (msg) {
                this.error_name = '';
                this.error_lastname = '';
                this.error_email = '';
                this.error_pas = '';
                this.newPerson.username = '';
                this.newPerson.lastname= '';
                this.newPerson.confirm_pas = '';
                this.newPerson.password = '';
                this.newPerson.email = '';
            }
        },
        computed:{
        }
    }
</script>

<style scoped>
    label.red {
        color: red!important;
    }
</style>