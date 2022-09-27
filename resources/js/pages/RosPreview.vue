<template>

    

    <div>
         <div class="breadcrumb-header justify-content-between align-items-center mb-1 mt-0" >
            <div>
                <h4 class="card-title mg-b-0">Finger Scan</h4>
                <p class="tx-12 tx-gray-500 mb-2">Finger scan checking...</p>
            </div>
            <div class="d-flex my-xl-auto justify-content-end">
                <div class="wd-xl-200 wd-lg-200 wd-md-200 wd-80p">
                    <Multiselect class="multi-color" v-model="dept" placeholder="Departments..." :searchable="false" :searchStart="true" :options="lkDept" @select="selDept()"/>
                </div>
                <div class="ms-1" style="width: 120px">
                    <input type="date" class="form-control" placeholder="Date..." v-model="datefr" @change="selDept()">
                </div>
                <div class="ms-1" style="width: 120px">
                    <input type="date" class="form-control" placeholder="Date..." v-model="dateto" @change="selDept()">
                </div>
            </div>
        </div> 

        <div v-if="loading">
            <loading/>
        </div> 

        <div v-else>
        <div class="card">
            <div class="card-body pd-t-10">
                <div class="breadcrumb-header justify-content-between align-items-center mb-2 mt-0" >
                    <div class="d-flex justify-content-start align-items-center">
                        <h6 class="m-0">{{dept}} on <span class="text-danger fw-bold">dd </span></h6>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center">
                        <div class="pos-relative me-1" style="width: 100%">
                            <input class="form-control form-control-sm ht-30 pd-l-25" type="text" placeholder="search by name..." v-model="search" @input="inputSearch()" @keyup.enter="searchChange()" title="Input the name then press Enter">
                                <i class="fe fe-search search-ism text-muted cur-pointer" @click="searchChange()" title="Click to search"></i>
                            <button class="btn btn-icon btn-sm search-csm text-muted" v-if="btnClear" @click="searchClear()"><i class="fe fe-x" style="font-size: 14px"></i></button>
                        </div>
                        <div class="d-flex justify-content-start">
                            <div class="wd-30">
                                <button type="button" class="btn btn-sm btn-outline-secondary ht-30 wd-30 p-0 border" data-bs-toggle="dropdown" title="More tools">
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
                        

                <div class="table-responsive" style="max-height: 700px">
                    <table class="table main-table-reference text-nowrap mg-b-0">
                        <thead class="position-sticky" style="top: 0px">
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Scan</th>
                                <th v-for="(obj, ind) in headData" :key="ind" style="padding: 7px 8px">
                                    {{ obj.title }} 
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tx-13">
                            <tr v-for="(row, index) in scanData" :key="index">

                                <td style="padding: 3px 4px">{{row.fullname}}</td>
                                <td style="padding: 3px 4px">{{row.position}}</td>
                                <td style="padding: 3px 4px">{{row.scan}}</td>

                                <td v-for="(obj, ind) in headData" :key="ind" class=" text-center" style="padding: 3px 4px"

                                    :style="row[obj.col] == 'W' || row[obj.col] == 'WN' ? 'background-color: #F2F4F8':
                                        row[obj.col] == 'W/2' ? 'background-color: #FFC000':
                                        row[obj.col] == 'R' || row[obj.col] == 'RW' ? 'background-color: #FFFFCC':
                                        row[obj.col] == 'A' || row[obj.col] == 'A/2' || row[obj.col] == 'H' || row[obj.col] == 'P' ? 'background-color: #FFFF99':
                                        row[obj.col] == 'S' ? 'background-color: #F2DCDB':
                                        row[obj.col] == 'MR' ? 'background-color: #FF66FF':
                                        row[obj.col] == 'T' || row[obj.col] == 'T-' ? 'background-color: #FF0000':''"

                                >   
                                    {{ row[obj.col] }}
                                </td>
                            </tr>


                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="card">
            <div class="card-body">

                <div class="table-responsive element">
                    <table class="table main-table-reference text-nowrap mg-b-0 table-hover">
                        <thead>
                            <tr>
                                <th v-for="(obj, ind) in header" :key="ind">
                                    {{ obj.title }} 
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(row, index) in data" :key="index">
                                <td v-for="(obj, ind) in header" :key="ind">
                                    {{ row[obj.key] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->


    </div>
</template>

<script>
export default {
    name: 'XpplAppRosPreview',

    data() {
        return {

            
            // header: [
                //     {key: 'd01', title: 'D01'},
            //     {key: 'd02', title: 'D02'},
            //     {key: 'd03', title: 'D03'},
            //     {key: 'd04', title: 'D04'},
            //     {key: 'd05', title: 'D05'},
            //     {key: 'd06', title: 'D06'},
            //     {key: 'd07', title: 'D07'},
            //     {key: 'd08', title: 'D08'},
            //     {key: 'd09', title: 'D09'},
            //     {key: 'd10', title: 'D10'},
            // ],

            // data: [
                //     {d01: 'W1', d02: 'W2', d03: 'W3', d04: 'W4', d06: 'W6', d07: 'W7', d08: 'W8', d09: 'W9'},
            //     {d01: 'R1', d02: 'R2', d03: 'R3', d04: 'R4', d05: 'R5', d06: 'R6', d07: 'R7', d08: 'R8', d09: 'R9', d10: 'R10'},
            //     {d01: 'S1', d02: 'S2', d03: 'R3', d04: 'R4', d05: 'R5', d06: 'R6', d07: 'R7', d08: 'R8', d09: 'R9', d10: 'R10'},
            //     {d01: 'A1', d02: 'A2', d03: 'R3', d04: 'R4', d05: 'R5', d06: 'R6', d07: 'R7', d08: 'R8', d09: 'R9', d10: 'R10'},
            //     {d01: 'H1', d02: 'H2', d03: 'R3', d04: 'R4', d05: 'R5', d06: 'R6', d07: 'R7', d08: 'R8', d09: 'R9', d10: 'R10'},
            //     {d01: 'T1', d02: 'T2', d03: 'R3', d04: 'R4', d05: 'R5', d06: 'R6', d07: 'R7', d08: 'R8', d09: 'R9', d10: 'R10'},
            //     {d01: 'B1', d02: 'B2', d03: 'R3', d04: 'R4', d05: 'R5', d06: 'R6', d07: 'R7', d08: 'R8', d09: 'R9', d10: 'R10'}
            // ],

            // header2: [
                //     {key: 'avatar', title: 'Avatar'},
            //     {key: 'name', title: 'Name'},
            //     {key: 'city', title: 'City'},
            //     {key: 'companyName', title: 'Company'},
            //     {key: 'createdAt', title: 'Signup'}
            // ],

            // apiData: []


            loading: true,
            lkDept: [],
            scanData: [],
            headData: [],

            dept: '',
            detefr: '',
            dateto: '',
            search: '',
            btnClear: ''

        };
    },

    mounted() {
        
    },

    methods: {
        // onLoad(){
        //     this.$axios.get('https://5e4b062d6eafb7001488c99e.mockapi.io/something123/users')
        //     .then(res => this.apiData = res.data)
        // }
        async onLoad(){
            this.loading = true;

            const profile = await axios.get('api/profile')
			this.dept = profile.data.department;

            const depts = await axios.get('/api/lookup/depts')
            this.lkDept = depts.data;

            // const scan = await axios.get(`/api/fingerscan/summary?dept=${this.dept}&date=${this.date}&search=${this.search}`)
            // this.scanData = scan.data;
            // this.days = scan.data[0].days;

            this.loading = false;
        },

        async selDept(){
            this.scanData = '';

            this.loading = true;

            if (this.datefr != '' && this.dateto != ''){
                const head = await axios.get(`/api/fingerscan/header?datefr=${this.datefr}&dateto=${this.dateto}`)
                this.headData = head.data;

                const summary = await axios.get(`/api/fingerscan/summary2?dept=${this.dept}&datefr=${this.datefr}&dateto=${this.dateto}&search=${this.search}`)
                this.scanData = summary.data;
                this.days = summary.data[0].days;
            }

            this.loading = false;
        },


        async searchChange(){
            if(this.search.length >0){
                this.btnClear = true;
                const data = await this.selDept();
            } else {
                this.btnClear = false;
                const data = await this.selDept();
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
            this.selDept();
        },


    },

    created(){
        this.onLoad();
    }
};
</script>

<style>

</style>