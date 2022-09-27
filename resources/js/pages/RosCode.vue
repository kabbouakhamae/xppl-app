<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between mb-1">
                    <h4 class="card-title text-muted mb-0 my-auto text-capitalize">XPPL Roster Code</h4>
                    <button v-if="!!parseInt(loginPermiss.lk_ros)" type="button" class="btn btn-sm btn-rounded btn-primary" style="padding: 3.2px 11.2px" title="Add new record" @click="newCode()"><i class="fe fe-plus"></i> 
                        <span class="mx-1">New</span>
                    </button>
                </div>

                <div class="table-responsive element ht-md-700">
                    <table class="table main-table-reference text-nowrap mg-b-0">
                        <thead class="position-sticky" style="top: 0px">
                            <tr>
                                <th>Roster Code</th>
                                <th>Timesheet Code</th>
                                <th>Description Lao</th>
                                <th>Description Eng</th>  

                                <th v-if="loginPermiss.lk_ros == 1">Working Time</th>      
                                <th class="wd-70p" v-else>Working Time</th>      
                                <th class="wd-70p" v-if="loginPermiss.lk_ros == 1">Actions</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <tr v-for="lst in rosCodeData" :key="lst.id">
                                <td>{{ lst.rcode }}</td>
                                <td>{{ lst.ref_code }}</td>
                                <td class="laofont">{{ lst.descr_lao }}</td>
                                <td> {{ lst.descr_eng }} </td>
                                <td> {{ lst.working_time }} </td>
                                <td v-if="loginPermiss.lk_ros == 1" class="p-0 align-middle">
                                    <div class="d-flex justify-content-start">
                                        <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" title="Edit this record" @click="rosCodeEdit(lst.id)">
                                            <i class="bx bx-edit text-info" style="font-size: 16px"></i>
                                        </button> 
                                        <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" title="Delete this record" @click="rosCodeDel(lst.id)">
                                            <i class="bx bx-trash text-danger" style="font-size: 16px"></i>
                                        </button> 
                                    </div>
                                </td>
                            </tr> 
                        </tbody>
                    </table>
                </div>

                <!-- Equip Modal -->
                <div class="modal fade effect-scale" id="rosCode" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rosCodeLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header pb-1">
                                <h6 class="text-muted main-content-label text-capitalize">Roster Code</h6>
                            </div>
                            <div class="modal-body">  
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Roster Code  <span class=" text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Roster code..." v-model="rosCodeForm.rcode">
                                        </div>   
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Timesheet Code  <span class=" text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Timesheet code..." v-model="rosCodeForm.ref_code">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="mb-0">Description Lao <span class=" text-danger">*</span></label>
                                    <input type="text" class="form-control laofont" placeholder="Description..." v-model="rosCodeForm.descr_lao">
                                </div>    
                                <div class="form-group">
                                    <label class="mb-0">Description Eng  <span class=" text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Description..." v-model="rosCodeForm.descr_eng">
                                </div>  
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Working Time</label>
                                            <input type="text" class="form-control" placeholder="Working time..." v-model="rosCodeForm.working_time">
                                        </div>   
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Used  <span class=" text-danger">*</span></label>
                                            <input type="text" class="form-control" placeholder="Used..." v-model="rosCodeForm.used">
                                        </div>
                                    </div>
                                </div>  
                                <div class="d-flex justify-content-end">
                                    <button v-if="bntAddShow" type="button" class="btn btn-primary" :class="btnRosAddDis" @click="rosCodeAdd()"><i class="fe fe-plus"></i><span class="mx-1">Add</span></button> 
                                    <button v-else type="button" class="btn btn-primary" @click="rosCodeUpd()"><i class="fe fe-save"></i><span class="mx-1">Save</span></button> 
                                    <button type="button" class="btn btn-secondary ms-1" data-bs-dismiss="modal"><i class="fe fe-x"></i><span class="mx-1">Close</span></button>
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
    name: 'XpplAppRosCode',

    data() {
        return {
            rosCodeData: [],
            loginPermiss: [],
            rosCodeForm: {id: '', rcode: '', ref_code: '', descr_lao: '', descr_eng: '', working_time: '', used: '1'},
            bntAddShow: ''
        };
    },

    mounted() {
        
    },

    computed: {
        btnRosAddDis(){
            let f = this.rosCodeForm;
            if (f.rcode == '' || f.ref_code == '' || f.descr_lao == '' || f.descr_eng == '' || f.used == ''){
                return 'disabled';
            } else {
                return '';
            }
        }
    },

    methods: {
        async getRosCode(){
            const response = await axios.get('/api/permiss')
            this.loginPermiss = response.data;

            const code = await axios.get('/api/roster/rosCode')
            this.rosCodeData = code.data;
        },

        newCode(){
            this.rosCodeFormClear();
            this.bntAddShow = true;
            $('#rosCode').modal('show');
        },

        rosCodeAdd(){
            this.$axios.post('/api/roster/rosCodeAdd', this.rosCodeForm)
            .then((res) => {
                if(res.data.success){
                    $('#rosCode').modal('hide');
                    this.getRosCode();
                } else {
                    alert(res.data.message)
                }
            }).catch ((err) => {
                console.log(err);
            })
        },

        rosCodeEdit(id){
            this.rosCodeFormClear();
            this.bntAddShow = false;
            $('#rosCode').modal('show');

            this.$axios.post(`/api/roster/rosCodeEdit/${id}`)
            .then((res)=>{

                this.rosCodeForm.id = res.data.id;
                this.rosCodeForm.rcode = res.data.rcode;
                this.rosCodeForm.ref_code = res.data.ref_code;
                this.rosCodeForm.descr_lao = res.data.descr_lao;
                this.rosCodeForm.descr_eng = res.data.descr_eng;
                this.rosCodeForm.working_time = res.data.working_time;
                this.rosCodeForm.used = res.data.used;

            }).catch((error)=>{
                console.log(error);
            })
        },

        rosCodeUpd(){
            this.$axios.post('/api/roster/rosCodeUpd', this.rosCodeForm)
            .then((res)=>{

                $('#rosCode').modal('hide');
                this.getRosCode();

            }).catch((error)=>{
                console.log(error);
            })
        },

        rosCodeDel(id){
            this.$swal.fire({
                text: "Do you want to delete this record?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="font-weight-light">Delete</span>',
                cancelButtonText: '<i class="fe fe-x"></i> <span class="font-weight-light">Cancel</span>',
                confirmButtonColor: '#d33',
                allowEnterKey: false,
                allowOutsideClick: false,
            }).then((result)=>{
                if(result.isConfirmed){
                    this.$axios.post(`/api/roster/rosCodeDel/${id}`)
                    .then((response)=>{

                        this.getRosCode();

                    }).catch((error)=>{
                        console.log(error);
                    })
                }
            });
        },

        rosCodeFormClear(){
            let f = this.rosCodeForm;
                f.rcode = '';
                f.ref_code = '';
                f.descr_lao = '';
                f.descr_eng = '';
                f.working_time = '';
                f.used = '1';
        }
    },

    
    created(){
        this.getRosCode();
    },

    beforeRouteEnter(to, from, next){
        if(!window.Laravel.isLoggedin_laravel){
            window.location.href = "/signin";
        }
        next();
	}
};
</script>

<style lang="scss" scoped>

</style>