<template>
    <div>
        <div class="card mt-4">
            <div class="card-body">
                <div v-if="showList">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Employee info.</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>

                    <!-- Search and add button -->
                    <div class="breadcrumb-header justify-content-between my-0">
                        <div class="col-md-4 px-0">
                            <div class="pos-relative">
                                <input class="form-control pd-l-30" type="text" placeholder="Search by name" v-model="search" @input="searchChange()" >
                                <i class="fe fe-search search-i"></i>
                                <button class="btn btn-icon btn-sm search-c-i search-c" v-if="btnClear" @click="searchClear()"><i class="fe fe-x"></i></button>
                            </div>
                        </div>
                        <div class="d-flex my-xl-auto right-content">
                            <button type="button" class="btn btn-primary" @click="onAdd()"><i class="fa fa-user-plus"></i> 
                                <span class="mx-1">Add</span>
                            </button>
                        </div>
                    </div>

                    <!-- Employee table -->
                    <div class="table-responsive userlist-table">
                        <table class="table card-table table-vcenter text-nowrap mb-0 mt-2">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="wd-80"><span>Image</span></th>
                                    <th style="width:50px"><span>Name Surname</span></th>
                                    <th><span>Position</span></th>
                                    <th><span>Department</span></th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="tr-hover" v-for="list in empList.data" :key="list.user_id">
                                    <td>
                                        <img alt="avatar" class="rounded-circle avatar-md me-2 cur-pointer" src="assets/img/faces/2.jpg" @click="onPrev(list.user_id)">
                                        <!-- <img alt="avatar" class="rounded-circle avatar-md me-2" src="assets/img/brand/ae.jpg" @click="onPrev()> -->
                                    </td>
                                    <td>
                                        {{ list.name }}<br>
                                        <span class="noto-lao"> {{ list.name_lao }} </span>
                                    </td>
                                    <td> {{ list.position}} </td>
                                    <td> {{ list.dept}} </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary" v-if="btnPrev" @click="onPrev(list.user_id)">
                                            <i class="fe fe-search"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-info btn-b" v-if="btnEdit" @click="onEdit(list.user_id)">
                                            <i class="las la-pen"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-danger" v-if="btnDel" @click="onDel(list.user_id)">
                                            <i class="fe fe-trash-2"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <pagination :pagination="empList" @paginate="getEmpList($event)" :offset="2" ></pagination>
                    </div>
                </div> <!-- End employee list -->

                <!-- Add and Edit employee -->
                <div v-if="showAdd">
                    <div class="row">
                        <div class="col-xxl-2 mt-2">
                            <div style="height: 200px; width: 100%;">
                                <img class="cur-pointer" style="width: 160px; height: 200px; border: solid 1px #cccc;" title="Choose an Image" :src="addData.file" @click="chooseImage">
                                <!-- <img class="cur-pointer" style="width: 160px; height: 200px; border: solid 1px #cccc;" title="Choose an Image" src="assets/img/no2.jpg" @click="chooseImage"> -->
                                <input class="d-none" ref="fileInput" type="file" @change="onSelectFile">
                            </div> 
                            <label class="rdiobox mt-4 ms-2 cur-pointer"><input name="rdio" type="radio" value="Male" checked="" v-model="addData.gender"><span>Male</span></label>
                            <label class="rdiobox mb-4 ms-2 cur-pointer"><input name="rdio" type="radio" value="Female" v-model="addData.gender"><span>Female</span></label>                                
                        </div>

                        <div class="col-xxl-10">
                            <!-- Row1 -->
                            <div class="row">
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Name Eng  <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Name..." v-model="addData.name">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Surname Eng</label>
                                        <input type="text" class="form-control" placeholder="Surname..." v-model="addData.surname">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12">
                                    <div class="form-group">
                                        <label class="mb-0">Phone Number</label>
                                        <input type="text" class="form-control" placeholder="Phone numbers..." v-model="addData.phone">
                                    </div>
                                </div>
                            </div>

                            <!-- Row2 -->
                            <div class="row">
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Name Lao  <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control noto-lao" placeholder="ຊື່..." v-model="addData.namelao">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Surname Lao</label>
                                        <input type="text" class="form-control noto-lao" placeholder="ນາມສະກຸນ..." v-model="addData.surnamelao">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="mb-0">Birthday</label>
                                        <input type="date" class="form-control" v-model="addData.birthday">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <label class="mb-0">Email</label>
                                        <input type="eamil" class="form-control" placeholder="Email..." v-model="addData.email">
                                    </div>
                                </div>
                            </div>

                            <!-- Row3 -->
                            <h6 class="text-muted mt-2">Employee Address</h6>
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-4">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Country  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="addData.country" placeholder="Select" searchable="true" :options="countryLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-8 col-md-6 col-sm-8">
                                    <div class="form-group">
                                        <label class="mb-0">Province</label>
                                        <input type="text" class="form-control" placeholder="Province..." v-model="addData.province">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">District</label>
                                        <input type="text" class="form-control" placeholder="District..." v-model="addData.district">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Village</label>
                                        <input type="text" class="form-control" placeholder="Village..." v-model="addData.village">
                                    </div>
                                </div>
                            </div>

                            <!-- Employee details -->
                            <div v-if="showDetail">
                                <h6 class="text-muted mt-2">Employee Details</h6>
                                <!-- Row4 -->
                                <div class="row">
                                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Start Date  <span class=" text-danger">*</span></label>
                                            <input type="date" class="form-control" v-model="addData.startdate">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">End Date</label>
                                            <input type="date" class="form-control" v-model="addData.enddate">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Position  <span class=" text-danger">*</span></label> 
                                            <Multiselect v-model="addData.position" placeholder="Select" searchable="true" :options="positionLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Contract Type</label> 
                                            <Multiselect v-model="addData.contract" placeholder="Select" :options="contractLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Levels</label> 
                                            <Multiselect v-model="addData.levels" placeholder="Select" :options="levelsLK"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row5 -->
                                <div class="row">
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Employee ID</label>
                                            <input type="text" class="form-control" placeholder="Employee id..." v-model="addData.employeeid">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Scan ID  <span class=" text-danger">*</span></label>
                                            <input type="number" class="form-control" placeholder="Scan id..." v-model="addData.scanid">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Food ID</label>
                                            <input type="text" class="form-control" placeholder="Food id..." v-model="addData.foodid">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Roster  <span class=" text-danger">*</span></label> 
                                            <Multiselect v-model="addData.roster" placeholder="Select" :options="rosterLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-4 col-sm-4 col-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Scan Times  <span class=" text-danger">*</span></label> 
                                            <Multiselect v-model="addData.scantimes" placeholder="Select" :options="scantimesLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Working hrs  <span class=" text-danger">*</span></label>
                                            <input type="number" class="form-control" placeholder="Working hrs..." v-model="addData.hours">
                                        </div>
                                    </div>
                                </div>
                                <!-- Row6 -->
                                <div class="row">
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Site  <span class=" text-danger">*</span></label> 
                                            <Multiselect v-model="addData.site" placeholder="Select" :options="siteLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-9 col-md-8 col-sm-8">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Department  <span class=" text-danger">*</span></label> 
                                            <Multiselect v-model="addData.dept" placeholder="Select" searchable="true" :options="deptLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Section</label> 
                                            <Multiselect v-model="addData.section" placeholder="Select" searchable="true" :options="sectionLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Crew</label> 
                                            <Multiselect v-model="addData.crew" placeholder="Select" searchable="true" :options="crewLK"/>
                                        </div>
                                    </div>
                                </div>
                            </div>  <!-- End of employee details --> 
                        </div>
                    </div>
                    
                    <!-- Tabs -->
                    <div class="panel panel-primary tabs-style-1 mt-4" v-if="showTab">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li class="nav-item"><a href="#tab1" class="nav-link active" data-bs-toggle="tab">Employee History</a></li>
                                    <li class="nav-item"><a href="#tab2" class="nav-link" data-bs-toggle="tab">Emergency Contact</a></li>
                                    <li class="nav-item"><a href="#tab3" class="nav-link" data-bs-toggle="tab">Bank Acount</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1" style="height: 270px">
                                    

                                    
                                </div>
                                <div class="tab-pane" id="tab2" style="height: 270px">
                                    


                                </div>
                                <div class="tab-pane" id="tab3" style="height: 270px">
                                    



                                </div>
                            </div>
                        </div>
                    </div> <!-- EndTabs -->

                    <div class="d-flex justify-content-end mt-2">
                        <button type="button" class="btn btn-primary" :class="btnAddNewShow" @click="onAddNewEmp()"><i class="fa fa-plus"></i> 
                            <span class="mx-1">Add</span>
                        </button>
                        <button type="button" class="btn btn-danger ms-2" @click="onAddCancel()"><i class="fa fa-times"></i> 
                            <span class="mx-1">Cancel</span>
                        </button>
                    </div>

                </div>

                <!-- Modal employee preview -->
                <div class="modal fade" id="empPreview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="empPreviewLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl"> <!-- modal-dialog-centered  -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- <h5 class="modal-title" id="staticBackdropLabel">Sign In</h5> -->
                                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                <h6 class="modal-title text-muted main-content-label">Employee Info.</h6>
                                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>

                            </div>
                            <div class="modal-body">
                                <h1>Preview</h1>
                                {{ countryLK }}

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Insert Data</button>
                            </div>
                        </div>
                    </div>                                              
                </div> <!-- End of modal employee preview -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppEmployee',

    data() {
        return {
            showList: true,
            showAdd: '',
            showDetail: '',
            showTab: '',
            btnPrev: true,
            btnEdit: false,
            btnDel: false,
            btnClear: false,
            search: '',
            
            empList: [],
            countryLK: [],
            positionLK: [],
            statusLK: [],
            contractLK: [],
            levelsLK: [],
            rosterLK: [],
            scantimesLK: [],
            siteLK: [],
            deptLK: [],
            sectionLK: [],
            crewLK: [],

            addData: {
                gender: 'Male',
                name: '',
                surname: '',
                namelao: '',
                surnamelao: '',
                phone: '',
                birthday: '',
                email: '',
                country: '',
                province: '',
                district: '',
                village: '',
                startdate: '',
                enddate: '',
                position: '',
                status: 'Current',
                contract: '',
                levels: '',
                employeeid: '',
                scanid: '',
                foodid: '',
                roster: '',
                scantimes: '',
                hours: '9',
                site: '',
                dept: '',
                secttion: '',
                crew: '',
                file: 'assets/img/no2.jpg'
            }

        };
    },

    mounted() {
        
    },

    // watch:{
	// 	search(){
	// 		if(this.search == ''){
	// 			this.getEmpList();
	// 		}
	// 	}
	// },

    computed:{
        btnAddNewShow(){
            if(this.addData.name == '' || this.addData.namelao == '' || this.addData.country == '' || this.addData.startdate == '' || this.addData.status == '' || this.addData.scanid == '' || this.addData.roster == '' || this.addData.scantimes == '' || this.addData.hours == '' || this.addData.site == '' || this.addData.dept == '' ){
                return 'disabled'
            } else {
                return ''
            }
        }
    },

    methods: {
        getEmpList(page){
            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
				this.$axios.get(`/api/employee?page=${page}&search=${this.search}`)
				.then((response)=>{
						this.empList = response.data;
				}).catch((error)=>{
					console.log(error);
				})
			});
        },

        searchChange(){
            if(this.search.length >0){
                this.btnClear = true;
                this.getEmpList();
            } else {
                this.btnClear = false;
                this.getEmpList();
            }
        },

        searchClear(){
            this.search = '';
            this.btnClear = false,
            this.getEmpList();
        },

        onAdd(){
            this.showList = false;
            this.showAdd = true;
            this.showDetail = true;
            this.showTab = false;
            
            this.addData.gender = 'Male';
            this.addData.name = '';
            this.addData.surname = '';
            this.addData.namelao = '';
            this.addData.surnamelao = '';
            this.addData.phone = '';
            this.addData.birthday = '';
            this.addData.email = '';
            this.addData.country = '';
            this.addData.province = '';
            this.addData.district = '';
            this.addData.village = '';
            this.addData.startdate = '';
            this.addData.enddate = '';
            this.addData.position = '';
            this.addData.contract = '';
            this.addData.levels = '';
            this.addData.employeeid = '';
            this.addData.scanid = '';
            this.addData.foodid = '';
            this.addData.roster = '';
            this.addData.scantimes = '';
            this.addData.hours = '9';
            this.addData.site = '';
            this.addData.dept = '';
            this.addData.secttion = '';
            this.addData.crew = ''

            this.getCountryLK();
            this.getPositionLK();
            this.getContractLK();
            this.getLevelsLK();
            this.getRosterLK();
            this.getScantimesLK();
            this.getSiteLK();
            this.getDeptLK();
            this.getSectionLK();
            this.getCrewLK();
        },

        onPrev(user_id){
            $('#empPreview').modal('show');

            this.$axios.get('/sanctum/csrf-cookie').then((response)=>{
                this.$axios.post(`/api/employee/prev/${user_id}`).then((response)=>{

                        this.prevData = response.data;

                }).catch((error)=>{
                    console.log(error);
                })
            });
        },

        onEdit(id){
            this.showList = false;
            this.showAdd = true;
            this.showDetail = false;
            this.showTab = true;

            this.getCountryLK();

            this.$axios.get('/sanctum/csrf-cookie').then((response)=>{
                this.$axios.post(`/api/employee/edit/${id}`)
                .then((response)=>{
                        this.addData.gender = response.data[0].gender;
                        this.addData.name = response.data[0].name;
                        this.addData.surname = response.data[0].surname;
                        this.addData.phone = response.data[0].phone;
                        this.addData.namelao = response.data[0].name_lao;
                        this.addData.surnamelao = response.data[0].surname_lao;
                        this.addData.birthday = response.data[0].birthday;
                        this.addData.email = response.data[0].email;
                        this.addData.country = response.data[0].country;
                        this.addData.province = response.data[0].province;
                        this.addData.district = response.data[0].district;
                        this.addData.village = response.data[0].village;


                }).catch((error)=>{
                    console.log(error);
                })
            });
        },

        onDel(user_id){
            this.$swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete!',
                cancelButtonText: 'Cancel',
                allowEnterKey: false,
                allowOutsideClick: false,
                // showConfirmButton: false,
                //         timer: 1500
            }).then((result)=>{
                if(result.isConfirmed){
                    this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
						this.$axios.post(`/api/employee/delete/${user_id}`)
						.then((response)=>{

                            this.search = ''
                            this.btnClear = false
						    this.getEmpList()

                            this.$swal.fire({
                                title: 'Deleted!',
                                text: 'Your file has been deleted.',
                                icon: 'success',
                                showCancelButton: false,
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                timer: 1000
                            })
                        }).catch((error)=>{
							console.log(error);
						})
					})
                }
            });
        },

        onAddCancel(){
            this.showList = true;
            this.showAdd = false;
        },

        onAddNewEmp(){
            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post('api/employee/addNew', this.addData, {headers:{"Content-Type": "multipart/form-date"}})
                .then((response)=>{

                    if(response.data.success){
                        this.showList = true,
                        this.showAdd = false;
                    } else {
                        alert(response.data.message)
                    }
                }).catch((error)=>{
                    console.log(error);
                })
            });
        },

        chooseImage(){
            this.$refs.fileInput.click()
        },

        onSelectFile(){
            const input = this.$refs.fileInput
            const files = input.files
            if (files && files[0]) {
                const reader = new FileReader
                reader.onload = e => {
                this.addData.file = e.target.result
                }
                reader.readAsDataURL(files[0])
                this.$emit('input', files[0])
            }
        },

        userType(){
            if(this.$store.getters.usertype == 'admin'){
                this.btnEdit = true;
            } else if(this.$store.getters.usertype == 'full'){
                this.btnEdit = true;
                this.btnDel = true;
            }
        },

        getCountryLK(){
            this.$axios.get('/api/lookup/country').then((response)=>{
                this.countryLK = response.data;
            });
        },

        getPositionLK(){
            this.$axios.get('/api/lookup/position').then((response)=>{
                this.positionLK = response.data;
            });
        },

        getStatusLK(){
            this.$axios.get('/api/lookup/status').then((response)=>{
                this.statusLK = response.data;
            });
        },

        getContractLK(){
            this.$axios.get('/api/lookup/contract').then((response)=>{
                this.contractLK = response.data;
            });
        },

        getLevelsLK(){
            this.$axios.get('/api/lookup/levels').then((response)=>{
                this.levelsLK = response.data;
            });
        },

        getRosterLK(){
            this.$axios.get('/api/lookup/roster').then((response)=>{
                this.rosterLK = response.data;
            });
        },

        getScantimesLK(){
            this.$axios.get('/api/lookup/scantimes').then((response)=>{
                this.scantimesLK = response.data;
            });
        },

        getSiteLK(){
            this.$axios.get('/api/lookup/site').then((response)=>{
                this.siteLK = response.data;
            });
        },

        getDeptLK(){
            this.$axios.get('/api/lookup/dept').then((response)=>{
                this.deptLK = response.data;
            });
        },

        getSectionLK(){
            this.$axios.get('/api/lookup/section').then((response)=>{
                this.sectionLK = response.data;
            });
        },

        getCrewLK(){
            this.$axios.get('/api/lookup/crew').then((response)=>{
                this.crewLK = response.data;
            });
        },




        formatNumber(value) {
			let val = (value / 1).toFixed(0).replace(",", ".");
			return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		},
        
    },

    created(){
        this.$store.commit('setUsertype', window.Laravel.user.usertype); // Update store
        this.getEmpList();
        this.userType();

        // this.getCountryLK();
        // this.getStatusLK();
        // this.getContractLK();
        // this.getLevelsLK();
        // this.getRosterLK();
        // this.getScantimesLK();
        // this.getSiteLK();
        // this.getDeptLK();
        // this.getSectionLK();
        // this.getCrewLK();
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

     .base-image-input {
        display: block;
        width: 200px;
        height: 240px;
        cursor: pointer;
        background-size: cover;
        background-position: center center;
    }
    .emp-image {
        background: #F0F0F0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: gray;
    }
    .emp-image:hover {
        background: #E0E0E0;
        color: blueviolet ;
    }

</style>