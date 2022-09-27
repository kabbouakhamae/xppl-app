<template>
    <div v-if="loading">
        <loading/>
    </div> 
    <div v-else>
        <div class="breadcrumb-header justify-content-between align-items-center mb-1 mt-0" >
            <div>
                <h4 class="card-title mg-b-0">Annual Leave</h4>
                <p class="tx-12 tx-gray-500 mb-2">Annual leave Gets, Used and Reamining...</p>
            </div>
            <div class="d-flex my-xl-auto justify-content-end">
                <div class="wd-xl-200 wd-lg-200 wd-md-200 wd-70p">
                    <Multiselect class="multi-color" v-model="depts" mode="multiple" placeholder="Departments..." :close-on-select="false" :searchable="false" :searchStart="true" :options="lkDept" @select="getAlInfo()"/>
                </div>
                <div class="ms-1" style="width: 120px">
                    <Multiselect class="multi-color" placeholder="Year" :options="lkYear" v-model="year" @select="yearChange()"/>
                </div>
            </div>
        </div> 

        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h6 class="text-danger fw-bold">{{year}}</h6>
                    <div class="d-flex justify-content-start">
                        <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" data-bs-toggle="dropdown" title="Tools">
                            <i class="mdi mdi-dots-horizontal text-gray" style="font-size: 15px"></i>
                        </button> 
                        <div class="dropdown-menu tx-13">
                            <!-- <div class="dropdown-item cur-pointer dropdown-hover" @click="exportToPDF()">
                                <i class="far fa-file-pdf me-2"></i><span>Export To PDF</span>
                            </div> -->
                            <div class="dropdown-item cur-pointer dropdown-hover" @click="ExportExcel()">
                                <i class="far fa-file-excel me-2"></i><span>Export To Excel</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive element ht-md-650">
                    <table class="table main-table-reference text-nowrap table-hover" id="al" data-excel-name="Annual Leave Info">
                        <thead class="position-sticky" style="top: 0px">
                            <tr>
                                <th>Name and Surname</th>
                                <th>Name Lao</th>
                                <th>Position</th>
                                <th>Department</th>
                                <th>{{ year - 1 }} Remain</th>
                                <th>{{ year }} Get</th>
                                <th>{{ year }} Use</th>
                                <th>{{ year }} Remain</th>
                                <th class="p-0 align-middle wd-80p"><span class="d-flex justify-content-start text-white px-2">Remarks</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="lst in alInfo" :key="lst.id">
                                <td>{{ lst.title }} {{ lst.name }} {{ lst.surname }}</td>
                                <td class="laofont"> <span v-if="lst.namelao">{{ lst.titlelao }}</span> {{ lst.namelao }} {{ lst.surnamelao }}</td>
                                <td> {{ lst.position }} </td>
                                <td> {{ lst.department }} </td>
                                <td class="text-end"> {{ formatNumber(lst.remain) }} </td>
                                <td class="text-end"> {{ formatNumber(lst.get) }} </td>
                                <td class="text-end"> {{ formatNumber(lst.use) }} </td>
                                <td class="text-end bg-danger" v-if="lst.total < 0">{{ formatNumber(lst.total) }}</td>
                                <td class="text-end" v-else> {{ formatNumber(lst.total) }} </td>
                                <td class="laofont"> {{ lst.remarks }} </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
            loading: false
        };
    },

    mounted() {
        
    },

    methods: {
        yearChange(){
            this.getAlInfo();
        },

        async getAlInfo(){
            this.loading = true;
            let fd = new FormData();
                fd.append('dept', this.depts.toString());
                fd.append('yyyy', this.year);

            const res = await axios.post('/api/annual/info', fd, {headers:{"Content-Type": "multipart/form-date"}})
            this.alInfo = res.data;
            this.loading = false;
        },

        async getAlInfo2(){
            this.loading = true;
            const profile = await axios.get('api/profile')
			let loginDept = profile.data.department;

            let fd = new FormData();
                fd.append('dept', loginDept);
                fd.append('yyyy', this.year);

            const res = await axios.post('/api/annual/info', fd, {headers:{"Content-Type": "multipart/form-date"}})
            this.alInfo = res.data;
            this.loading = false;
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

        ExportExcel(){
            let table2excel = new Table2Excel();
            table2excel.export(document.querySelectorAll("#al"), "Annual Leave");
        },
        
    },

    created(){
        this.getAlInfo2();
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