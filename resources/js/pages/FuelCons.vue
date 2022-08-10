<template>
    <div class="card">
        <div class="card-body">
            <div class="breadcrumb-header justify-content-between mb-2 mt-0" >
                <div class="d-flex">
                    <h4 class="card-title text-muted mb-0 my-auto">Fuel consumption of {{ mont }}, {{ year }}</h4>
                </div>
                <div class="d-flex my-xl-auto right-content">
                    <div class="dropdown btn-group" role="group">
                        <button aria-expanded="false" class="btn btn-primary dropdown-toggle-split" style="height: 39.5px" data-bs-toggle="dropdown" id="dropdownMenuButton1" type="button">{{ mont }}<i class="fas fa-caret-down ms-2"></i></button>
                        <div class="dropdown-menu dropdown-menu-right overflow-auto cur-pointer" aria-labelledby="dropdownMenuDate1" x-placement="bottom-end" style="height: 210px">
                            <a class="dropdown-item" v-for="lst in lkMont" :key="lst.value" @click="montChange(lst.value)">                            
                                {{ lst.value }}
                            </a>
                        </div>

                        <button aria-expanded="false" class="btn btn-primary dropdown-toggle-split rounded-right" style="height: 39.5px" data-bs-toggle="dropdown" id="dropdownMenuButton2" type="button">{{ year }}<i class="fas fa-caret-down ms-2"></i></button>
                        <div class="dropdown-menu dropdown-menu-right overflow-auto cur-pointer" aria-labelledby="dropdownMenuDate2" x-placement="bottom-end" style="height: 210px">
                            <a class="dropdown-item" v-for="lst in lkYear" :key="lst.value" @click="yearChange(lst.value)">                            
                                {{ lst.value }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-3">
                    <div class="table-responsive border" style="height: 250px">
                        <table class="table main-table-reference text-nowrap table-hover cur-pointer">
                            <thead class="position-sticky" style="top: -1px">
                                <tr>
                                    <th style="letter-spacing: 0px; padding: 5px 10px; height: 27.08px" class="fw-bold pd-y-5">Date</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <tr v-for="(lst, key) in dateData" :key="lst.id" @click="selectedDate(key, lst.rdate)" :style="key === selDateRow ? 'background-color: #ecf0fa; border-left: 1px solid #0162e8; color: blue' : ''">
                                    <td style="border: none; padding: 4px 10px">{{ dateTime(lst.rdate) }}</td>
                                </tr>                                                                                            
                            </tbody>
                        </table>
                    </div>            
                </div>
                
                <div class="col-xl-10 col-lg-9 col-md-8 col-sm-9 ps-sm-0 pt-sm-0 pt-3 ">
                    <div class="table-responsive border" style="height: 250px">
                        <table class="table main-table-reference text-nowrap table-hover cur-pointer" >
                            <thead class="position-sticky" style="top: -1px">
                                <tr>
                                    <th style="letter-spacing: 0px; padding: 5px 10px">Date</th>
                                    <th style="letter-spacing: 0px; padding: 5px 10px">Department</th>
                                    <th style="letter-spacing: 0px; padding: 5px 10px">Department Use</th>
                                    <th style="letter-spacing: 0px; padding: 5px 10px">Cost Type</th>
                                    <th style="letter-spacing: 0px; padding: 5px 10px">Cost No</th>
                                    <th style="letter-spacing: 0px; padding: 5px 10px; width: 80%">Work Location</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <tr v-for="(lst, key) in headData" :key="lst.id" @click="selectedHead(key, lst.id)" :style="key === selHeadRow ? 'background-color: #ecf0fa; border-left: 1px solid #0162e8; color: blue' : ''">
                                    <td style="border-start: none; padding: 3px 10px">{{ lst.rdate }}</td>
                                    <td style="border-start: none; padding: 3px 10px">{{ lst.dept }}</td>
                                    <td style="border-start: none; padding: 3px 10px">{{ lst.deptuse }}</td>
                                    <td style="border-start: none; padding: 3px 10px">{{ lst.costtype }}</td>
                                    <td style="border-start: none; padding: 3px 10px">{{ lst.costno }}</td>
                                    <td style="border-start: none; padding: 3px 10px">{{ lst.worklocation }}</td>
                                </tr>                                                                                            
                            </tbody>
                        </table>
                    </div>    
                </div>

            </div>

            <div class="table-responsive border mt-3" style="height: 450px">
                <table class="table main-table-reference text-nowrap table-hover">
                    <thead class="position-sticky" style="top: -1px">
                        <tr>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Date</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Date</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Date</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Date</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px; width: 80%">Date</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr v-for="(lst, key) in dateData" :key="lst.rdate" @click="permissEdit(key, lst.rdate)">
                            <td style="padding: 3px 10px">{{ lst.rdate }}</td>
                            <td style="padding: 3px 10px">{{ lst.rdate }}</td>
                            <td style="padding: 3px 10px">{{ lst.rdate }}</td>
                            <td style="padding: 3px 10px">{{ lst.rdate }}</td>
                            <td style="padding: 3px 10px">{{ lst.rdate }}</td>
                        </tr>                                                                                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppFuelCons',

    data() {
        return {
            lkYear: [],
            lkMont: [],
            dateData: [],
            headData: [],

            year: new Date().getFullYear(),
            mont: new Date().toLocaleString('en-us', { month: 'long' }),
            selDateRow: null,
            selHeadRow: null
        };
    },

    mounted() {
        
    },

    methods: {
        selectedDate(key, date){
            this.selDateRow = key;

            this.$axios.post('/api/fuel/head', {
                date: date
            }).then(res =>{
                this.headData = res.data;
            })

        },

        selectedHead(key, id){
            this.selHeadRow = key;
        },

        async getDate(){
            const res = await axios.post('/api/fuel/date', {
                mont: this.mont,
                year: this.year
            })

            this.dateData = res.data;
            console.log("Max", this.dateData.length);
            console.log("Data:", res.data);
            
  
        },

        getYearLK(){
            this.$axios.get('/api/lookup/year')
            .then(res => this.lkYear = res.data)
        },

        getMontLK(){
            this.$axios.get('/api/lookup/month')
            .then(res => this.lkMont = res.data)
        },

        yearChange(value){
            this.year = value;
            this.getDate();
        },

        montChange(value){
            this.mont = value;
            this.getDate();

           
            this.selectedDate(this.dateData.length, this.dateData.length);
        },

        dateTime(value) {
            if(value) {
                return moment(value).format('DD-MM-YYYY');
            }
        }
    },

    created(){
        this.getYearLK();
        this.getMontLK();
        this.getDate();
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
    .tt{
        color: rgb(135, 164, 226);
    }
</style>