<template>
    <div class="container-fluid well span6">
        <div class="row-fluid">
            <div class="span2" >
                <img :src="data['avatar']" class="img-circle">
            </div>

            <div class="span8">
                <h6>Name: {{data['username']}}</h6>
                <h6>Lastname: {{data['lastname']}}</h6>
                <h6>Gender: {{data['gender']}}</h6>
                <h6>Preferance: {{data['preferance']}}</h6>
                <h6 v-if="is_more"> Intereses: {{data['interests']}}</h6>
                <h6 v-if="is_more">biography: {{data['biography']}}</h6>
                <button type="button" @click.prevent='show_info' class="btn btn-outline-info">{{msg}}</button>
                <!--<h6><a @click='show_info' href="">{{msg}}</a></h6>-->
            </div>
            <div v-if="!this.check" class="span2">
                <div class="btn-group">
                    <a class="btn dropdown-toggle btn-success" data-toggle="dropdown" href="#">
                        Action
                        <span class="icon-cog icon-white"></span><span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><span class="icon-wrench"></span> Modify</a></li>
                        <li><a href="#"><span class="icon-trash"></span> Delete</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MainComponent",
        props:[
            'data',
            'check'
        ],
        data:function () {
            return {
                is_more: false,
                msg:'More...'
            }
        },
        mounted() {
            console.log("vova"+this.check);
        },
        methods:{
            show_info:function ()  {
                this.is_more = !this.is_more;
                this.msg = (this.is_more)? 'Less...': 'More ...';
            },
        }
    }
</script>

<style scoped>
    .row-fluid {
        display: flex;
    }
    .btn-group {
        position: absolute;
        right: 0;
    }

    .span8 {
        margin-left: 3rem;
    }
</style>