<template>
    
    <div class="card">
        <div class="card-body">
            <div class="breadcrumb-header justify-content-between align-items-center mb-3 mt-0" >
                <div class="d-flex">
                    <h4 class="card-title text-muted mb-0 my-auto">Annual Leave of {{ year }} </h4>
                </div>
                <div class="d-flex my-xl-auto right-content">
                    <div class="pos-relative me-1" style="width: 100%">
                        <input class="form-control pd-l-30" type="text" placeholder="Search by name..." v-model="search" @input="searchChange()" >
                        <i class="fe fe-search search-i text-muted"></i>
                        <button class="btn btn-icon btn-sm search-c text-muted" v-if="btnClear" @click="searchClear()"><i class="fe fe-x"></i></button>
                    </div>
                    <div class="dropdown">
                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle-split" style="width: 67px; height: 39.5px" data-bs-toggle="dropdown" id="dropdownMenuButton" type="button">{{ year }}<i class="fas fa-caret-down ms-2"></i></button>
                        <div class="dropdown-menu dropdown-menu-right overflow-auto" aria-labelledby="dropdownMenuDate" x-placement="bottom-end" style="height: 210px">
                            <a class="dropdown-item" v-for="lst in lkYear" :key="lst.value" @click="yearChange(lst.value)">                            
                                {{ lst.value }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive" style="">
                <table class="table main-table-reference text-nowrap mb-0 table-hover">
                    <thead>
                        <tr>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Name Eng</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Name Lao</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Position</th>
                            <th v-if="!!parseInt(loginPermiss.al_all)" style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Department</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">{{ year - 1 }} Remain</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">{{ year }} Get</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">{{ year }} Use</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">{{ year }} Remain</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px; width: 80%" class="fw-bold">Remarks</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr v-for="lst in alInfo.data" :key="lst.id">
                            <td style="padding: 3px 10px">{{ lst.title }} {{ lst.name }} {{ lst.surname }}</td>
                            <td style="padding: 3px 10px" class="laofont"> <span v-if="lst.namelao">{{ lst.titlelao }}</span> {{ lst.namelao }} {{ lst.surnamelao }}</td>
                            <td style="padding: 3px 10px"> {{ lst.position }} </td>
                            <td v-if="!!parseInt(loginPermiss.al_all)" style="padding: 3px 10px"> {{ lst.department }} </td>
                            <td style="padding: 3px 10px" class="text-end"> {{ formatNumber(lst.remain) }} </td>
                            <td style="padding: 3px 10px" class="text-end"> {{ formatNumber(lst.get) }} </td>
                            <td style="padding: 3px 10px" class="text-end"> {{ formatNumber(lst.use) }} </td>
                            <td v-if="lst.total < 0" style="padding: 3px 10px" class="text-end bg-danger">{{ formatNumber(lst.total) }}</td>
                            <td v-else style="padding: 3px 10px" class="text-end"> {{ formatNumber(lst.total) }} </td>
                            <td style="padding: 3px 10px" class="laofont"> {{ lst.remarks }} </td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            <pagination :pagination="alInfo" @paginate="getAlInfo($event)" :offset="2"></pagination>
        </div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppAnnualLeave',

    data() {
        return {
            loginPermiss: [],
            lkYear: [],
            alInfo: [],
            year: new Date().getFullYear(),
            search: '',
            btnClear: false
        };
    },

    mounted() {
        
    },

    methods: {
         getYearLK(){
            this.$axios.get('/api/lookup/year').then((res) => {
                this.lkYear = res.data;
            })
        },

        yearChange(value){
            this.year = value;
            this.search = '';
            this.btnClear = false;
            this.getAlInfo();
        },

        async getAlInfo(page){
            const res = await axios.get(`/api/annual/info?page=${page}&search=${this.search}&year=${this.year}`)
            .then(res => { 
                this.alInfo = res.data;
            })
        },

        searchChange(){
            if(this.search.length >0){
                this.btnClear = true;
                this.getAlInfo();
            } else {
                this.btnClear = false;
                this.getAlInfo();
            }
        },

        searchClear(){
            this.search = '';
            this.btnClear = false,
            this.getAlInfo();
        },

        async getPermiss(){
            const response = await axios.get('/api/permiss')
            this.loginPermiss = response.data;
        },

        formatNumber(value) {
			let val = (value / 1).toFixed(2).replace(",", ".");
			return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		},
        
    },

    created(){
        this.getPermiss();
        this.getYearLK();
        this.getAlInfo();
    },

    beforeRouteEnter(to, from, next){
        if(!window.Laravel.isLoggedin_laravel){
            window.location.href = "/signin";
        }
        next();
	},
};
</script>

<style lang="scss" scoped>

</style>