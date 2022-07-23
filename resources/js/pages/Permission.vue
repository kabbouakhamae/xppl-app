<template>
    <div>
        <!-- <div v-if="logingPer == 'true'" class="card mt-4"> -->
        <div class="card mt-4">
            <div class="card-body">
                <!-- <div class="row">
                    <div class="col-xxl-3">
                        aa
                    </div>
                    <div class="col-xxl-9">
                        bb
                    </div>


                </div> -->

                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="permission"  v-model="permiss" @change='$emit("input", $event.target.checked)'>
                    <label class="custom-control-label cur-pointer" for="permission">Permission</label>
                </div>

                <div v-if="permiss == 'true' || permiss == true">
                    <div class="custom-control custom-switch mt-2 ms-4">
                        <input type="checkbox" class="custom-control-input" id="permission1"  @change='$emit("input", $event.target.checked)'>
                        <label class="custom-control-label cur-pointer" for="permission1">Edit</label>
                    </div>
                    <div class="custom-control custom-switch mt-1 ms-4">
                        <input type="checkbox" class="custom-control-input" id="permission2"   @change='$emit("input", $event.target.checked)'>
                        <label class="custom-control-label cur-pointer" for="permission2">Delete</label>
                    </div>
                </div>

                <div class="custom-control custom-switch mt-4">
                    <input type="checkbox" class="custom-control-input" id="she"  v-model="she" @change='$emit("input", $event.target.checked)'>
                    <label class="custom-control-label cur-pointer" for="she">SHE</label>
                </div>
                {{ she }}
                <button class="mt-4" @click="update">Update</button>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppPermission',

    data() {
        return {
            permiss: ''
            ,logingPer: ''
            ,she: ''
        };
    },

    mounted() {
        
    },

    methods: {
        getPermiss(){
            this.$axios.post('/api/profile')
            .then(res =>{
                
                this.permiss = Boolean(res.data[0].permiss);
                this.logingPer = Boolean(res.data[0].permiss);
                this.she = Boolean(res.data[0].she);

                // console.log("--->", res.data);
                // console.log("To string:", Boolean(res.data.she)); 
                // console.log("To string:", !!parseInt(res.data.she)); 

            })
        },

        update(){
            this.$axios.post('api/updatePermiss',{
                permiss: this.permiss,
                she: this.she
            })
            .then(res =>{
                this.getPermiss();
                window.location.reload();
            })
        }
    },

    created(){
        this.getPermiss();
    },

     beforeRouteEnter(to, from, next){
        if(!window.Laravel.isLoggedin_laravel){
            window.location.href = "/signin";
       }
        next();
	},
};
</script>

<style>

</style>