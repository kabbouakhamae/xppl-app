<template>
    <div class="card card-body">
        
        <div class="table-responsive mt-1" style="max-height: 700px">
            <table class="table main-table-reference text-nowrap table-hover cur-pointer" >
                <thead>
                    <tr>
                        <th style="letter-spacing: 0px; width: 50px">Key</th>
                        <th style="letter-spacing: 0px">Name</th>
                    </tr>
                </thead>
                <tbody> 
                    <tr v-for="(lst, key) in names" :key="lst.value" @click="rowSelected(key, lst.value)" :style="key == selectedRow ? 'background-color: #ecf0fa; border-left: 2px solid #0162e8' : ''" title="">
                        
                        <td style="padding: 4px 10px">{{ key + 1 }}</td>
                        <td style="border: none; padding: 4px 10px" :style="lst.value == '2023' ? 'background-color: green' : 
                                                              lst.value == '2022' || lst.value == '2026' ? 'background-color: red' : 
                                                              lst.value == '2024' ? 'background-color: pink' : 
                                                              lst.value == '2025' ||  lst.value == '2027' ? 'background-color: yellow' : 
                                                              lst.value == '2021' ? 'background-color: gray' : 
                                                              ''"
                        >{{ lst.value }}</td>

                    </tr>                                                
                </tbody>
            </table>
        </div>



        <div v-if="active">
            <h2>Hello World!</h2>
        </div>

        <div v-on:mouseover="active = !active">
            <h1>Hover me!</h1>
        </div>

    </div>
</template>

<script>
export default {
    name: 'XpplAppFuelReport',

    data() {
        return {
            ProxiesList: [{id:1, ProxyIP:1}, {id:2, ProxyIP:2}, {id:3, ProxyIP:3}, {id:4, ProxyIP:4}],
            
            names: [],
            selectedRow: null,
            userid: '',
            key: '',
            active: false
        };
    },

    mounted() {
        
    },

    methods: {
    
        setBg(id) {
            this.selectedRow = id
        },

         getYearLK(){
            this.$axios.get('/api/lookup/year').then((res) => {
                this.names = res.data;
            })
        },

        rowSelected(key, userid){
            this.selectedRow = key;
            this.userid = userid;
            this.key = key;
        },
    },

     created(){
        this.getYearLK();
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
    .dd{
        border-left: 2px blue;
    
    }
</style>