<template>
    <div>
        <h1>Display data from store</h1>
        <hr>

        <div>
           Store Name: {{ $store.getters.name }}
        </div>



        <input type="text" v-model="txtName">

        <button @click="testClick()">Test</button>

        <div>

            <router-link to="/">
                Home
            </router-link>
            

        </div>



    </div>
</template>

<script>
export default {
    name: 'XpplAppDisplay',

    data() {
        return {
            
            txtName:''


        };
    },

    mounted() {
        
    },

    methods: {
        testClick(){

            console.log("Resquest Name: " + this.txtName);
            this.$store.commit('setName', this.txtName);
        },


        // changeName:function(event){
        //     console.log(event.target.value);
        //     this.$store.commit('setName',event.target.value)

        // }
        
    },
};
</script>

<style lang="scss" scoped>

</style>