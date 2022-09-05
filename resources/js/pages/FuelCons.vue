<template>
    <div class="card">
        <div class="card-body">
            <div class="breadcrumb-header justify-content-between align-items-center mb-3 mt-0" >
                <div class="d-flex">
                    <h4 class="card-title text-muted mb-0 my-auto">Fuel Reservation <span v-if="headerForm.refuel_date">On </span><span class="text-danger">{{dateTime(headerForm.refuel_date)}}</span></h4>
                </div>
                <div class="d-flex my-xl-auto right-content">
                    <input type="date" class="form-control" style="width: 146px" v-model="headerForm.refuel_date" @change="refuelDateChanged()">
                </div>
            </div>

            <!-- Header table -->
            <div class="table-responsive border" style="max-height: 250px">
                <table class="table main-table-reference text-nowrap mb-1">
                    <thead class="position-sticky" style="top: -1px">
                        <tr>
                            <th style="letter-spacing: 0px; padding: 5px 10px" v-if="!!parseInt(permiss.fuel_all)" >Department</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">
                                <div v-if="!!parseInt(permiss.fuel_all)">Department Cost</div>
                                <div v-else>Department</div>
                            </th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Cost Type</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Cost Code</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Locations</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Approve by</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">created at</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">created by</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Updated at</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Updated by</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px; width: 80%">Actions</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr class="tr-hover cur-pointer" v-for="(lst, key) in headerData" :key="lst.id" @click="headerSelected(key, lst.id, lst.cost_type)" :style="key === headerSelectedRow ? 'background-color: #dadee7; border-left: 1.02px solid #0162e8; color: blue' : ''">
                            <td style="padding: 3px 10px" v-if="!!parseInt(permiss.fuel_all)">{{lst.created_dept}}</td>
                            <td style="padding: 3px 10px">{{lst.cost_dept}}</td>
                            <td style="padding: 3px 10px">{{lst.cost_type}}</td>
                            <td style="padding: 3px 10px">{{lst.cost_no}}</td>
                            <td style="padding: 3px 10px" class="laofont">{{lst.location}}</td>
                            <td style="padding: 3px 10px">{{lst.approved_by}}</td>
                            <td style="padding: 3px 10px" class="text-muted">{{dateTime2(lst.created_at)}}</td>
                            <td style="padding: 3px 10px" class="text-muted text-capitalize">{{lst.created_by}}</td>
                            <td style="padding: 3px 10px" class="text-muted">{{dateTime2(lst.updated_at)}}</td>
                            <td style="padding: 3px 10px" class="text-muted text-capitalize">{{lst.updated_by}}</td>
                            <td style="padding: 0px 4px; vertical-align: middle">
                                <div class="d-flex justify-content-start">
                                    <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" data-bs-toggle="dropdown" title="Tools">
                                        <i class="mdi mdi-dots-horizontal text-gray" style="font-size: 13px"></i>
                                    </button> 
                                    <div class="dropdown-menu tx-13">
                                        <div class="dropdown-item cur-pointer dropdown-hover" @click="headerEdit(lst.id)">
                                            <i class="fe fe-edit me-2"></i><span>Edit</span>
                                        </div>
                                        <div class="dropdown-item cur-pointer dropdown-hover" @click="headerDel(lst.id)">
                                            <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>   
                        <div class="mt-1" style="margin-start: 11px">
                            <a class="add-hover p-0" href="#" v-if="headerForm.refuel_date" @click="headerNew()" title="Add new record"><span class="tx-13">Add...</span></a>                                                                                        
                        </div>                                                                               
                    </tbody>
                </table>
            </div>

            <!-- Detail table -->
            <div class="table-responsive border mt-3" style="max-height: 450px">
                <table class="table main-table-reference text-nowrap mb-1">
                    <thead class="position-sticky" style="top: -1px">
                        <tr>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Equip No</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Description</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Liter</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">smu</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Driver</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Shift</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Material</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Work Order</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Reserve No</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Refuel By</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">created at</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">created by</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Updated at</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Updated by</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px; width: 80%">Actions</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr class="tr-hover" v-for="lst in detailData" :key="lst.id">
                            <td style="padding: 3px 10px">{{ lst.equip_no }}</td>
                            <td style="padding: 3px 10px">{{ lst.equip_descr }}</td>
                            <td style="padding: 3px 10px" class="text-end">{{ lst.liter }}</td>
                            <td style="padding: 3px 10px" class="text-end">{{ lst.smu }}</td>
                            <td style="padding: 3px 10px" class="text-capitalize">{{ lst.driver }}</td>
                            <td style="padding: 3px 10px">{{ lst.work_shift }}</td>
                            <td style="padding: 3px 10px">{{ lst.material_descr }}</td>
                            <td style="padding: 3px 10px">{{ lst.work_order }}</td>
                            <td style="padding: 3px 10px" class="text-center">{{ lst.reserve_no }}</td>
                            <td style="padding: 3px 10px" class="text-capitalize">{{ lst.refuel_by }}</td>
                            <td style="padding: 3px 10px" class="text-muted">{{dateTime2(lst.created_at)}}</td>
                            <td style="padding: 3px 10px" class="text-muted text-capitalize">{{lst.created_by}}</td>
                            <td style="padding: 3px 10px" class="text-muted">{{dateTime2(lst.updated_at)}}</td>
                            <td style="padding: 3px 10px" class="text-muted text-capitalize">{{lst.updated_by}}</td>
                            <td style="padding: 0px 4px; vertical-align: middle">
                                <div class="d-flex justify-content-start">
                                    <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" data-bs-toggle="dropdown" title="Tools">
                                        <i class="mdi mdi-dots-horizontal text-gray" style="font-size: 13px"></i>
                                    </button> 
                                    <div class="dropdown-menu tx-13">
                                        <div class="dropdown-item cur-pointer dropdown-hover" @click="detailEdit(lst.id)">
                                            <i class="fe fe-edit me-2"></i><span>Edit</span>
                                        </div>
                                        <div class="dropdown-item cur-pointer dropdown-hover" @click="detailDel(lst.id)">
                                            <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <div class="mt-1" style="margin-start: 11px">
                            <a class="add-hover p-0" href="#" v-if="detailForm.head_id" @click="detailNew()" title="Add new record"><span class="tx-13 text-primary">Add...</span></a>                                                                                           
                        </div>
                    </tbody>
                </table>
            </div>

            <!-- Modal Header -->
            <div class="modal fade effect-scale" id="header" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="headLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted">Reservation Title</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label class="mb-0">Plant <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="headerForm.plant" placeholder="Select" :options="lkPant"/>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <div class="form-group">
                                        <label class="mb-0">Department / Company <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="headerForm.cost_dept" searchable="true" searchStart="true" placeholder="Select" @select="deptChanged()" :options="lkDept"/>
                                    </div>
                                </div>
                                <div class="col-sm-5 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Cost Type <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="headerForm.cost_type" placeholder="Select" @select="typeChanged()" :options="lkType"/>
                                    </div>
                                </div>                                
                                <div class="col-sm-7 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Cost Code <span class=" text-danger">*</span></label>
                                        <Multiselect v-if="headerForm.cost_type == 'WBS'" class="multi-color" v-model="headerForm.cost_no" placeholder="Select" :options="lkWbs"/>
                                        <cleave v-else-if="headerForm.cost_type == 'Cost Center'" :options="options" disabled class="form-control" v-model="headerForm.cost_no" placeholder="Cost center..."/>
                                        <cleave v-else :options="options"  class="form-control" v-model="headerForm.cost_no" placeholder="Cost center..."/>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="mb-0">Approve by</label> 
                                        <Multiselect class="multi-color" v-model="headerForm.approved_by" placeholder="Select" :options="lkApprove"/>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="mb-0">Location</label>
                                        <input type="text" class="form-control laofont" placeholder="Work locations..." v-model="headerForm.location">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="btnHeaderUpdShow" type="button" class="btn btn-primary" :class="btnHeaderDisable" @click="headerUpd()"><i class="fe fe-save"></i> 
                                <span class="mx-1">Save</span>
                            </button>
                            <button v-if="btnHeaderAddShow" type="button" class="btn btn-primary" :class="btnHeaderDisable" @click="headerAdd()"><i class="fe fe-plus"></i> 
                                <span class="mx-1">Add</span>
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fe fe-x"></i> 
                                <span class="mx-1">Close</span>
                            </button>
                        </div>
                    </div>
                </div>                                              
            </div>

            <!-- Modal details -->
            <div class="modal fade effect-scale" id="detail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true" style="z-index: 1062">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted">Reservation Details</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-2 col-md-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Shift <span class="text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="detailForm.work_shift" placeholder="Select" :options="lkShift"/>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Equipment No.<span class="text-danger">*</span></label> 
                                        <input v-if="headerForm.cost_type == 'IO'" type="text" class="form-control" placeholder="Equipment no..." v-model="detailForm.equip_no">
                                        <Multiselect v-else class="multi-color" v-model="detailForm.equip_no" placeholder="Select" searchable="true" @select="equipChanged()" :options="lkEquipno"/>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-12">
                                    <div class="form-group">
                                        <label class="mb-0">Description <span class="text-danger">*</span></label>
                                        <input v-if="headerForm.cost_type == 'IO'" type="text" class="form-control laofont" placeholder="Equipment description..." v-model="detailForm.equip_descr">
                                        <input v-else type="text" class="form-control laofont" disabled placeholder="Equipment description..." v-model="detailForm.equip_descr">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Liter <span class="text-danger">*</span></label>
                                        <cleave :options="options1" class="form-control" v-model="detailForm.liter" placeholder="Liter..."/>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">SMU</label>
                                        <cleave :options="options" class="form-control" v-model="detailForm.smu" placeholder="SMU number..."/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-6">
                                    <div class="form-group">
                                        <label v-if="headerForm.cost_type == 'IO'" class="mb-0">Driver <span class="text-danger">*</span></label>
                                        <label v-else class="mb-0">Driver</label>
                                        <input v-if="headerForm.cost_type == 'IO'" type="text" class="form-control" placeholder="Driver name..." v-model="detailForm.driver">
                                        <Multiselect v-else class="multi-color" v-model="detailForm.driver" searchable="true" searchStart="true" placeholder="Select" title="Double click to add driver name" @dblclick="newDriver()" :options="lkDriver"/>                 
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-6">
                                    <div class="form-group">
                                        <label v-if="headerForm.cost_type == 'IO'" class="mb-0">Refuel By <span class="text-danger">*</span></label>
                                        <label v-else class="mb-0">Refuel By</label>
                                        <input type="text" class="form-control" placeholder="Refuel by..." v-model="detailForm.refuel_by">
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-6 col-6">
                                    <div class="form-group">
                                        <label v-if="headerForm.cost_type == 'IO'" class="mb-0">Reserve No</label>
                                        <label v-else class="mb-0">Reserve No <span class="text-danger">*</span></label>
                                        <cleave :options="options"  class="form-control" v-model="detailForm.reserve_no" placeholder="Reserve no..." title="After input the number then press Enter on keyboard to add" @keyup.enter="addNewReserveNo()"/>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-6">
                                    <div class="form-group">
                                        <label v-if="headerForm.cost_type == 'IO'" class="mb-0">Work Order</label>
                                        <label v-else class="mb-0">Work Order <span class="text-danger">*</span></label>
                                        <cleave :options="options"  class="form-control" v-model="detailForm.work_order" placeholder="Work order no..."/>
                                    </div>
                                </div>
                                
                                <div class="col-lg-7 col-12">
                                    <div class="form-group">
                                        <label class="mb-0">Material <span class="text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="detailForm.material" placeholder="Select" :options="lkMaterial"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="btnDetailUpdShow" type="button" class="btn btn-primary" :class="btnDetailDisable" @click="detailUpd()"><i class="fe fe-save"></i> 
                                <span class="mx-1">Save</span>
                            </button>
                            <button v-if="btnDetailAddShow" type="button" class="btn btn-primary" :class="btnDetailDisable" @click="detailAdd()"><i class="fe fe-plus"></i> 
                                <span class="mx-1">Add</span>
                            </button>
                            <button v-if="btnDetailSaveShow" type="button" class="btn btn-danger" :class="btnDetailDisable" @click="detailSave()"><i class="fe fe-save"></i> 
                                <span class="mx-1">Save</span>
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fe fe-x"></i> 
                                <span class="mx-1">Close</span>
                            </button>
                        </div>
                    </div>
                </div>                                              
            </div>

            <div class="modal fade effect-scale mt-3 bd-0 bg-black-1" id="driver" data-bs-keyboard="false" tabindex="-1" aria-labelledby="dropoffLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header pb-1 bd-b-0">
                            <h6 class="text-muted">Add Driver Name</h6>
                        </div>
                        <div class="modal-body">                                
                            <div class="form-group">
                                <div class="d-flex justify-content-between">
                                    <input type="text" class="form-control" placeholder="Driver name..." v-model="detailForm.driver">
                                    <button type="button" class="btn btn-primary ms-2" :class="btnDriverAdd" style="padding: 0px; width: 50px" title="Add driver name" @click="addNewDriver()"><i class="fa fa-plus"></i></button> 
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
    name: 'XpplAppFuelCons',

    data() {
        return {
            permiss: [],
            headerData: [],
            detailData: [],
            lkDept: [],
            lkType: [],
            lkEquipno: [],
            lkMaterial: [],
            lkApprove: [],
            lkWbs: [],
            lkPant: ['XPPL', 'XTPPL'],
            lkShift: ['DS', 'NS'],
            lkDriver: [],
            headerForm: {id: '', plant: 'XPPL', refuel_date: '', created_dept: '', cost_dept: null, cost_type: null, cost_no: '', location: '', approved_by: null},
            detailForm: {id: '', head_id: '', work_shift: 'DS', equip_no: null, equip_descr: '', work_order: '', reserve_no: '', material: '40002084', smu: '', liter: '', driver: '', refuel_by: ''},
            headerSelectedRow: '',
            btnHeaderUpdShow: '',
            btnHeaderAddShow: '',
            btnDetailUpdShow: '',
            btnDetailAddShow: '',
            btnDetailSaveShow: '',


            options:{
                // prefix: '$',
                numeral: true,
                numeralPositiveOnly: true,
                noImmediatePrefix: true,
                rawValueTrimPrefix: true,
                numeralIntegerScale: 15,
                numeralDecimalScale: 0,
                numeralDecimalMark: '.',
                delimiter: ''
			},

            options1:{
                numeral: true,
                numeralPositiveOnly: true,
                noImmediatePrefix: true,
                rawValueTrimPrefix: true,
                numeralIntegerScale: 4,
                numeralDecimalScale: 2,
                numeralDecimalMark: '.',
                delimiter: ','
			},
        };
    },

    mounted() {
        
    },

    computed: {
        btnHeaderDisable(){
            if (this.headerForm.cost_dept == null || this.headerForm.cost_type == null || this.headerForm.cost_no == '' || this.headerForm.cost_no == null){
                return 'disabled';
            } else {
                return '';
            }
        },
        btnDetailDisable(){
            if (this.headerForm.cost_type == 'IO'){
                if (this.detailForm.equip_no == '' || this.detailForm.equip_descr == '' || this.detailForm.liter == '' || this.detailForm.work_shift == null || this.detailForm.driver == '' || this.detailForm.refuel_by == '' || this.detailForm.material == null){
                    return 'disabled';
                } else {
                    return '';
                }
            } else {
                if (this.detailForm.equip_no == null || this.detailForm.liter == '' || this.detailForm.work_shift == null || this.detailForm.material == null || this.detailForm.reserve_no == '' || this.detailForm.work_order == ''){
                    return 'disabled';
                } else {
                    return '';
                }
            }
        },
        btnDriverAdd(){
            if (this.detailForm.driver == ''){
                return 'disabled'
            } else {
                return '';
            }
        }
    },

    methods: {
        async loginInfo(){
			const profile = await axios.get('api/profile')
			this.headerForm.created_dept = profile.data.department;

            const perRes = await axios.get('/api/permiss')
            this.permiss = perRes.data;

            // this.headerForm.refuel_date = moment(new Date()).format('YYYY-MM-DD');
            // this.refuelDateChanged();
		},

        refuelDateChanged(){
            if (this.headerForm.refuel_date > moment(new Date()).format('YYYY-MM-DD')){
                alert("Selected date is early then today!");
                this.headerForm.refuel_date = '';
                this.detailForm.head_id = '';
                this.headerData = '';
                this.detailData = '';
            } else {
                this.$axios.post('/api/fuel/header', {
                    date: this.headerForm.refuel_date,
                    dept: this.headerForm.created_dept,
                    permiss: this.permiss.fuel_all
                }).then(res => {
                    this.headerData = res.data;
                    this.detailData = '';
                    this.headerSelectedRow = '';
                    this.detailForm.head_id = '';
                })
            }
        },

        headerSelected(key, id, type){
            this.headerSelectedRow = key;
            this.detailForm.head_id = id;
            this.headerForm.cost_type = type;
            this.getDetail()
        },

        headerNew(){
            $('#header').modal('show');
            this.headerFormClear();
            this.btnHeaderUpdShow = false;
            this.btnHeaderAddShow = true;
        },

        headerAdd(){
            this.$axios.post('/api/fuel/headerAdd', this.headerForm)
            .then(res => {
                if (res.data.success){
                    $('#header').modal('hide');
                    this.refuelDateChanged();                   
                } else {
                    alert(res.data.message)
                }
            }).catch(err => {
                console.log(err);
            })
        },

        headerEdit(id){
            $('#header').modal('show');
            this.$axios.post(`/api/fuel/headerEdit/${id}`)
            .then(res => {
                this.headerFormClear();
                this.btnHeaderAddShow = false;
                this.btnHeaderUpdShow = true;

                this.headerForm.id = res.data.id;
                this.headerForm.plant = res.data.plant;
                this.headerForm.cost_dept = res.data.cost_dept;
                this.headerForm.cost_type = res.data.cost_type;
                this.headerForm.cost_no = res.data.cost_no;
                this.headerForm.approved_by = res.data.approved_by;
                this.headerForm.location = res.data.location;
            }).catch(err => {
                console.log(err);
            })
        },

        headerUpd(){
            this.$axios.post('/api/fuel/headerUpd', this.headerForm)
            .then((res)=>{
                $('#header').modal('hide');
                this.refuelDateChanged();
                // this.btnDetailNew = 'disabled';
            }).catch(err => {
                console.log(err);
            })
        },

        headerDel(id){
            // if (this.loginPermiss.al_del == 0){
            //     this.$swal.fire({
            //         text: "You don't have permission to delete!",
            //         icon: 'error',
            //         showCancelButton: false,
            //         showConfirmButton: false,
            //         allowOutsideClick: false,
            //         timerProgressBar: true,
            //         timer: 1500
            //     })
            // } else {
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
                        this.$axios.post(`/api/fuel/headerDel/${id}`)
                        .then((response)=>{

                            this.refuelDateChanged();

                        }).catch((error)=>{
                            console.log(error);
                        })
                    }
                });
            // }
        },

        getDetail(){
            this.$axios.post('/api/fuel/detail', {
                    head_id: this.detailForm.head_id
            }).then(res => {
                this.detailData = res.data;
            })
        },

        detailNew(){
            $('#detail').modal('show');
            this.detailFormClear();
            this.btnDetailUpdShow = false;
            this.btnDetailAddShow = true;
            this.btnDetailSaveShow =  true;
        },

        detailAdd(){
            this.$axios.post('/api/fuel/detailAdd', this.detailForm)
            .then(res => {
                if (res.data.success){
                    this.detailFormClear();
                    this.getDetail();
                } else {
                    alert(res.data.message)
                }
            }).catch(err => {
                console.log(err);
            })
        },

        detailSave(){
            this.detailAdd();
            $('#detail').modal('hide');
        },

        detailEdit(id){
            $('#detail').modal('show');
            this.$axios.post(`/api/fuel/detailEdit/${id}`)
            .then(res => {
                this.detailFormClear();
                this.btnDetailAddShow = false;
                this.btnDetailSaveShow =  false;
                this.btnDetailUpdShow = true;

                let f = this.detailForm;
                    f.id = res.data.id;
                    f.work_shift = res.data.work_shift;
                    f.equip_no = res.data.equip_no;
                    f.equip_descr = res.data.equip_descr;
                    f.work_order = res.data.work_order;
                    f.reserve_no = res.data.reserve_no;
                    f.material = res.data.material;
                    f.smu = res.data.smu;
                    f.liter = res.data.liter;
                    f.driver = res.data.driver;
                    f.refuel_by = res.data.refuel_by;
            }).catch(err => {
                console.log(err);
            })
        },

        detailUpd(){
            this.$axios.post('/api/fuel/detailUpd', this.detailForm)
            .then(res => {
                $('#detail').modal('hide');
                this.getDetail();
            }).catch(err => {
                console.log(err);
            })
        },

        detailDel(id){
            // if (this.loginPermiss.al_del == 0){
            //     this.$swal.fire({
            //         text: "You don't have permission to delete!",
            //         icon: 'error',
            //         showCancelButton: false,
            //         showConfirmButton: false,
            //         allowOutsideClick: false,
            //         timerProgressBar: true,
            //         timer: 1500
            //     })
            // } else {
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
                        this.$axios.post(`/api/fuel/detailDel/${id}`)
                        .then((response)=>{

                           this.getDetail();

                        }).catch((error)=>{
                            console.log(error);
                        })
                    }
                });
            // }
        },
       
        deptChanged(){
            this.typeChanged();
        },

        typeChanged(){
            if (this.headerForm.cost_type == 'WBS'){
                this.headerForm.cost_no = '';
            } else {
                this.$axios.post('/api/lookup/costno', {dept: this.headerForm.cost_dept})
                .then(res => {
                    this.headerForm.cost_type = res.data.category;
                    this.headerForm.cost_no = res.data.value;
                }) 
            }
        },

        async equipChanged(){
            const descr = await axios.post('/api/lookup/equipdescr', {
                equip_no: this.detailForm.equip_no
            })
            this.detailForm.equip_descr = descr.data.equip_descr;

            const orderno = await axios.post('/api/lookup/workorder', {
                equip_no: this.detailForm.equip_no, 
                year_mont: moment(this.headerForm.refuel_date).format('YYYYMM')
            })
            this.detailForm.work_order = orderno.data.work_order;
            this.detailForm.reserve_no = orderno.data.reserve_no;
        },

        async lookup(){
            const fdept = await axios.get('/api/lookup/fueldept')
            this.lkDept = fdept.data;

            const costtype = await axios.get('/api/lookup/costtype')
            this.lkType = costtype.data;

            const equipno = await axios.get('/api/lookup/equipno')
            this.lkEquipno = equipno.data;

            const material = await axios.get('/api/lookup/material')
            this.lkMaterial = material.data;

            const dept = await axios.post('/api/lookup/approve', {dept: this.headerForm.created_dept})
            this.lkApprove = dept.data;

            const wbs = await axios.post('/api/lookup/wbs', {dept: this.headerForm.created_dept})
            this.lkWbs = wbs.data;

            const driver = await axios.post('/api/lookup/driver', {dept: this.headerForm.created_dept})
            this.lkDriver = driver.data;


        },

        headerFormClear(){
            let f = this.headerForm;
                f.cost_dept = '';
                f.cost_type = '';
                f.cost_no = '';
                f.location = '';
                f.approved_by = '';
        },

        detailFormClear(){
            let f = this.detailForm;
                f.work_shift = 'DS';
                f.equip_no = '';
                f.equip_descr = '';
                f.work_order = '';
                f.reserve_no = '';
                f.material = '40002084';
                f.smu = '';
                f.liter = '';
                f.driver = '';
                f.refuel_by = '';
        },

        addNewReserveNo(){
            this.$axios.post('/api/fuel/addNewReserveNo', {
                reserveNo: this.detailForm.reserve_no,
                workOrder: this.detailForm.work_order
            })  
        },

        newDriver(){
            this.detailForm.driver = '';
            $('#driver').modal('show');
        },

        addNewDriver(){
            this.$axios.post('/api/lookup/addNewDriver', {
                dept: this.headerForm.created_dept,
                driver: this.detailForm.driver
            }).then(res => {
                $('#driver').modal('hide');
                this.lkDriver = res.data;
            })
        },

        dateTime(value) {
            if(value) {
                return moment(value).format('DD-MM-YYYY');
            }
        },

        dateTime2(value) {
            if(value) {
                return moment(value).format('DD-MM-YYYY HH:mm');
            }
        }
    },

    created(){
        this.loginInfo();
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

<style>
    .form-control:disabled{
        background-color: white;
        opacity: 1;
    }

    .add-hover:hover{
        color: blue;
        font-weight: bold;
    }
</style>