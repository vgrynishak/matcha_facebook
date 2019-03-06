<template>
    <div>
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
        props: {
            urldata:{
                type: Array
            }
            // mydata:{
            //   type: text
            // }
        },
        name: "index.vue",
        mounted(){
            this.update()
        },
        methods:{
            update:function () {
                console.log(this.urldata);
            }
        }
    }
</script>


