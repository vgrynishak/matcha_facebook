<template>
    <div >
        <div v-for="photo in photos">
            <a :href="'/user/'+photo['user_id']"><h1>{{photo['username']}}</h1></a>
            <img :src="photo['avatar']" alt="">
            <button type="button" :id="'likes.'+photo['user_id']" @click.prevent="like(photo['user_id'])" class="btn btn-outline-success">Like</button>
            <button type="button" @click.prevent="" class="btn btn-outline-danger">Unlike</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NewsComponent",
        props:[

        ],
        data: function(){
            return {
                page:1,
                photos:[]
            }
        },
        mounted() {
          this.get_photo();
        },
        methods: {
            get_photo:function () {
                axios({
                    method:'post',
                    url:'/get_news',
                    params: {
                        page: this.page
                    }
                })
                .then((response)=>{
                    this.photos = response.data;
                    // console.log(response.data);
                })
            },
            like:function (id) {
                // console.log(id);
                axios({
                    method:'post',
                    url:'/like',
                    params: {
                        channels: id
                    }
                })
                .then((response)=>{
                    // console.log("dfsdfsdfdsfsd");
                    console.log(response.data);
                })
            }
        }
    }
</script>

<style scoped>

</style>