<template>
    <div class="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">

                <div class="tab" role="tabpanel">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" :class="is_login? 'active':''"><a @click="is_login = true" href="" aria-controls="home" role="tab" data-toggle="tab">Вхід</a></li>
                        <li role="presentation" :class="!is_login? 'active':''"><a @click="is_login = false" href="" aria-controls="profile" role="tab" data-toggle="tab">Реєстрація</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabs">
                       <login v-if="is_login"></login>
                       <register v-if="!is_login"></register>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AuthComponent",
        data: function () {
            return{
                urldata:[],
                is_login: true,
                id:0
            }
        },
        methods:{
            change_login:function () {
                this.is_login = false;
            },
            change_register:function () {
                this.is_login = false;
            }
        }
    }
</script>

<style scoped>

</style>