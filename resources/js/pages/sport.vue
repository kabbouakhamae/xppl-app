<template>
    <div>
        <div class="card mt-4">
            <div class="card-body">
                <div class="col-xl-6">
                    <div class="form-group multi-color">
                        <label class="mb-0">Name</label> 
                        <Multiselect v-model="list.name" @select="nameChange()" placeholder="Select" searchable = true :options="nameList"/>
                    </div>
                </div>
                
                <div class="col-xl-6">
                    <div class="form-group">
                        <label class="mb-0">Lao name</label>
                        <input type="text" v-model="list.laoName" class="form-control noto-lao text-bold" placeholder="Lao name">
                    </div>
                </div>

                <!-- {{ deptList }} <br> -->
                {{ deptList }}
                {{ list.name }}



            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppSport',

    data() {
        return {
            nameList: [],
            deptList: '',
            list: {
                name: '',
                laoName: ''
            },

            
        };
    },

    mounted() {
        
    },

    methods: {
        getName(){
            this.$axios.get('api/nameList').then((result) => {
                this.nameList = result.data;
            }).catch((err) => {
                console.log(err);
            });
        },


        nameChange(){
             this.$axios.post('api/dept', this.list)
            .then((response)=>{
                this.deptList = response.data[0].name_lao;
                this.list.laoName = response.data[0].name_lao;
            })
        },
        
    },

    created(){
        this.getName();
    },
};
</script>

<style src="@vueform/multiselect/themes/default.css">

</style>