<template>
    
    <div class="card">
        <div class="card-body">
            <div class="breadcrumb-header justify-content-between align-items-center mb-3 mt-0" >
                <div class="d-flex">
                    <h4 class="card-title text-muted mb-0 my-auto">Annual Leave of {{ year }} </h4>
                </div>
                <div class="d-flex my-xl-auto right-content align-items-center">
                    <div class="wd-xl-200 wd-lg-200 wd-md-200 wd-100p me-1">
                        <Multiselect class="multi-color" v-model="depts" mode="multiple" placeholder="Departments..." :close-on-select="false" :searchable="false" :searchStart="true" :options="lkDept" @select="getAlInfo()"/>
                    </div>
                    <div class="dropdown">
                        <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-primary dropdown-toggle-split" style="width: 75px; height: 39.5px" data-bs-toggle="dropdown" id="dropdownMenuButton" type="button">{{ year }}<i class="fas fa-caret-down ms-2"></i></button>
                        <div class="dropdown-menu dropdown-menu-right overflow-auto" aria-labelledby="dropdownMenuDate" x-placement="bottom-end" style="height: 210px">
                            <a class="dropdown-item" v-for="lst in lkYear" :key="lst.value" @click="yearChange(lst.value)">                            
                                {{ lst.value }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>  

            <div class="table-responsive bd-t-1 ht-md-700">
                <table class="table main-table-reference text-nowrap mb-0 table-hover">
                    <thead class="position-sticky" style="top: -1px">
                        <tr>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Name Eng</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Name Lao</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Position</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Department</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">{{ year - 1 }} Remain</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">{{ year }} Get</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">{{ year }} Use</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">{{ year }} Remain</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px; width: 80%" class="fw-bold">Remarks</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr v-for="lst in alInfo" :key="lst.id">
                            <td style="padding: 3px 10px">{{ lst.title }} {{ lst.name }} {{ lst.surname }}</td>
                            <td style="padding: 3px 10px" class="laofont"> <span v-if="lst.namelao">{{ lst.titlelao }}</span> {{ lst.namelao }} {{ lst.surnamelao }}</td>
                            <td style="padding: 3px 10px"> {{ lst.position }} </td>
                            <td style="padding: 3px 10px"> {{ lst.department }} </td>
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
            lkDept: [],
            alInfo: [],
            depts: [],
            year: new Date().getFullYear(),
            search: '',
            btnClear: false
        };
    },

    mounted() {
        
    },

    methods: {
        yearChange(value){
            this.year = value;
            this.getAlInfo();
        },

        async getAlInfo(){
            let fd = new FormData();
                fd.append('dept', this.depts.toString());
                fd.append('yyyy', this.year);

            const res = await axios.post('/api/annual/info', fd, {headers:{"Content-Type": "multipart/form-date"}})
            this.alInfo = res.data;
        },

        async lookup(){
            const year = await axios.get('/api/lookup/year')
            this.lkYear = year.data;

            const depts = await axios.get('/api/lookup/depts')
            this.lkDept = depts.data;  
        },

        formatNumber(value) {
			let val = (value / 1).toFixed(2).replace(",", ".");
			return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		},
        
    },

    created(){
        this.lookup();
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