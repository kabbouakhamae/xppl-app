<template>
    <div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-muted mb-0 my-auto">XPPL Roster Code</h4>

                <a class="add-hover p-0 mt-5" href="#" @click="newCode()" title="Add new record"><span class="tx-13 text-primary">Add...</span></a>  

                <div class="table-responsive mt-1 border mh-">
                    <table class="table main-table-reference text-nowrap mb-0">
                        <thead class="position-sticky" style="top: -1px">
                            <tr>
                                <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Roster Code</th>
                                <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Timesheet Code</th>
                                <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold">Description Lao</th>
                                <th style="letter-spacing: 0px; padding: 5px 10px" class="fw-bold" v-if="!!parseInt(loginPermiss.lk_ros)">Description Eng</th>
                                <th style="letter-spacing: 0px; padding: 5px 10px; width: 70%" class="fw-bold" v-else>Description Eng</th>      
                                <th style="letter-spacing: 0px; padding: 5px 10px; width: 70%" class="fw-bold" v-if="!!parseInt(loginPermiss.lk_ros)">Actions</th>
                            </tr>
                        </thead>
                        <tbody> 
                            <!-- <tr class="position-sticky" style="top: 30px"> -->
                            <tr v-if="formShow">
                                <td class="p-0">
                                    <input type="text" class="form-control form-control-sm border-0" style="padding: 0px 0px 0px 10px" placeholder="Roster code..." v-model="rosCodeForm.rcode">
                                </td>
                                <td class="p-0">
                                    <input type="text" class="form-control form-control-sm border-0" style="padding: 0px 0px 0px 10px" placeholder="Ref code..." v-model="rosCodeForm.ref_code">
                                </td>
                                <td class="p-0">
                                    <input type="text" class="form-control form-control-sm border-0 wd-250 laofont" style="padding: 0px 0px 0px 10px" placeholder="Description in Lao..." v-model="rosCodeForm.descr_lao">
                                </td>
                                <td class="p-0">
                                    <input type="text" class="form-control form-control-sm border-0 wd-250" style="padding: 0px 0px 0px 10px" placeholder="Description in Eng..." v-model="rosCodeForm.descr_eng">
                                </td>

                                <td style="padding: 0px 4px; vertical-align: middle">
                                    <div class="d-flex justify-content-start">
                                        <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" data-bs-toggle="dropdown" title="Tools">
                                            <i class="mdi mdi-dots-horizontal text-gray" style="font-size: 13px"></i>
                                        </button> 
                                        <div class="dropdown-menu tx-13">
                                            <div class="dropdown-item cur-pointer dropdown-hover" @click="rodCodeEdit(lst.id)">
                                                <i class="fe fe-save me-2"></i><span>Edit</span>
                                            </div>
                                            <div class="dropdown-item cur-pointer dropdown-hover" @click="fuelCodeDel(lst.id)">
                                                <i class="fe fe-x me-2"></i><span>Cancel</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>


                            </tr>
                            <tr v-else v-for="lst in rosCodeData" :key="lst.id">
                            <!-- <tr class="tr-hover" v-for="lst in rosCodeData" :key="lst.id" 
                                                            :style="lst.ref_code == 'A' || lst.ref_code == 'A/2' || lst.ref_code == 'H' || lst.ref_code == 'M' || lst.ref_code == 'P' ? 'background-color: #FFFF99' 
                                                            : lst.ref_code == 'B' ? 'background-color: #C4D79B' 
                                                            : lst.ref_code == 'EM' ? 'background-color: #D8E4BC' 
                                                            : ''"> -->
                                
                                <td style="padding: 3px 10px">{{ lst.rcode }}</td>
                                <td style="padding: 3px 10px">{{ lst.ref_code }}</td>
                                <td style="padding: 3px 10px" class="laofont">{{ lst.descr_lao }}</td>
                                <td style="padding: 3px 10px"> {{ lst.descr_eng }} </td>

                                <td style="padding: 0px 4px; vertical-align: middle" v-if="!!parseInt(loginPermiss.lk_ros)">
                                    <div class="d-flex justify-content-start">
                                        <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" data-bs-toggle="dropdown" title="Tools">
                                            <i class="mdi mdi-dots-horizontal text-gray" style="font-size: 13px"></i>
                                        </button> 
                                        <div class="dropdown-menu tx-13">
                                            <div class="dropdown-item cur-pointer dropdown-hover" @click="rodCodeEdit(lst.id)">
                                                <i class="fe fe-edit me-2"></i><span>Edit</span>
                                            </div>
                                            <div class="dropdown-item cur-pointer dropdown-hover" @click="rosCodeDel(lst.id)">
                                                <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr> 
                            
                            <!-- <div class="mt-1" style="margin-start: 11px" v-if="!!parseInt(loginPermiss.lk_ros)">
                                    <a class="add-hover p-0" href="#" @click="newFuelLookup()" title="Add new record"><span class="tx-13 text-primary">Add...</span></a>                                                                                           
                                </div>   -->
                        </tbody>
                    </table>
                </div>

                <!-- Equip Modal -->
                <!-- <div class="modal fade effect-scale" id="equip" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="equipLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header pb-1">
                                <h6 class="text-muted main-content-label text-capitalize">Equipment Number</h6>
                            </div>
                            <div class="modal-body">  
                                <div class="form-group">
                                    <label class="mb-0">Equipment No  <span class=" text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Short name..." v-model="equipForm.equip_no">
                                </div>   
                                <div class="form-group">
                                    <label class="mb-0">Equipment Name  <span class=" text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Long name..." v-model="equipForm.equip_name">
                                </div>   
                                <div class="form-group">
                                    <label class="mb-0">Equipment Description  <span class=" text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Description..." v-model="equipForm.equip_descr">
                                </div>    
                                <div class="d-flex justify-content-end">
                                    <button v-if="bntAddShow" type="button" class="btn btn-primary" :class="btnEquipAddDis" @click="equipAdd()"><i class="fe fe-plus"></i><span class="mx-1">Add</span></button> 
                                    <button v-else type="button" class="btn btn-primary" @click="equipUpd()"><i class="fe fe-save"></i><span class="mx-1">Save</span></button> 
                                    <button type="button" class="btn btn-secondary ms-1" data-bs-dismiss="modal"><i class="fe fe-x"></i><span class="mx-1">Close</span></button>
                                </div>
                            </div>
                        </div>
                    </div>                                              
                </div> -->
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
            rosCodeForm: {id: '', rcode: '', ref_code: '', descr_lao: '', descr_eng: ''},
            formShow: false,
            formDataShow: ''
        };
    },

    mounted() {
        
    },

    methods: {
        async getRosCode(){
            const response = await axios.get('/api/permiss')
            this.loginPermiss = response.data;

            const code = await axios.get('/api/roster/roscode')
            this.rosCodeData = code.data;
        },

        newCode(){
            this.formShow = true;
        },

        newFuelLookup(){
            this.fuelCodeFormClear();
            this.bntAddShow = true;
            $('#fuelLookup').modal('show');
        },

        fuelCodeAdd(){
            this.$axios.post('/api/lookupSett/fuelCodeAdd', this.fuelCodeForm)
            .then((res) => {
                    if(res.data.success){

                    $('#fuelLookup').modal('hide');
                    this.fuelCateSelected();

                } else {
                    alert(res.data.message)
                }
            }).catch ((err) => {
                console.log(err);
            })
        },

        rodCodeEdit(id){
            this.formShow = true;
            this.formDataShow = false;
            // this.fuelCodeFormClear();
            // $('#fuelLookup').modal('show');

            this.$axios.post(`/api/roster/rosCodeEdit/${id}`)
            .then((res)=>{

                this.rosCodeForm.id = res.data.id;
                this.rosCodeForm.rcode = res.data.rcode;
                this.rosCodeForm.ref_code = res.data.ref_code;
                this.rosCodeForm.descr_lao = res.data.descr_lao;
                this.rosCodeForm.descr_eng = res.data.descr_eng;

            }).catch((error)=>{
                console.log(error);
            })
        },

        fuelCodeUpd(){
            this.$axios.post('/api/lookupSett/fuelCodeUpd', this.fuelCodeForm)
            .then((res)=>{

                $('#fuelLookup').modal('hide');
                this.fuelCateSelected();

            }).catch((error)=>{
                console.log(error);
            })
        },

        fuelCodeDel(id){
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
                    this.$axios.post(`/api/lookupSett/fuelCodeDel/${id}`)
                    .then((response)=>{

                        this.fuelCateSelected();

                    }).catch((error)=>{
                        console.log(error);
                    })
                }
            });
        },
    },

    

    created(){
        this.getRosCode();
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