<template>
    <div v-if="loading">
        <loading/>
    </div> 
    <div v-else>
        <div class="card">
            <div class="card-body pd-t-10">
                <h4 class="card-title mg-b-0 text-muted text-capitalize">{{dept}} Annual Leave Infomation In <span class="text-danger">{{year}}</span></h4>
                <div class="d-lg-flex justify-content-between mt-2 mb-1">
                    <div class="wd-lg-300 wd-100p">
                        <div class="pos-relative">
                            <input class="form-control form-control-sm pd-l-25 box-height" type="text" placeholder="Search by name..." v-model="search" @input="searchChanged()" title="Search by name">
                                <i class="fe fe-search search-ism text-muted"></i>
                            <button class="btn btn-icon btn-sm search-csm text-muted" v-if="btnClear" @click="searchClear()"><i class="fe fe-x" style="font-size: 14px"></i></button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-xl-0 mt-lg-0 mt-md-1 mt-1">
                        <div class="wd-lg-200 wd-md-200 wd-100p me-1">
                            <Multiselect class="multi-color box-height" v-model="dept" placeholder="Departments..." :searchable="false" :searchStart="true" :options="lkDept" @select="selChanged()"/>
                        </div>
                        <div class="wd-md-120 wd-60p">
                            <Multiselect class="multi-color box-height" v-model="year" placeholder="Year..." :searchable="false" :searchStart="true" :options="lkYear" @select="selChanged()"/>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive border" style="max-height: 75vh">
                    <table class="table main-table-reference text-nowrap mg-b-0" id="al" data-excel-name="Annual Leave Info">
                        <thead class="position-sticky" style="top: 0px">
                            <tr>
                                <th class="border-start-0">No</th>
                                <th>Name and Surname</th>
                                <th>Name Lao</th>
                                <th>Position</th>
                                <th>{{ year - 1 }} Remain</th>
                                <th>{{ year }} Get</th>
                                <th>{{ year }} Use</th>
                                <th>{{ year }} Remain</th>
                                <th class="wd-60p">Remarks</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr v-for="(lst, inx) in infoData" :key="lst.id" class="tr-hover">
                                <td class="text-center border-start-0">{{inx + 1}}</td>
                                <td>{{ lst.title }} {{ lst.name }} {{ lst.surname }}</td>
                                <td class="laofont"> <span v-if="lst.namelao">{{ lst.titlelao }}</span> {{ lst.namelao }} {{ lst.surnamelao }}</td>
                                <td> {{ lst.position }} </td>
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
            infoData: [],
            dept: [],
            year: '',
            search: '',
            btnClear: false,
            loading: false
        };
    },

    mounted() {
        
    },

    methods: {
        async onLoad(){
            this.loading = true;

            const profile = await axios.get('api/profile')
			this.dept = profile.data.department;
            this.year = new Date().getFullYear();

            const info = await axios.get(`/api/annual/info?dept=${this.dept}&year=${this.year}&search=${this.search}`)
            this.infoData = info.data;

            const dept = await axios.get('/api/lookup/depts')
            this.lkDept = dept.data;

            const year = await axios.get('/api/lookup/year')
            this.lkYear = year.data;

            this.loading = false; 
        },

        // async getAlInfo(){
        //     this.loading = true;
        //     let fd = new FormData();
        //         fd.append('dept', this.dept.toString());
        //         fd.append('yyyy', this.year);

        //     const res = await axios.post('/api/annual/info', fd, {headers:{"Content-Type": "multipart/form-date"}})
        //     this.alInfo = res.data;
        //     this.loading = false;
        // },

        async selChanged(){
            this.loading = true;

            const info = await axios.get(`/api/annual/info?dept=${this.dept}&year=${this.year}&search=${this.search}`)
            this.infoData = info.data;

            this.loading = false; 
        },

        getAlInfo(){
            this.$axios.get(`/api/annual/info?dept=${this.dept}&year=${this.year}&search=${this.search}`)
            .then(res => this.infoData = res.data)
        },

        searchChanged(){
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
            this.btnClear = false;
            this.getAlInfo();
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
        this.onLoad();
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