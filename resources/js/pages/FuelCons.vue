<template>
    <div class="card">
        <div class="card-body">
            <div class="breadcrumb-header justify-content-between align-items-center mb-3 mt-0" >
                <div class="d-flex">
                    <h4 class="card-title text-muted mb-0 my-auto">Fuel consumption of {{ mont }}, {{ year }}</h4>
                </div>
                <div class="d-flex my-xl-auto right-content">
                    <div class="dropdown btn-group" role="group">
                        <button aria-expanded="false" class="btn btn-primary dropdown-toggle-split" style="height: 39.5px" data-bs-toggle="dropdown" id="dropdownMenuButton1" type="button">{{ mont }}<i class="fas fa-caret-down ms-2"></i></button>
                        <div class="dropdown-menu dropdown-menu-right overflow-auto cur-pointer" aria-labelledby="dropdownMenuDate1" x-placement="bottom-end" style="height: 210px">
                            <a class="dropdown-item" v-for="lst in lkMont" :key="lst.value" @click="montChange(lst.value)">                            
                                {{ lst.value }}
                            </a>
                        </div>

                        <button aria-expanded="false" class="btn btn-primary dropdown-toggle-split rounded-right" style="height: 39.5px" data-bs-toggle="dropdown" id="dropdownMenuButton2" type="button">{{ year }}<i class="fas fa-caret-down ms-2"></i></button>
                        <div class="dropdown-menu dropdown-menu-right overflow-auto cur-pointer" aria-labelledby="dropdownMenuDate2" x-placement="bottom-end" style="height: 210px">
                            <a class="dropdown-item" v-for="lst in lkYear" :key="lst.value" @click="yearChange(lst.value)">                            
                                {{ lst.value }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-3">
                    <div class="table-responsive border" style="height: 250px">
                        <table class="table main-table-reference text-nowrap cur-pointer">
                            <thead class="position-sticky" style="top: -1px">
                                <tr>
                                    <th style="letter-spacing: 0px; padding: 5px 10px; height: 27.08px" class="fw-bold pd-y-5">Date</th>
                                </tr>
                            </thead>
                            <tbody> 
                                <tr class="tr-hover" v-for="(lst, key) in dateData" :key="lst.id" @click="selectedDate(key, lst.calendar)" :style="key === selDateRow ? 'background-color: #dadee7; border-left: 1px solid #0162e8; color: blue' : ''">
                                    <td style="border: none; padding: 4px 10px">{{ dateTime(lst.calendar) }}</td>
                                </tr>                                                                                            
                            </tbody>
                        </table>
                    </div>            
                </div>
                
                <!-- Header table -->
                <div class="col-xl-10 col-lg-9 col-md-8 col-sm-9 ps-sm-0 pt-sm-0 pt-3 ">
                    <div class="table-responsive border ht-sm-250 ht-auto">
                        <table class="table main-table-reference text-nowrap" >
                            <thead class="position-sticky" style="top: -1px">
                                <tr>
                                    <th v-if="!!parseInt(permiss.fuel_all)" style="letter-spacing: 0px; padding: 5px 10px">Department</th>
                                    <th style="letter-spacing: 0px; padding: 5px 10px">
                                        <div v-if="!!parseInt(permiss.fuel_all)">Department Use</div>
                                        <div v-else>Department</div>
                                    </th>
                                    <th style="letter-spacing: 0px; padding: 5px 10px">Type</th>
                                    <th style="letter-spacing: 0px; padding: 5px 10px">Cost</th>
                                    <th style="letter-spacing: 0px; padding: 5px 10px">Approve by</th>
                                    <th style="letter-spacing: 0px; padding: 5px 10px">Locations</th>
                                    <th style="letter-spacing: 0px; padding: 5px 10px; width: 80%">
                                        <span v-if="btnHeadNew == 'disabled'">New Record</span>
                                        <span v-else class="add-hover cur-pointer" title="Add new record" @click="headerNew()">New Record</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody> 
                                <tr class="tr-hover cur-pointer" v-for="(lst, key) in headData" :key="lst.id" @click="selectedHead(key, lst.id, lst.cost_type)" :style="key === selHeadRow ? 'background-color: #dadee7; border-left: 1.02px solid #0162e8; color: blue' : ''">
                                    <td v-if="!!parseInt(permiss.fuel_all)" style="padding: 3px 10px">{{ lst.dept }}</td>
                                    <td style="padding: 3px 10px">{{ lst.dept_use }}</td>
                                    <td style="padding: 3px 10px">{{ lst.cost_type }}</td>
                                    <td style="padding: 3px 10px">{{ lst.cost_no }}</td>
                                    <td style="padding: 3px 10px">{{ lst.approve }}</td>
                                    <td style="padding: 3px 10px" class="laofont">{{ lst.location }}</td>
                                    <td style="padding: 0px 4px; vertical-align: middle">
                                        <div class="d-flex justify-content-start">
                                            <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" data-bs-toggle="dropdown" title="Tools">
                                                <i class="mdi mdi-dots-horizontal text-gray" style="font-size: 13px"></i>
                                            </button> 
                                            <div class="dropdown-menu tx-13">
                                                <div class="dropdown-item cur-pointer dropdown-hover" @click="headEdit(lst.id)">
                                                    <i class="fe fe-edit me-2"></i><span>Edit</span>
                                                </div>
                                                <div class="dropdown-item cur-pointer dropdown-hover" @click="headDel(lst.id)">
                                                    <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>                                                                                         
                            </tbody>
                        </table>
                    </div>                       
                </div>
            </div>
            
            <!-- Detail table -->
            <div class="table-responsive border mt-3 ht-sm-450 ht-auto">
                <table class="table main-table-reference text-nowrap">
                    <thead class="position-sticky" style="top: -1px">
                        <tr>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Equip No</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Description</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Liter</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">smu</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Driver</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Refuel Date</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Shift</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Material</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Work Order</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Reserve No</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Refuel By</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px">Remarks</th>
                            <th style="letter-spacing: 0px; padding: 5px 10px; width: 80%">
                                <span v-if="btnDetailNew == 'disabled'">New Record</span>
                                <span v-else class="add-hover cur-pointer" title="Add new record" @click="detailNew()">New Record</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr class="tr-hover" v-for="lst in detailData" :key="lst.id">
                            <td style="padding: 3px 10px">{{ lst.equip_no }}</td>
                            <td style="padding: 3px 10px">{{ lst.equip_descr }}</td>
                            <td style="padding: 3px 10px" class="text-end">{{ lst.liter }}</td>
                            <td style="padding: 3px 10px" class="text-end">{{ lst.smu }}</td>
                            <td style="padding: 3px 10px">{{ lst.driver }}</td>
                            <td style="padding: 3px 10px">{{ lst.refuel_date }}</td>
                            <td style="padding: 3px 10px">{{ lst.shift }}</td>
                            <td style="padding: 3px 10px">{{ lst.material_descr }}</td>
                            <td style="padding: 3px 10px">{{ lst.work_order }}</td>
                            <td style="padding: 3px 10px" class="text-center">{{ lst.reserve_no }}</td>
                            <td style="padding: 3px 10px">{{ lst.refuel_by }}</td>
                            <td style="padding: 3px 10px">{{ lst.remarks }}</td>
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
                    </tbody>
                </table>
            </div>

            <!-- Modal Header -->
            <div class="modal fade effect-scale" id="header" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="headLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted">Reservation Title</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-5 col-md-12 col-sm-12 col-12">
                                    <div class="form-group">
                                        <label class="mb-0">Department / Company <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="headForm.deptuse" searchable="true" placeholder="Select" @select="chageDept()" :options="lkFDept"/>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Type <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="headForm.costtype" placeholder="Select" @select="changeType()" :options="lkFType"/>
                                    </div>
                                </div>                                
                                <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Cost <span class=" text-danger">*</span></label>
                                        <Multiselect v-if="headForm.costtype == 'WBS'" class="multi-color" v-model="headForm.costno" placeholder="Select" :options="lkFWbs"/>
                                        <!-- <input v-else-if="headForm.costtype == 'IO'" type="text" class="form-control" placeholder="IO..." v-model="headForm.costno"> -->
                                        <cleave v-else :options="options"  class="form-control" v-model="headForm.costno" placeholder="Cost center..."/>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-12">
                                    <div class="form-group">
                                        <label class="mb-0">Approve by</label> 
                                        <Multiselect class="multi-color" v-model="headForm.approve" placeholder="Select" :options="lkApprove"/>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-12">
                                    <div class="form-group">
                                        <label class="mb-0">Work Location</label>
                                        <input type="text" class="form-control laofont" placeholder="Work locations..." v-model="headForm.location">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="btnHeadUpd" type="button" class="btn btn-info btn-b" :class="btnHeadAddShow" @click="headUpd()"><i class="fe fe-check-circle"></i> 
                                <span class="mx-1">Update</span>
                            </button>
                            <button v-if="btnHeadAdd" type="button" class="btn btn-primary" :class="btnHeadAddShow" @click="headAdd()"><i class="fe fe-plus"></i> 
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
            <div class="modal fade effect-scale" id="detail" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted">Reservation Details</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="mb-0">Equipment No.<span class="text-danger">*</span></label> 
                                        <input v-if="headForm.costtype == 'IO'" type="text" class="form-control laofont" placeholder="Work locations..." v-model="detailForm.equipno">
                                        <Multiselect v-else class="multi-color" v-model="detailForm.equipno" placeholder="Select" searchable="true" @select="equipChange()" :options="lkEquipno"/>
                                    </div>
                                </div>
                                <div class="col-lg-9 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <label class="mb-0">Description</label>
                                        <input v-if="headForm.costtype == 'IO'" type="text" class="form-control laofont" placeholder="Equipment description..." v-model="detailForm.equipdescr">
                                        <input v-else type="text" class="form-control laofont" disabled placeholder="Equipment description..." v-model="detailForm.equipdescr">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Liter <span class="text-danger">*</span></label>
                                        <cleave :options="options1" class="form-control" v-model="detailForm.liter" placeholder="Liter..."/>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">SMU</label>
                                        <cleave :options="options" class="form-control" v-model="detailForm.smu" placeholder="SMU number..."/>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Shift <span class="text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="detailForm.shift" placeholder="Select" :options="lkShift"/>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Refuel Date <span class="text-danger">*</span></label>
                                        <input v-if="headForm.costtype == 'IO'" type="date" class="form-control laofont" placeholder="" v-model="detailForm.refueldate">
                                        <input v-else type="date" class="form-control laofont" placeholder="" v-model="detailForm.refueldate" @change="dateChange()">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Driver</label>
                                        <input type="text" class="form-control" placeholder="Driver name..." v-model="detailForm.driver">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Refuel By</label>
                                        <input type="text" class="form-control" placeholder="Refuel by..." v-model="detailForm.refuelby">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-6">
                                    <div class="form-group">
                                        <label v-if="headForm.costtype == 'IO'" class="mb-0">Reserve No</label>
                                        <label v-else class="mb-0">Reserve No <span class="text-danger">*</span></label>
                                        <cleave :options="options"  class="form-control" v-model="detailForm.reserveno" placeholder="Reserve no..."/>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-8 col-sm-8 col-6">
                                    <div class="form-group">
                                        <label v-if="headForm.costtype == 'IO'" class="mb-0">Work Order</label>
                                        <label v-else class="mb-0">Work Order <span class="text-danger">*</span></label>
                                        <cleave :options="options"  class="form-control" v-model="detailForm.workorder" placeholder="Work order no..."/>
                                    </div>
                                </div>
                                
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label class="mb-0">Material <span class="text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="detailForm.material" placeholder="Select" :options="lkMaterial"/>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label class="mb-0">Remark</label>
                                        <input type="text" class="form-control laofont" placeholder="Remarks..." v-model="detailForm.remarks">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="btnDetailUpd" type="button" class="btn btn-info btn-b" :class="btnDetailAddShow" @click="detailUpd()"><i class="fe fe-check-circle"></i> 
                                <span class="mx-1">Update</span>
                            </button>
                            <button v-if="btnDetailAdd" type="button" class="btn btn-primary" :class="btnDetailAddShow" @click="detailAdd()"><i class="fe fe-plus"></i> 
                                <span class="mx-1">Add</span>
                            </button>
                            <button v-if="btnDetailSav" type="button" class="btn btn-primary" :class="btnDetailAddShow" @click="detailSave()"><i class="fe fe-save"></i> 
                                <span class="mx-1">Save</span>
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fe fe-x"></i> 
                                <span class="mx-1">Close</span>
                            </button>
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
            profile: [],
            lkYear: [],
            lkMont: [],
            lkFDept: [],
            lkFType: [],
            lkFWbs: [],
            lkApprove: [],
            lkEquipno: [],
            lkMaterial: [],
            lkShift: ['DS', 'NS'],

            dateData: [],
            headData: [],
            detailData: [],

            year: new Date().getFullYear(),
            mont: new Date().toLocaleString('en-us', { month: 'long' }),
            selDateRow: '',
            selHeadRow: '',
            headForm: {id: '', date: '', dept: '', deptuse: '', costtype: '', costno: '', location: '', approve: ''},
            detailForm: {id: '', headid: '', refueldate: '', shift: 'DS', equipno: '', equipdescr: '', workorder: '', reserveno: '', material: '40002084', smu: '', liter: '', driver: '', refuelby: '', remarks: ''},
            
            btnHeadUpd: '',
            btnHeadAdd: '',
            btnDetailUpd: '',
            btnDetailAdd: '',
            btnDetailSav: '',
            btnHeadNew: 'disabled',
            btnDetailNew: 'disabled',
            
            
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
        btnHeadAddShow(){
            if (this.headForm.deptuse == null || this.headForm.costtype == null || this.headForm.costno == '' || this.headForm.costno == null){
                return 'disabled';
            } else {
                return '';
            }
        },

        btnDetailAddShow(){
            if (this.headForm.costtype == 'IO'){
                if (this.detailForm.equipno == '' || this.detailForm.liter == '' || this.detailForm.shift == null || this.detailForm.refueldate == '' || this.detailForm.material == null){
                    return 'disabled';
                } else {
                    return '';
                }
            } else {
                if (this.detailForm.equipno == null || this.detailForm.liter == '' || this.detailForm.shift == null || this.detailForm.refueldate == '' || this.detailForm.material == null || this.detailForm.reserveno == '' || this.detailForm.workorder == ''){
                    return 'disabled';
                } else {
                    return '';
                }
            }
        }
    },

    methods: {
        chageDept(){
            this.changeType();
        },

        async changeType(){
            if (this.headForm.costtype == 'WBS'){
                const wbs = await axios.post('/api/lookup/wbs', {
                    dept: this.profile.department
                })
                this.headForm.costno = '';
                this.lkFWbs = wbs.data;
            } else {
                const costno = await axios.post('/api/lookup/costno', {
                    dept: this.headForm.deptuse
                })
                this.headForm.costtype = costno.data.category;
                this.headForm.costno = costno.data.value;
            }
        },

        selectedDate(key, date){
            this.selDateRow = key;
            this.detailData = '';
            this.selHeadRow = '';
            this.btnHeadNew = '';
            this.headForm.date = date;  
            this.headForm.dept = this.profile.department;

            this.$axios.post('/api/fuel/header', {
                date: date,
                permiss: this.permiss.fuel_all,
                dept: this.profile.department
            }).then(res =>{
                this.headData = res.data;
            })
        },

        selectedHead(key, id, type){
            this.selHeadRow = key;
            this.btnDetailNew = '';
            this.detailForm.headid = id;
            this.headForm.costtype = type;

            this.getDetail();
        },

        async getDate(){
            const res = await axios.post('/api/fuel/date', {
                mont: this.mont,
                year: this.year
            })

            this.dateData = res.data;
        },

        headerNew(){
            $('#header').modal('show');
            this.headFormClear();
            this.getLookup();
            this.getApprove();
            this.btnHeadUpd = false;
            this.btnHeadAdd = true;
        },

        headAdd(){
            this.btnDetailNew = 'disabled'
            this.$axios.post('/api/fuel/headadd', this.headForm)
            .then(res => {
                if (res.data.success){
                    $('#header').modal('hide');
                    this.selectedDate(this.selDateRow, this.headForm.date);                   
                } else {
                    alert(res.data.message)
                }
            }).catch(err => {
                console.log(err);
            })
        },

        headEdit(id){
            $('#header').modal('show');
            this.$axios.post(`/api/fuel/headedit/${id}`)
            .then(res => {
                this.headFormClear();
                this.getLookup();
                this.getApprove();
                this.btnHeadAdd = false;
                this.btnHeadUpd = true;

                this.headForm.id = res.data.id;
                this.headForm.deptuse = res.data.dept_use;
                this.headForm.costtype = res.data.cost_type;
                this.headForm.costno = res.data.cost_no;
                this.headForm.approve = res.data.approve;
                this.headForm.location = res.data.location;
            }).catch(err => {
                console.log(err);
            })
        },

        headUpd(){
            this.$axios.post('/api/fuel/headupd', this.headForm)
            .then((response)=>{
                $('#header').modal('hide');
                this.selectedDate(this.selDateRow, this.headForm.date);
                this.btnDetailNew = 'disabled';
            }).catch(err => {
                console.log(err);
            })
        },

        headDel(id){
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
                        this.$axios.post(`/api/fuel/headdel/${id}`)
                        .then((response)=>{

                            this.selectedDate(this.selDateRow, this.headForm.date);

                        }).catch((error)=>{
                            console.log(error);
                        })
                    }
                });
            // }
        },

        headFormClear(){
            let f = this.headForm;
                f.deptuse = '';
                f.costtype = '';
                f.costno = '';
                f.location = '';
                f.approve = '';
        },

        detailFormClear(){
            let f = this.detailForm;
                f.shift = 'DS';
                f.equipno = '';
                f.equipdescr = '';
                f.workorder = '';
                f.reserveno = '';
                f.material = '40002084';
                f.smu = '';
                f.liter = '';
                f.driver = '';
                f.refuelby = '';
                f.remarks = '';
        },

        detailNew(){
            $('#detail').modal('show');
            this.detailForm.refueldate = '';
            this.detailFormClear();
            this.getDetailLookup();
            this.btnDetailUpd = false;
            this.btnDetailAdd = true;
            this.btnDetailSav =  true;
        },

        getDetail(){
            this.$axios.post('/api/fuel/detail', {
                    headid: this.detailForm.headid
            }).then(res => {
                this.detailData = res.data;
            })
        },

        detailAdd(){
            this.$axios.post('/api/fuel/detailadd', this.detailForm)
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
            this.$axios.post(`/api/fuel/detailedit/${id}`)
            .then(res => {
                this.detailForm.refueldate = '';
                this.detailFormClear();
                this.getDetailLookup();
                this.btnDetailAdd = false;
                this.btnDetailSav =  false;
                this.btnDetailUpd = true;

                let f = this.detailForm;
                    f.id = res.data.id;
                    f.refueldate = res.data.refuel_date;
                    f.shift = res.data.shift;
                    f.equipno = res.data.equip_no;
                    f.equipdescr = res.data.equip_descr;
                    f.workorder = res.data.work_order;
                    f.reserveno = res.data.reserve_no;
                    f.material = res.data.material;
                    f.smu = res.data.smu;
                    f.liter = res.data.liter;
                    f.driver = res.data.driver;
                    f.refuelby = res.data.refuel_by;
                    f.remarks = res.data.remarks;
            }).catch(err => {
                console.log(err);
            })
        },

        detailUpd(){
            this.$axios.post('/api/fuel/detailupd', this.detailForm)
            .then((response)=>{
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
                        this.$axios.post(`/api/fuel/detaildel/${id}`)
                        .then((response)=>{

                           this.getDetail();

                        }).catch((error)=>{
                            console.log(error);
                        })
                    }
                });
            // }
        },

        async getProfile(){
			const response = await axios.get('api/profile')
			this.profile = response.data;
		},

        async getPermiss(){
            const response = await axios.get('/api/permiss')
            this.permiss = response.data;
        },

        getYearLK(){
            this.$axios.get('/api/lookup/year')
            .then(res => this.lkYear = res.data)
        },

        getMontLK(){
            this.$axios.get('/api/lookup/month')
            .then(res => this.lkMont = res.data)
        },

        async getLookup(){
            const fdept = await axios.get('/api/lookup/fueldept')
            this.lkFDept = fdept.data;

            const costtype = await axios.get('/api/lookup/costtype')
            this.lkFType = costtype.data;
        },

        async getDetailLookup(){
            const equipno = await axios.get('/api/lookup/equipno')
            this.lkEquipno = equipno.data;

            const material = await axios.get('/api/lookup/material')
            this.lkMaterial = material.data;

        },

        getApprove(){
            this.$axios.post('/api/lookup/approve', {
                dept: this.profile.department
            }).then(res => this.lkApprove = res.data)
        },

        equipChange(){
            this.$axios.post('/api/lookup/equipdescr', {
                equipno: this.detailForm.equipno
            })
            .then(res => {
                this.detailForm.equipdescr = res.data.equip_descr;
                this.dateChange();
            })
        },

        dateChange(){
            this.$axios.post('/api/lookup/workorder', {
                equipno: this.detailForm.equipno, 
                yearmont: moment(this.detailForm.refueldate).format('YYYYMM')
            })
            .then(res => {
                this.detailForm.workorder = res.data.work_order;
                this.detailForm.reserveno = res.data.reserve_no;
            })
        },

        yearChange(value){
            this.year = value;
            this.getDate();
            this.headData = '';
            this.detailData = '';
        },

        montChange(value){
            this.mont = value;
            this.getDate();
            this.headData = '';
            this.detailData = '';
        },

        formatNumber(value) {
			let val = (value / 1).toFixed(0).replace(",", ".");
			return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		},

        dateTime(value) {
            if(value) {
                return moment(value).format('DD-MM-YYYY');
            }
        }
    },

    created(){
        this.getDate();
        this.getMontLK();
        this.getYearLK();
        this.getProfile();
        this.getPermiss();
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