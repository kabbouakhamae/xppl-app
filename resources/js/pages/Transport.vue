<template>
    <div v-if="loading">
        <loading/>
    </div> 
    <div v-else>
        <div class="breadcrumb-header justify-content-between align-items-center mb-1 mt-0" >
            <div>
                <h4 class="card-title mg-b-0">Transport Manifest</h4>
                <p class="tx-12 tx-gray-500 mb-2">Daily transport manifest by Departments...</p>
            </div>
            <div class="d-flex my-xl-auto justify-content-end">
                <div class="wd-xl-200 wd-lg-200 wd-md-200 wd-80p">
                    <Multiselect class="multi-color" v-model="depts" mode="multiple" placeholder="Departments..." :close-on-select="false" :searchable="false" :searchStart="true" :options="lkDept" @select="getTransport()"/>
                </div>
                <div class="ms-1" style="width: 120px">
                    <input type="date" class="form-control" placeholder="Date..." v-model="date" @change="getTransport()">
                </div>
            </div>
        </div> 

        <div class="card">
            <div class="card-body bt-2">
                <div v-if="!pdf" class="d-flex justify-content-between">
                    <h6><span class="laofont">ຂາອອກ</span> Outbound: <span class="text-danger fw-bold">{{ dateTime(date) }}</span></h6>
                    <div class="d-flex justify-content-start">
                        <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" data-bs-toggle="dropdown" title="Tools">
                            <i class="mdi mdi-dots-horizontal text-gray" style="font-size: 15px"></i>
                        </button> 
                        <div class="dropdown-menu tx-13">
                            <div class="dropdown-item cur-pointer dropdown-hover" @click="exportToPDF()">
                                <i class="far fa-file-pdf me-2"></i><span>Export To PDF</span>
                            </div>
                            <!-- <div class="dropdown-item cur-pointer dropdown-hover">
                                <i class="far fa-file-excel me-2"></i><span>Export To Excel</span>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div id="element-to-convert">
                    <div v-if="pdf">
                        <h6><span class="laofont">ຂາອອກ</span> Outbound: <span class="text-danger fw-bold">{{ dateTime(date) }}</span></h6>
                    </div>

                    <div class="table-responsive element">
                        <table class="table main-table-reference text-nowrap mg-b-0 table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Employee ID</th>
                                    <th>Name and Surname</th>
                                    <th>Name Lao</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Contact Number</th>
                                    <th>Return Date</th>
                                    <th>Leave Info</th>
                                    <th class="wd-80p">Drop off Point</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="lst in outData" :key="lst.no">
                                    <td class="text-center">{{ lst.no }}</td>
                                    <td>{{ lst.empid }}</td>
                                    <td>{{ lst.title }} {{ lst.name }} {{ lst.surname }}</td>
                                    <td class="laofont"> <span v-if="lst.namelao">{{ lst.titlelao }}</span> {{ lst.namelao }} {{ lst.surnamelao }}</td>
                                    <td>{{ lst.position }}</td>
                                    <td>{{ lst.dept }}</td>
                                    <td>{{ lst.phone }}</td>
                                    <td>{{ dateTime(lst.back) }}</td>
                                    <td>{{ lst.leaveInfo }}</td>
                                    <td class="cur-pointer laofont" title="Click to add drop off point" @click="newDropoff(lst.id)">{{ lst.dropoff }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div style="margin-top: 35px">
                        <h6><span class="laofont">ຂາເຂົ້າ</span> Inbound: <span class="text-danger fw-bold">{{ dateTime(date) }}</span></h6>
                    </div>
                    <div class="table-responsive element">
                        <table class="table main-table-reference text-nowrap mg-b-0 table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Employee ID</th>
                                    <th>Name and Surname</th>
                                    <th>Name Lao</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Contact Number</th>
                                    <th>Leave Date</th>
                                    <th>Leave Info</th>
                                    <th class="wd-80p">Pick up point</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="lst in inData" :key="lst.no">
                                    <td class="text-center">{{ lst.no }}</td>
                                    <td>{{ lst.empid }}</td>
                                    <td>{{ lst.title }} {{ lst.name }} {{ lst.surname }}</td>
                                    <td class="laofont"> <span v-if="lst.namelao">{{ lst.titlelao }}</span> {{ lst.namelao }} {{ lst.surnamelao }}</td>
                                    <td>{{ lst.position }}</td>
                                    <td>{{ lst.dept }}</td>
                                    <td>{{ lst.phone }}</td>
                                    <td>{{ dateTime(lst.leave) }}</td>
                                    <td>{{ lst.leaveInfo }}</td>
                                    <td class="cur-pointer laofont" title="Click to add pickup point" @click="newPickup(lst.id)">{{ lst.pickup }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> 

                <div class="modal fade effect-scale" id="dropoff" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dropoffLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header pb-1 bd-b-0">
                                <h6 class="text-muted">Add drop off point</h6>
                            </div>
                            <div class="modal-body">                                
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <input type="text" class="form-control laofont" placeholder="ຈຸດສົ່ງພະນັກງານ..." v-model="dropoffForm.dropoff" @keydown.enter="dropoffUpd()">
                                        <button type="button" class="btn btn-primary ms-2" style="padding: 0px; width: 50px" title="Add new employee" @click="dropoffUpd()"><i class="fa fa-plus"></i></button> 
                                    </div>                           
                                </div>
                            </div>
                        </div>
                    </div>                                              
                </div>  

                <div class="modal fade effect-scale" id="pickup" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pickupLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header pb-1 bd-b-0">
                                <h6 class="text-muted main-content-label text-capitalize">Add pickup point</h6>
                            </div>
                            <div class="modal-body">                                
                                <div class="form-group">                              
                                    <div class="d-flex justify-content-between">
                                        <input type="text" class="form-control laofont" placeholder="ຈຸດຮັບພະນັກງານ..." v-model="pickupForm.pickup" @keydown.enter="pickupUpd()">
                                        <button type="button" class="btn btn-primary ms-2" style="padding: 0px; width: 50px" title="Add new employee" @click="pickupUpd()"><i class="fa fa-plus"></i></button>  
                                    </div>                           
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

import html2pdf from "html2pdf.js";

export default {
    name: 'XpplAppTransport',

    data() {
        return {
            outData: [],
            inData: [],
            lkDept: [],
            depts: [],
            date: '',
            pickupForm: {id: '', pickup: ''},
            dropoffForm: {id: '', dropoff: ''},
            pdf: '',
            loading: false
        };
    },

    mounted() {
        
    },

    methods: {
        async getTransport(){
            this.loading = true;
            let fd = new FormData();
                fd.append('dept', this.depts.toString());
                fd.append('date', this.date);

            const outbound = await axios.post('/api/transport/out', fd, {headers:{"Content-Type": "multipart/form-date"}})
            this.outData = outbound.data;

            const inbound = await axios.post('/api/transport/in', fd, {headers:{"Content-Type": "multipart/form-date"}})
            this.inData = inbound.data;

             this.loading = false;
        },
        
        async getTransport2(){
            this.loading = true;

            const profile = await axios.get('api/profile')
			let loginDept = profile.data.department;

            let fd = new FormData();
                fd.append('dept', loginDept);
                fd.append('date', this.date);

            const outbound = await axios.post('/api/transport/out', fd, {headers:{"Content-Type": "multipart/form-date"}})
            this.outData = outbound.data;

            const inbound = await axios.post('/api/transport/in', fd, {headers:{"Content-Type": "multipart/form-date"}})
            this.inData = inbound.data;

            this.loading = false;
        },

        newDropoff(id){
            $('#dropoff').modal('show');
            this.dropoffForm.id = id;
        },

        newPickup(id){
            $('#pickup').modal('show');
            this.pickupForm.id = id;
        },

        dropoffUpd(){
            this.$axios.post('/api/transport/dropoff', this.dropoffForm)
            .then((response)=>{

                $('#dropoff').modal('hide');
                this.getTransport();

            }).catch((error)=>{
                console.log(error);
            })
        },

        pickupUpd(){
            this.$axios.post('/api/transport/pickup', this.pickupForm)
            .then((response)=>{

                $('#pickup').modal('hide');
                this.getTransport();

            }).catch((error)=>{
                console.log(error);
            })
        },

        nextDate(){
            this.date = moment(new Date(new Date().getTime() + 24 * 60 * 60 * 1000)).format('YYYY-MM-DD');
        },

        dateTime(value) {
            if(value) {
                return moment(value).format('DD-MM-YYYY');
            }
        },

        async getDept(){
            const depts = await axios.get('/api/lookup/depts')
            this.lkDept = depts.data;
        },

        async exportToPDF() {
            this.pdf = true;
		    const run = await html2pdf(document.getElementById('element-to-convert'),{
                    margin:       10,
                    filename:     'Transport Manifest.pdf',
                    image:        { type: 'jpeg', quality: 0.98 },
                    html2canvas:  { scale: 10, logging: true, dpi: 500, letterRendering: true },
                    jsPDF:        { unit: 'mm', format: 'a3', orientation: 'landscape' }
                });
            
            this.pdf = '';
		},

        
    },

    created(){
        this.getDept();
        this.nextDate();
        this.getTransport2();
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