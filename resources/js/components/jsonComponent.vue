<template>
    <div>
        <button @click="update" v-if="!is_refresh">Обновить - {{id}}</button>
        <span v-if="is_refresh">загрузка</span>
        <table>
            <tr v-for="urk in urldata">
                <td>{{urk.title}}</td>
                <td>{{urk.url}}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        data: function(){
            return{
                urldata:[],
                is_refresh: false,
                id:0
            }
        },
        name: "ajax.vue",
        mounted(){
            this.update()
        },
        methods:{
            update:function () {
                axios.get('/json',).then((response) =>{
                    console.log(response);
                    this.urldata = response.data;
                    this.is_refresh = false;
                    this.id++;
                })
            }
        }
    }
</script>


