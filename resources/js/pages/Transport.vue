<template>
    <div class="card">
        <div class="card-body">
            <div class="breadcrumb-header justify-content-between align-items-center mb-3 mt-0" >
                <div class="d-flex">
                    <h4 class="card-title text-muted mb-0 my-auto">Transport Manifest</h4>
                </div>
                <div class="d-flex my-xl-auto right-content">

                    <Multiselect class="multi-color" style="width: 250px" v-model="depts" mode="multiple" placeholder="Departments..." :close-on-select="false" :searchable="false" :searchStart="true" :options="lkDept" @select="getTransport()"/>
                    <input type="date" class="form-control ms-1" style="width: 130px" placeholder="Date..." v-model="date" @change="getTransport()">
                
                </div>
            </div>
            <div>
                <h6><span class="laofont">ຂາອອກ</span> Outbound: <span class="text-danger fw-bold">{{ dateTime(date) }}</span></h6>
            </div>
            <div class="table-responsive">
                <table class="table main-table-reference text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">No.</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Employee ID</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Name and Surname</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Name in Lao</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Position</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Department</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Contact number</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Return Date</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Leave Info</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px; width: 80%" class="fw-bold">Drop off point</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr class="tr-hover" v-for="lst in outData" :key="lst.no">
                            <td style="padding: 3px 10px" class="text-center">{{ lst.no }}</td>
                            <td style="padding: 3px 10px">{{ lst.empid }}</td>
                            <td style="padding: 3px 10px">{{ lst.title }} {{ lst.name }} {{ lst.surname }}</td>
                            <td style="padding: 3px 10px" class="laofont"> <span v-if="lst.namelao">{{ lst.titlelao }}</span> {{ lst.namelao }} {{ lst.surnamelao }}</td>
                            <td style="padding: 3px 10px">{{ lst.position }}</td>
                            <td style="padding: 3px 10px">{{ lst.dept }}</td>
                            <td style="padding: 3px 10px">{{ lst.phone }}</td>
                            <td style="padding: 3px 10px">{{ dateTime(lst.back) }}</td>
                            <td style="padding: 3px 10px">{{ lst.leaveInfo }}</td>
                            <td style="padding: 3px 10px" class="cur-pointer laofont" title="Click to add drop off point" @click="newDropoff(lst.id)">{{ lst.dropoff }}</td>
                        </tr> 
                    </tbody>
                </table>
            </div>
            <div style="margin-top: 35px">
                <h6><span class="laofont">ຂາເຂົ້າ</span> Inbound: <span class="text-danger fw-bold">{{ dateTime(date) }}</span></h6>
            </div>
            <div class="table-responsive">
                <table class="table main-table-reference text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">No.</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Employee ID</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Name and Surname</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Name in Lao</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Position</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Department</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Contact number</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Leave Date</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Leave Info</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px; width: 80%" class="fw-bold">Pick up point</th>
                        </tr>
                    </thead>
                    <tbody> 
                       <tr class="tr-hover" v-for="lst in inData" :key="lst.no">
                            <td style="padding: 3px 10px" class="text-center">{{ lst.no }}</td>
                            <td style="padding: 3px 10px">{{ lst.empid }}</td>
                            <td style="padding: 3px 10px">{{ lst.title }} {{ lst.name }} {{ lst.surname }}</td>
                            <td style="padding: 3px 10px" class="laofont"> <span v-if="lst.namelao">{{ lst.titlelao }}</span> {{ lst.namelao }} {{ lst.surnamelao }}</td>
                            <td style="padding: 3px 10px">{{ lst.position }}</td>
                            <td style="padding: 3px 10px">{{ lst.dept }}</td>
                            <td style="padding: 3px 10px">{{ lst.phone }}</td>
                            <td style="padding: 3px 10px">{{ dateTime(lst.leave) }}</td>
                            <td style="padding: 3px 10px">{{ lst.leaveInfo }}</td>
                            <td style="padding: 3px 10px" class="cur-pointer laofont" title="Click to add pickup point" @click="newPickup(lst.id)">{{ lst.pickup }}</td>
                        </tr> 
                    </tbody>
                </table>
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
</template>

<script>
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
        };
    },

    mounted() {
        
    },

    methods: {
        async getTransport(){
            let fd = new FormData();
                fd.append('dept', this.depts.toString());
                fd.append('date', this.date);

            const outbound = await axios.post('/api/transport/out', fd, {headers:{"Content-Type": "multipart/form-date"}})
            this.outData = outbound.data;

            const inbound = await axios.post('/api/transport/in', fd, {headers:{"Content-Type": "multipart/form-date"}})
            this.inData = inbound.data;
        },
        
        async getTransport2(){
            const profile = await axios.get('api/profile')
			let loginDept = profile.data.department;

            let fd = new FormData();
                fd.append('dept', loginDept);
                fd.append('date', this.date);

            const outbound = await axios.post('/api/transport/out', fd, {headers:{"Content-Type": "multipart/form-date"}})
            this.outData = outbound.data;

            const inbound = await axios.post('/api/transport/in', fd, {headers:{"Content-Type": "multipart/form-date"}})
            this.inData = inbound.data;
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
        }

        
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