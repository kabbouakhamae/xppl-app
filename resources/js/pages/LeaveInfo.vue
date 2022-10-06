<template>
    <div v-if="loading">
        <loading/>
    </div> 
    <div v-else>
        <div class="card">
            <div class="card-body pd-t-10">
                <h4 class="card-title mg-b-0 text-muted text-capitalize">{{dept}} Day Leave Infomation In <span class="text-danger">{{year}}</span></h4>
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
                    <table class="table main-table-reference text-nowrap mg-b-0">
                        <thead class="position-sticky" style="top: 0px; z-index: 1">
                            <tr>
                                <th class="border-start-0">No</th>
                                <th class="position-sticky" style="left: -1px">Name and Surname</th>
                                <th>Position</th>
                                <th v-for="(col, colInx) in headerData" :key="colInx" class="text-center" :title="col.descr_eng">
                                    {{col.rcode}} 
                                </th>
                                <th class="wd-60p">Remarks</th>
                            </tr>
                        </thead>
                        <tbody class="tx-13">
                            <tr v-for="(row, rowInx) in infoData" :key="rowInx" @click="selectRow(rowInx, row.name)" class="tr-hover">
                                <td class="text-center border-start-0">{{rowInx + 1}}</td>
                                <td>{{row.fullname}}</td>
                                <td>{{row.position}}</td>
                                <td v-for="(col, colInx) in headerData" :key="colInx" class="text-end cur-pointer" title="Double click to see details"  
                                    
                                    @dblclick="detail(row.id, col.rcode, row.fullname)"
                                >
                                    {{row[col.rcode]}}
                                </td>
                                <th></th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Detail -->
        <div class="modal fade effect-scale" id="detail" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header pb-1 bd-b-0">
                        <h6 class="main-content-label text-capitalize">{{fullname}}</h6>
                        <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body pt-0">                                   
                        <div class="table-responsive border" style="max-height: 75vh">
                            <table class="table main-table-reference text-nowrap mg-b-0">
                                <thead class="position-sticky" style="top: 0px">
                                    <tr>
                                        <th>No</th>
                                        <th>Date</th>
                                        <th>Plan</th>
                                        <th>Actual</th>
                                        <th>Timesheet</th>
                                        <th class="wd-60p">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    <tr v-for="(lst, key) in detailData" :key="lst.rdate" class="tr-hover">
                                        <td class="py-0 text-center">{{ key + 1 }}</td>
                                        <td class="py-0 text-center">{{dateFormat(lst.rdate)}}</td>
                                        <td class="py-0 text-center">{{lst.pcode}}</td>
                                        <td class="py-0 text-center">{{lst.acode}}</td>
                                        <td class="py-0 text-center">{{lst.ref_code}}</td>
                                        <td class="py-0 laofont">{{lst.anote}}</td>
                                    </tr>                                                                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>                                              
        </div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppLeaveInfo',

    data() {
        return {
            lkDept: [],
            lkYear: [],
            infoData: [],
            detailData: [],
            headerData: [],

            dept: '',
            year: '',
            search: '',
            btnClear: false,
            loading: false,
            fullname: '',
        };
    },

    mounted() {
        
    },

    methods: {
        async onLoad(){
            this.loading = true;

            const profile = await axios.get('api/profile')
			this.dept = profile.data.department;

            const year = await axios.get('/api/lookup/year')
            this.lkYear = year.data;

            this.year = new Date().getFullYear();

            const header = await axios.get('/api/roster/leaveheader')
            this.headerData = header.data;

            const info = await axios.get(`/api/roster/leaveinfo?dept=${this.dept}&year=${this.year}&search=${this.search}`)
            this.infoData = info.data;

            const dept = await axios.get('/api/lookup/depts')
            this.lkDept = dept.data;

            this.loading = false;
        },

        async selChanged(){
            this.loading = true;

            const info = await axios.get(`/api/roster/leaveinfo?dept=${this.dept}&year=${this.year}&search=${this.search}`)
            this.infoData = info.data;
            
            this.loading = false; 
        },

        getLeaveInfo(){
            this.$axios.get(`/api/roster/leaveinfo?dept=${this.dept}&year=${this.year}&search=${this.search}`)
            .then(res => this.infoData = res.data)
        },

        searchChanged(){
            if(this.search.length >0){
                this.btnClear = true;
                this.getLeaveInfo();
            } else {
                this.btnClear = false;
                this.getLeaveInfo();
            }
        },

        searchClear(){
            this.search = '';
            this.btnClear = false;
            this.getLeaveInfo();
        },

        detail(id, code, name){
            this.fullname = name;
            $('#detail').modal('show');

            this.$axios.post('/api/roster/leavedetail', {
                userid: id,
                code: code,
                year: this.year
            }).then(res => {
                this.detailData = res.data;
            })
        },

        dateFormat(value){
            if (value) {
                return moment(value).format("DD-MM-YYYY");
            }
        },
    },

    created() {
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