<template>
    <div>

        <!-- <div class="breadcrumb-header justify-content-between">
            <div class="left-content">
                <div>
                    <h2 class="main-content-title tx-24 mg-b-1 mg-b-lg-1">Staff Management</h2>
                    <p class="mg-b-0">Staff management.</p>
                </div>
            </div>
            <div class="main-dashboard-header-right">
                <div>
                    <label class="tx-13">Current Staff</label>
                    <h6 class=" text-info">65</h6>
                </div>
                <div>
                    <label class="tx-13">On Site</label>
                    <h6 class=" text-success">50</h6>
                </div>
                <div>
                    <label class="tx-13">Of Site</label>
                    <h6 class=" text-warning">15</h6>
                </div>
            </div>
        </div> -->

        <div class="card mt-4">
            <div class="card-body">
                <div v-if="employee_list">
                   
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Employee info.</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                  
                    
                    <div class="breadcrumb-header justify-content-between my-0">
                        
                        <div class="col-md-4 px-0">
                            <div class="pos-relative">
                                <input class="form-control pd-l-30" type="text" placeholder="Search by name" v-model="search" @input="searchChange()" >
                                <i class="fe fe-search search-i"></i>
                                <button class="btn btn-icon btn-sm search-c-i search-c" v-if="clear" @click="search_clear()"><i class="fe fe-x"></i></button>
                            </div>
                        </div>


                        <div class="d-flex my-xl-auto right-content">
                            <button type="button" class="btn btn-primary"><i class="fa fa-user-plus"></i> 
                                <span class="mx-1">Add</span>
                            </button>
                        </div>

                    </div>

                    <div class="table-responsive userlist-table">
                            <!-- <table class="table card-table table-striped table-vcenter text-nowrap mb-0"> -->
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
                                    

                                    <tr class="tr-hover" v-for="list in employee_data.data" :key="list.id">
                                        <!-- <th scope="row"> {{ list.UserID }} </th> -->
                                        <td>
                                            <img alt="avatar" class="rounded-circle avatar-md me-2 cur-pointer" src="assets/img/faces/2.jpg"                                     >
                                            <!-- <img alt="avatar" class="rounded-circle avatar-md me-2" src="assets/img/brand/ae.jpg"> -->
                                        </td>
                                        <td>
                                            {{ list.name }} <br>
                                            <span class="noto-lao"> {{ list.namelao }} </span>

                                        </td>
                                        <td> {{ list.position}} </td>
                                        <td> {{ list.dept}} </td>
                                    
                                        <td>
                                            <a href="#" class="btn btn-sm btn-primary">
                                                <i class="fe fe-search"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-info btn-b" v-if="edit" @click="preview">
                                                <i class="las la-pen"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-danger" v-if="del">
                                                <i class="fe fe-trash-2"></i>
                                            </a>
                                        </td>

                    
                                    
                                    </tr>

                                </tbody>
                            </table>
                            <pagination :pagination="employee_data" @paginate="getEmp($event)" :offset="2" ></pagination>
                        </div>
                </div>

                    <!-- Add or Edit Employee -->
                    <div v-if="employee_edit">
                        <div class="row">
                            <div class="col-xl-2">
                                <div style="height: 240px; width: 100%; margin-top: 10px">
                                    <img style="width: 200px; height: 240px" src="assets/img/brand/ae.jpg" alt="No Image">
                                </div> 

                                <div class="mt-5">
                                    <label class="input-group-btn">
                                        <span class="btn btn-primary">
                                            Image <input type="file" class="d-none">
                                        </span>
                                    </label>
                                </div>
                            </div>

                        <div class="col-xl-10">
                            <!-- <h6 class="text-muted">Employee Details</h6>  -->
                            <div class="row">
                                <div class="col-xl-2">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Gender  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" :options="deptList"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-0">Employee ID  <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter employee id">
                                    </div>
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Work Site  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" :options="deptList"/>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="mb-0">Name and Surname - Eng  <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter name and surname">
                                    </div>
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Position  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" searchable= true :options="deptList"/>
                                    </div>
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Department  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" searchable= true :options="deptList"/>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="mb-0">Name and Surname - Lao  <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control noto-lao" placeholder="ປ້ອນຊື່ ແລະ ນາມສະກຸນ ພາສາລາວ">
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-0">Contact Number</label>
                                        <input type="text" class="form-control" placeholder="Enter contact number">
                                    </div>
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Section</label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" searchable= true :options="deptList"/>
                                    </div>
                                </div>

                                <div class="col-xl-2">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Status  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" :options="deptList"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="mb-0">Start Date  <span class=" text-danger">*</span></label>
                                        <input type="date" class="form-control">
                                    </div>
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Crew  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" searchable= true :options="deptList"/>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="mb-0">Scan ID  <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Enter scan id">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="mb-0">Food ID</label>
                                        <input type="text" class="form-control" placeholder="Enter food id">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Scan / Day  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" :options="deptList"/>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Roster  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" :options="deptList"/>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="mb-0">Work Hours  <span class=" text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Enter work hours">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="mb-0">Birthday</label>
                                        <input type="date" class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-2">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Country  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" :options="deptList"/>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Province</label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" :options="deptList"/>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">District</label> 
                                        <Multiselect v-model="txtDept" placeholder="Select" :options="deptList"/>
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="form-group">
                                        <label class="mb-0">Village</label>
                                        <input type="text" class="form-control" placeholder="Enter village">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="form-group">
                                        <label class="mb-0">Remarks</label>
                                        <textarea class="form-control" placeholder="Remrks" rows="3" style="height: 40px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabs -->
                    <div class="panel panel-primary tabs-style-1 mt-4">
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
                </div>
            </div>
        </div>
    </div>


