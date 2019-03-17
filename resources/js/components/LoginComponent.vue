<template>
    <!--<div role="tabpanel" class="tab-pane fade in active" id="Section1">-->
    <div>
        <form class="form-horizontal">
            <div v-if="msg" class="alert alert-danger" role="alert">
                {{msg}}
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input v-model="newPerson.email" type="email" class="form-control" id="exampleInputEmail1">
                <!--<h1> {{username}}</h1>-->
            </div>
            <div class="form-group">
                <label for="Password1">Password</label>
                <input v-model="newPerson.password" type="password"  class="form-control" id="Password1">
            </div>
            <!--<div class="form-group">-->
                <!--<div class="main-checkbox">-->
                    <!--<input value="None" id="checkbox1" name="check" type="checkbox">-->
                    <!--<label for="checkbox1"></label>-->
                <!--</div>-->
                <!--<span class="text">Keep me Signed in</span>-->
            <!--</div>-->
            <div class="form-group">
                <button type="submit" @click.prevent="login" class="btn btn-default">Вхід</button>
            </div>
            <div class="form-group forgot-pass">
                <button type="submit" @click.prevent class="btn btn-default">Забули пароль?</button>
            </div>
        </form>
    </div>
    <!--</div>-->
</template>

<script>
    export default {
        name: "LoginComponent",
        data: function(){
            return {
                msg:'',
                newPerson: {
                    email: '',
                    password: ''
                }
            }
        },
        methods:{
            login: function () {
                if (this.checkForm(this.newPerson)) {
                    // this.checkError = false;
                    let personInfo = this.toFormData(this.newPerson);
                    const options = {
                        method: 'POST',
                        headers: {'content-type': 'application/form-data'},
                        data: personInfo,
                        url: '/login',
                    };
                    console.log(personInfo);

                    axios(options)
                        .then((response) => {
                            console.log(response.data);
                            if (response.data){
                                this.msg = response.data;
                                // this.delete();
                            }
                            else {
                                window.location.href = '/';
                            }
                        })
                        .catch(err => console.log(err));
                }
                else{
                    this.msg = 'You must fill in all the fields';
                    this.delete();
                }
            },
            delete:function(){
                var self = this;
                setTimeout(function () {
                    self.msg = '';
                }, 2000);
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

        }
    }
</script>

<style scoped>

</style>