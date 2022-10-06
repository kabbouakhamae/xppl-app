<template>
    <div v-if="loading">
        <loading/>
    </div> 
    <div v-else>

        <div class="card">
            <div class="card-body pd-t-10">
                <h4 class="card-title mg-b-0 text-muted text-capitalize">{{dept}} Finger Scan on <span class="text-danger">{{mont(date)}} {{year(date)}}</span></h4>
                <div class="d-lg-flex justify-content-between mt-2 mb-1">
                    <div class="wd-lg-300 wd-100p">
                        <div class="pos-relative">
                            <input class="form-control form-control-sm pd-l-25 box-height" type="text" placeholder="Search by name..." v-model="search" @input="inputSearch()" @keyup.enter="searchChange()" title="Search by name">
                                <i class="fe fe-search search-ism text-muted"></i>
                            <button class="btn btn-icon btn-sm search-csm text-muted" v-if="btnClear" @click="searchClear()"><i class="fe fe-x" style="font-size: 14px"></i></button>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-xl-0 mt-lg-0 mt-md-1 mt-1">
                        <div class="wd-lg-200 wd-md-200 wd-100p me-1">
                            <Multiselect class="multi-color box-height" v-model="dept" placeholder="Departments..." :searchable="false" :searchStart="true" :options="lkDept" @select="getScan()"/>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="wd-md-150 wd-100p">
                                <input type="date" class="form-control form-control-sm box-height" placeholder="Date..." v-model="date" @change="getScan()">
                            </div>
                            <div class="btn-tools ms-1">
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-tools p-0 border" data-bs-toggle="dropdown" title="More tools">
                                    <i class="mdi mdi-dots-horizontal tx-16"></i>
                                </button>
                                <div class="dropdown-menu tx-13">
                                    <div class="dropdown-item cur-pointer dropdown-hover">
                                        <i class="far fa-file-excel me-2"></i><span>Import AC Log</span>
                                    </div>
                                    <div class="dropdown-item cur-pointer dropdown-hover">
                                        <i class="far fa-file-excel me-2"></i><span>Export To Excel</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive border" style="max-height: 75vh">
                    <table class="table main-table-reference text-nowrap mg-b-0">
                        <thead class="position-sticky" style="top: 0px; z-index: 1">
                            <tr>
                                <th class="border-start-0 px-1">No</th>
                                <th class="px-1 position-sticky" style="left: -1px">Name and Surname</th>
                                <th class="px-1">Position</th>
                                <th class="px-1">Scan</th>

                                <th v-for="(col, colInx) in colData" :key="colInx" class="text-center" style="padding: 7px 6px" :title="col.mont"
                                    :style="headDate(col.colid) == cdate ? 'background-color: yellow; color: blue; font-weight: bold' : ''"
                                >
                                    {{ col.colname }} 
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tx-13">
                            <tr v-for="(row, rowInx) in scanData" :key="rowInx" @click="selectRow(rowInx, row.name)">
                                <td class="px-1 text-center border-start-0">{{rowInx + 1}}</td>
                                <td class="px-1 position-sticky cur-pointer" style="padding: 3px 4px; left: -1px; background-color: #FFFFFF" title="Double click to see details" @dblclick="prvDetail(row.id, row.fullname)">{{row.fullname}}</td>
                                <td class="px-1">{{row.position}}</td>
                                <td class="px-1 text-center">{{row.scan}}</td>
                                <td v-for="(col, colInx) in colData" :key="colInx" class="text-center px-1" :title="mentDate(col.colid) +'  '+ row[col.colid]" 
                                    
                                    :style="code(row[col.colid]) == 'W' || code(row[col.colid]) == 'WN' ? 'background-color: #F2F4F8':
                                            code(row[col.colid]) == 'W/2' ? 'background-color: #FFC000':
                                            code(row[col.colid]) == 'R' || code(row[col.colid]) == 'RW' ? 'background-color: #FFFFCC':
                                            code(row[col.colid]) == 'A' || code(row[col.colid]) == 'A/2' || code(row[col.colid])== 'H' || code(row[col.colid]) == 'P' ? 'background-color: #FFFF99':
                                            code(row[col.colid]) == 'S' ? 'background-color: #F2DCDB':
                                            code(row[col.colid]) == 'MR' ? 'background-color: #FF66FF':
                                            code(row[col.colid]) == 'BWB' || code(row[col.colid]) == 'WO' ? 'background-color: #C6E0B4':
                                            code(row[col.colid]) == 'T' || code(row[col.colid]) == 'T-' ? 'background-color: #FF0000':''" 
                                >
                                    {{ code(row[col.colid]) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>       

                <!-- Modal Detail -->
                <div class="modal fade effect-scale" id="detail" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header pb-1 bd-b-0">
                                <h6 class="main-content-label text-capitalize">{{fullname}}</h6>
                                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body pt-0">                                   
                                <div class="table-responsive element border">
                                    <table class="table main-table-reference text-nowrap mg-b-0">
                                        <thead>
                                            <tr>
                                                <th class="border-start-0">Date</th>
                                                <th>Plan</th>
                                                <th>Actual</th>
                                                <th>Time Period</th>
                                                <th>In1</th>
                                                <th>Out1</th>
                                                <th>In2</th>
                                                <th>Out2</th>
                                                <th>Timesheet</th>
                                                <th class="border-end-0 wd-60p">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <tr class="tr-hover cur-pointer" v-for="lst in detailData" :key="lst.date" @click="prvAcLog(lst.id, lst.date)">
                                                <td class="border-start-0 py-0 text-center border-bottom-0"> {{ dateTime(lst.date) }} </td>
                                                <td :style="lst.plan == 'W' || lst.plan == 'WN' ? 'background-color: #F2F4F8':
                                                            lst.plan == 'W/2' ? 'background-color: #FFC000':
                                                            lst.plan == 'R' || lst.plan == 'RW' ? 'background-color: #FFFFCC':
                                                            lst.plan == 'A' || lst.plan == 'A/2' || lst.plan == 'H' || lst.plan == 'P' ? 'background-color: #FFFF99':
                                                            lst.plan == 'S' ? 'background-color: #F2DCDB':
                                                            lst.plan == 'MR' ? 'background-color: #FF66FF':
                                                            lst.plan == 'T' || lst.plan == 'T-' ? 'background-color: #FF0000':''" class="py-0 text-center border-bottom-0"> {{ lst.plan }} 
                                                </td>
                                                <td :style="lst.actual == 'W' || lst.actual == 'WN' ? 'background-color: #F2F4F8':
                                                            lst.actual == 'W/2' ? 'background-color: #FFC000':
                                                            lst.actual == 'R' || lst.actual == 'RW' || lst.actual == 'OR' || lst.actual == 'IR' ? 'background-color: #FFFFCC':
                                                            lst.actual == 'A' || lst.actual == 'A/2' || lst.actual == 'IA' || lst.actual == 'OA' || lst.actual == 'AA' || lst.actual == 'H' || lst.actual == 'OH' || lst.actual == 'IH' || lst.actual == 'P' ? 'background-color: #FFFF99':
                                                            lst.actual == 'S' || lst.actual == 'SS' ? 'background-color: #F2DCDB':
                                                            lst.actual == 'MR' ? 'background-color: #FF66FF':
                                                            lst.actual == 'BWB' || lst.actual == 'WO' ? 'background-color: #C6E0B4':
                                                            lst.actual == 'T' || lst.actual == 'T-' || lst.actual == 'IT' || lst.actual == 'OT' || lst.actual == 'TT' ? 'background-color: #FF0000':''" class="py-0 text-center border-bottom-0"> {{ lst.actual }} 
                                                </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.period }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.in1 }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.out1 }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.in2 }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.out2 }} </td>
                                                <td :style="lst.timesheet == 'W' || lst.timesheet == 'WN' ? 'background-color: #F2F4F8':
                                                            lst.timesheet == 'W/2' ? 'background-color: #FFC000':
                                                            lst.timesheet == 'R' || lst.timesheet == 'RW' ? 'background-color: #FFFFCC':
                                                            lst.timesheet == 'A' || lst.timesheet == 'A/2' || lst.timesheet == 'H' || lst.timesheet == 'P' ? 'background-color: #FFFF99':
                                                            lst.timesheet == 'S' ? 'background-color: #F2DCDB':
                                                            lst.timesheet == 'MR' ? 'background-color: #FF66FF':
                                                            lst.timesheet == 'T' || lst.timesheet == 'T-' ? 'background-color: #FF0000':''" class="py-0 text-center border-bottom-0"> {{ lst.timesheet }} 
                                                </td>
                                                <td class="py-0 laofont border-end-0 border-bottom-0"> {{ lst.remarks }} </td>
                                            </tr>                                                                                 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                                              
                </div>  

                <!-- Modal AC Log -->
                <div class="modal fade effect-scale pd-t-100 bd-0 bg-black-5" id="aclog" data-bs-keyboard="false" tabindex="-1" aria-labelledby="aclogLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header pb-1 bd-b-0">
                                <h6 class="text-muted">AC Log On <span class="text-danger">{{dateTime(scanDate)}}</span></h6>
                            </div>
                            <div class="modal-body pt-0">                                   
                                <div class="table-responsive element border">
                                    <table class="table main-table-reference text-nowrap mg-b-0">
                                        <thead>
                                            <tr>
                                                <th class="border-start-0">No</th>
                                                <th>Date Time</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th class="border-end-0">Sensor ID</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <tr class="tr-hover cur-pointer" v-for="(lst, key) in acLogData" :key="lst.datetime">
                                                <td class="py-0 text-center border-bottom-0 border-start-0"> {{ key + 1 }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ dateTime2(lst.datetimes) }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ dateTime(lst.dates) }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.times }} </td>
                                                <td class="py-0 border-end-0 border-bottom-0"> {{ lst.sensor }} </td>
                                            </tr>                                                                                 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                                              
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppFingerscan',

    data() {
        return {
            lkDept: [],
            colData: [],
            scanData: [],
            detailData: [],
            acLogData: [],
            dept: '',
            date: '',
            days: '',
            search: '',
            btnClear: false,
            fullname: '',
            scanDate: '',
            loading: false,
            cdate: ''

        };
    },

    mounted() {
        
    },

    methods: {
        async onLoad(){
            this.loading = true;

            const profile = await axios.get('api/profile')
			this.dept = profile.data.department;

            this.cdate = moment(new Date()).format('YYYY-MM-DD');

            this.date = moment(new Date()).format('YYYY-MM-DD');
            const colhead = await axios.get(`/api/fingerscan/datecol?date=${this.date}`)
            this.colData = colhead.data;

            const scan = await axios.get(`/api/fingerscan/summary?dept=${this.dept}&date=${this.date}&search=${this.search}`)
            this.scanData = scan.data;
            
            this.loading = false;

            const depts = await axios.get('/api/lookup/depts')
            this.lkDept = depts.data;
        },

        async getScan(){
            this.loading = true;
            if (this.dept != '' && this.date != ''){
                const colhead = await axios.get(`/api/fingerscan/datecol?date=${this.date}`)
                this.colData = colhead.data;

                const scan = await axios.get(`/api/fingerscan/summary?dept=${this.dept}&date=${this.date}&search=${this.search}`)
                this.scanData = scan.data;
            }
            this.loading = false;
        },

        async searchChange(){
            if(this.search.length >0){
                this.btnClear = true;
                const data = await this.getScan();
            } else {
                this.btnClear = false;
                const data = await this.getScan();
            }
        },

        inputSearch(){
            if(this.search.length >0){
                this.btnClear = true;
            } else {
                this.btnClear = false;
            }
        },

        searchClear(){
            this.search = '';
            this.btnClear = false,
            this.getScan();
        },

        prvDetail(id, name){
            this.fullname = name;
            $('#detail').modal('show');

            this.$axios.post('/api/fingerscan/detail', {
                dept: this.dept,
                date: this.date,
                userid: id
            }).then(res => {
                this.detailData = res.data;
            })
        },

        prvAcLog(id, date){
            this.scanDate = date;
            $('#aclog').modal('show');

             this.$axios.post('/api/fingerscan/aclog', {
                userid: id,
                date: date
            }).then(res => {
                this.acLogData = res.data;
            })
        },

        code(text){
            if (text) {
                return text.split("_")[0];
            }
        },

        headDate(text){
            if (text) {
                return moment(text.split("c")[1]).format("YYYY-MM-DD");
            }
        },

        mentDate(text){
            if (text) {
                return moment(text.split("c")[1]).format("DD/MM/YYYY");
            }
        },
    
        mont(value) {
            if(value) {
                return moment(value).format('MMMM');
            }
        },

        year(value) {
            if(value) {
                return moment(value).format('YYYY');
            }
        },

        dateTime(value) {
            if(value) {
                return moment(value).format('DD-MM-YYYY');
            }
        },

        dateTime2(value) {
            if(value) {
                return moment(value).format('DD-MM-YYYY HH:mm:ss');
            }
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

<style>

</style>