</template>

<script>  
export default {
    name: 'XpplAppEmployee',

    data() {
        return {
            employee_data: [],
            department_data: [],
            edit: false,
            del: false,
            employee_list: true,
            employee_edit: false,
            search: '',
            clear: false
        };
    },

    mounted() {
        
    },


    methods: {
        searchChange(){
            if(this.search.length >0){
                this.clear = true;
                this.getEmp();
            } else {
                this.clear = false;
                this.getEmp();
            }
        },

        search_clear(){
            this.search = '';
            this.clear = false;
            this.getEmp();
        },

        preview(){
            this.employee_list = false;
            this.employee_edit = true;
        },

        backMain(){
            this.employee_list = true;
            this.employee_edit = false;
        },

        userMode(){
            if(this.$store.getters.usertype == 'admin'){
                this.edit = true;
            } else if(this.$store.getters.usertype == 'full'){
                    this.edit = true;
                    this.del = true;
            }
            
        },


        // this is working with store proceture
        // getEmp(page){
        //     this.$axios.post(`/api/emp?page=${page}`, this.department_data)
        //     .then((response) => {
        //         this.employee_data = response.data;
        //     }).catch((err) => {
        //         console.log(err);
        //     });
        // }

		getEmp(page){
			this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
				this.$axios.get(`/api/emp?page=${page}&search=${this.search}`)
				.then((response)=>{
						this.employee_data = response.data;
				}).catch((error)=>{
					console.log(error);
				})

			});
        },
    },

    created(){

        this.department_data = window.Laravel.user;
        this.$store.commit('setUsertype', window.Laravel.user.usertype);
  

        this.getEmp();
        this.userMode();
    },


    beforeRouteEnter(to, from, next){
        if(!window.Laravel.isLoggedin_laravel){
            window.location.href = "/signin";
        }

        next();
	}
};
</script>

<style>
    .sticky-menu {
        position: sticky;
        top: 60px;
        background-color: #ECF0FA;
        /* padding: 1rem; */
    
    }
    .emp-image{
        height: 150px;
        width: 150px;
        /* border-radius: 100%; */
        /* border: solid 1px; */
        
    }
</style>