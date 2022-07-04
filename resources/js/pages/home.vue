<template>
    <div class="card-header">
        <h1>Page: Home</h1>
        <hr>
        
        <div>
            Signin Name:   {{ $store.getters.name }} <br>
            Signin Dept:   {{ $store.getters.dept }} <br>
            Signin Usertype:   {{ $store.getters.usertype }} 
        </div>

        <hr>
        <div>
            <button>Preview</button>
            <button class="mx-1" v-if="edt">Edit</button>
            <button v-if="del">Delete</button>

        </div>

        <hr>
        <div class="my-1">
            <button @click="fncSignout()">Sign out</button>
        </div>
        





        <router-link to="/display">
            Display
        </router-link>
        <br>
        <router-link to="/employee">
            Employee
        </router-link>
        <br>
            




        {{ loginUser }}
        <br>
        {{ loginUser.department }} <br>
        {{ loginUser.name }} <br>
        {{ loginUser.usertype }} 




    </div>
</template>

<script>
export default {
    name: 'XpplAppHome',

    data() {
        return {
            loginUser: [],
            edt: false,
            del: false,

            level:'full'
        };
    },

    mounted() {
        
    },

    methods: {
        
        mode(){

            
            if(this.$store.getters.usertype == 'admin'){
                console.log(this.level);
                this.edt = true;
            } else {

                if(this.$store.getters.usertype == 'full'){
                    this.edt= true;
                    this.del= true;
                }


                console.log(this.$store.getters.usertype);
            }
        },




        fncSignout(){
            this.$axios.post("api/signout").then((response) => {
                if(response.data.success){
                    window.location.href = "/" // ໄປໜ້າທຳອິດ
                } else {
                    console.log(response.data.message);
                }
            }).cath(function(error){
                console.error(error);
            });
         },
        

    },

    created(){

        //  console.log(window.Laravel.user.username);
        //  this.loginUser = window.Laravel.user
         this.$store.commit('setName', window.Laravel.user.username)
         this.$store.commit('setDept', window.Laravel.user.department)
         this.$store.commit('setUsertype', window.Laravel.user.usertype)

        this.mode()
    },

    beforeRouteEnter(to, from, next){
        if(!window.Laravel.isLoggedin_laravel){
            window.location.href = "/signin";
        }

        next();
	}
};
</script>

<style lang="scss" scoped>

</style>