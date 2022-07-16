<template>
    <div>
        <div class="card mt-4">
            <div class="card-body">
                <div v-if="showList">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Employee List</h4>
                        <!-- <i class="mdi mdi-dots-horizontal text-gray"></i> -->
                    </div>

                    <!-- Search and add button -->
                    <div class="breadcrumb-header justify-content-between my-0">
                        <div class="col-md-4 px-0">
                            <div class="pos-relative">
                                <input class="form-control pd-l-30" type="text" placeholder="Search by name..." v-model="search" @input="searchChange()" >
                                <i class="fe fe-search search-i text-muted"></i>
                                <button class="btn btn-icon btn-sm search-c text-muted" v-if="btnClear" @click="searchClear()"><i class="fe fe-x"></i></button>
                            </div>
                        </div>
                        <div class="d-flex my-xl-auto right-content">
                            <!-- <button type="button" class="btn btn-primary" @click="empAdd()"><i class="fa fa-user-plus"></i> 
                                <span class="mx-1">Add</span>
                            </button> -->

                            <button type="button" class="btn btn-primary btn-icon" title="Add new employee" @click="empAdd()"><i class="mdi mdi-account-plus"></i></button>
                        </div>
                    </div>

                    <!-- Employee table -->
                    <div class="table-responsive userlist-table">
                        <table class="table card-table table-vcenter text-nowrap mb-0 mt-2">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="wd-80"><span>Image</span></th>
                                    <th style="width:50px"><span>Name</span></th>
                                    <th>Position</th>
                                    <th>Phone Number</th>
                                    <th>Country</th>
                                    <th>Employee ID</th>
                                    <th>Scan ID</th>
                                    <th>Started</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="tr-hover" v-for="list in empList.data" :key="list.userid">
                                    <td>
                                        <img v-if="list.images" alt="avatar" class="rounded-circle avatar-md me-2 cur-pointer" :src="'assets/img/profile/'+ list.images" @click="empPrev(list.userid)">
                                        <img v-if="!list.images && list.gender == 'Male'" alt="avatar" class="rounded-circle avatar-md me-2 cur-pointer" src="assets/img/male.png" @click="empPrev(list.userid)">
                                        <img v-if="!list.images && list.gender != 'Male'" alt="avatar" class="rounded-circle avatar-md me-2 cur-pointer" src="assets/img/female.png" @click="empPrev(list.userid)">
                                    </td>
                                    <td>
                                        {{ list.fullname }}<br>
                                        <span class="noto-lao"> {{ list.fulllao }} </span>
                                    </td>
                                    <td> {{ list.position }} </td>
                                    <td> 
                                        <i v-if="list.phone" class="fa fa-tty me-1"></i> 
                                        <i v-else class="fe fe-minus text-danger"></i> 
                                        {{ list.phone}} 
                                    </td>
                                    <td>
                                        <img width="20" class="me-1" :src="'assets/img/flags/'+ list.country + '.png'" alt="" >
                                        {{ list.country }} <br>
                                    </td>
                                    <td>
                                        <i v-if="list.empid" class="far fa-address-card me-1"></i> 
                                        <i v-else class="fe fe-minus text-danger"></i> 
                                        {{ list.empid }}
                                    </td>
                                    <td>    
                                        <i v-if="list.scanid" class="cf cf-cloak me-1"></i> 
                                        {{ list.scanid }}
                                    </td>
                                    <td> 
                                        {{ timeago(list.startdate) }}
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary" style="padding: 7px 9px" title="Preview employee" @click="empPrev(list.userid)"><i class="fe fe-search"></i></a>
                                        <a href="#" class="btn btn-sm btn-info btn-b" style="padding: 7px 9px" title="Edit employee" @click="empEdit(list.userid)"><i class="las la-pen"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger" style="padding: 7px 9px" title="Delete employee" @click="empDel(list.userid)"><i class="fe fe-trash-2"></i></a>
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
                                <img class="cur-pointer" style="width: 160px; height: 200px; border: solid 1px #cccc;" title="Choose an Image" :src="imagePrev" @click="chooseImage">
                                <!-- <img class="cur-pointer" style="width: 160px; height: 200px; border: solid 1px #cccc;" title="Choose an Image" src="assets/img/no2.jpg" @click="chooseImage"> -->
                                <input class="d-none" ref="fileInput" type="file" accept="image/*"  @change="onSeclected">
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
                                            <input type="text" class="form-control" placeholder="Employee id..." v-model="addData.empid">
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
                                <div class="tab-pane active overflow-auto" id="tab1" style="height: 270px">
                                    <div class=" d-flex justify-content-start">
                                        <button class="btn btn-icon btn-sm cur-pointer btn-i mt-0" @click="addDetail"><i class="fa fa-plus-circle text-primary"></i></button>
                                    </div>
   
                                    <div class="table-responsive mt-1">
                                        <table class="table main-table-reference text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Site</th>
                                                    <th>Start Date</th>
                                                    <th>End Date</th>
                                                    <th>Status</th>
                                                    <th>Position</th>
                                                    <th>Department</th>
                                                    <th>Section</th>
                                                    <th>Crew</th>
                                                    <th>Employee ID</th>
                                                    <th>Scan ID</th>
                                                    <th>Food ID</th>
                                                    <th>Roster</th>
                                                    <th>Scan Times</th>
                                                    <th>Hours</th>
                                                    <th>Levels</th>
                                                    <th>Contract</th>
                                                    <th>Remarks</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <tr v-for="lst in details" :key="lst.id">
                                                    <td> {{ lst.site }} </td>
                                                    <td> {{ dateTime(lst.startdate) }} </td>
                                                    <td> {{ dateTime(lst.enddate) }} </td>
                                                    <td> {{ lst.status }} </td>
                                                    <td> {{ lst.position }} </td>
                                                    <td> {{ lst.department }} </td>
                                                    <td> {{ lst.section }} </td>
                                                    <td> {{ lst.crew }} </td>
                                                    <td> {{ lst.empid }} </td>
                                                    <td> {{ lst.scanid }} </td>
                                                    <td> {{ lst.foodid }} </td>
                                                    <td> {{ lst.roster }} </td>
                                                    <td> {{ lst.scantimes }} </td>
                                                    <td> {{ lst.working_hrs }} </td>
                                                    <td> {{ lst.levels }} </td>
                                                    <td> {{ lst.contract }} </td>
                                                    <td> {{ lst.remarks }} </td>
                                                    <td> 
                                                        <i class="fa fa-edit cur-pointer text-info" @click="editDetail(lst.id)"></i>
                                                        <i class="far fa-trash-alt cur-pointer text-danger ms-2"></i>
                                                    </td>
                                                </tr>                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                </div>
                                <div class="tab-pane" id="tab2" style="height: 270px">
                                    


                                </div>
                                <div class="tab-pane" id="tab3" style="height: 270px">
                                    



                                </div>
                            </div>
                        </div>
                    </div> <!-- EndTabs -->

                    <div class="d-flex justify-content-end mt-2">
                        <button v-if="btnEmpUpdate" type="button" class="btn btn-primary" :class="btnEmpUpdateShow" @click="empUpdate()"><i class="fa fa-check"></i> 
                            <span class="mx-1">Update</span>
                        </button>
                        <button v-if="btnEmpInsert" type="button" class="btn btn-primary" :class="btnEmpInsertShow" @click="empInsertNew()"><i class="fa fa-plus"></i> 
                            <span class="mx-1">Add</span>
                        </button>
                        <button type="button" class="btn btn-danger ms-2" @click="empCancel()"><i class="fa fa-times"></i> 
                            <span class="mx-1">Cancel</span>
                        </button>
                    </div>

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

            <!-- Modal add edit detail -->
            <div class="modal fade" id="addEditDetail" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addEditDetailLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted main-content-label">Employee Details</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <!-- Row1 -->
                            <div class="row">
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Site  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="addData.site" placeholder="Select" :options="siteLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Start Date  <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" placeholder="Working hrs..." v-model="addData.startdate">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">End Date</label>
                                        <input type="date" class="form-control" placeholder="Working hrs..." v-model="addData.enddate">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Status  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="addData.status" placeholder="Select" :options="statusLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Position  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="addData.position" placeholder="Select" :options="positionLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Department  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="addData.dept" placeholder="Select" :options="deptLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Section</label> 
                                        <Multiselect v-model="addData.section" placeholder="Select" :options="sectionLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Crew</label> 
                                        <Multiselect v-model="addData.crew" placeholder="Select" :options="crewLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Employee ID</label>
                                        <input type="text" class="form-control" placeholder="Employee id..." v-model="addData.empid">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Scan ID <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Scan id..." v-model="addData.scanid">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Food ID</label>
                                        <input type="text" class="form-control" placeholder="Food id..." v-model="addData.foodid">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Roster  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="addData.roster" placeholder="Select" :options="rosterLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Scan Times  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="addData.scantimes" placeholder="Select" :options="scantimesLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Working hrs  <span class=" text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Working hrs..." v-model="addData.hours">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Levels</label> 
                                        <Multiselect v-model="addData.levels" placeholder="Select" :options="levelsLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Contract Type</label> 
                                        <Multiselect v-model="addData.contract" placeholder="Select" :options="contractLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-10">
                                    <div class="form-group">
                                        <label class="mb-0">Remarks</label>
                                        <input type="text" class="form-control" placeholder="Remarks..." v-model="addData.remarks">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Insert Data</button>
                        </div>
                    </div>
                </div>                                              
            </div> <!-- End of modal add edit detail -->

        </div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppEmployee',

    data() {
        return {
            showList: true,
            showAdd: "",
            showDetail: "",
            showTab: "",
            btnClear: false,
            search: "",
            btnEmpUpdate: "",
            btnEmpInsert: "",
            
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
            details: [],

            addData: {
                userid: "",
                gender: 'Male',
                name: "",
                surname: "",
                namelao: "",
                surnamelao: "",
                phone: "",
                birthday: "",
                email: "",
                country: "",
                province: "",
                district: "",
                village: "",
                startdate: "",
                enddate: "",
                position: "",
                status: 'Current',
                contract: "",
                levels: "",
                empid: "",
                scanid: "",
                foodid: "",
                roster: "",
                scantimes: "",
                hours: '9',
                site: "",
                dept: "",
                section: "",
                crew: "",
                file: "",
                remarks: "",
                imageName: ""
            },
            imagePrev: window.location.origin + '/assets/img/no2.jpg',

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
        btnEmpInsertShow(){
            if(this.addData.name == "" || this.addData.namelao == '' || this.addData.country == '' || this.addData.startdate == '' || this.addData.status == '' || this.addData.scanid == '' || this.addData.roster == '' || this.addData.scantimes == '' || this.addData.hours == '' || this.addData.site == '' || this.addData.dept == '' ){
                return 'disabled'
            } else {
                return ''
            }
        },

        btnEmpUpdateShow(){
            if (this.addData.name == "" || this.addData.namelao == "" || this.addData.country == ""){
                return "disabled"
            } else {
                return ""
            }

        }
    },

    methods: {
        async getEmpList(page){
			const response = await axios.get(`/api/employee?page=${page}&search=${this.search}`)
            this.empList = response.data;

            if (response.data[0].images){
                this.imagePrev = window.location.origin + '/assets/img/profile/' + response.data[0].images
            } else {
                this.imagePrev = window.location.origin + '/assets/img/no2.jpg'
            }
        },

        addDetail(){
            $('#addEditDetail').modal('show');

            this.lookup();
        },

        editDetail(id){
            $('#addEditDetail').modal('show');
            this.$axios.post(`/api/employee/editDetail/${id}`)
            .then((response)=>{
                this.addData.site = response.data[0].site;
                this.addData.startdate = response.data[0].startdate;
                this.addData.enddate = response.data[0].enddate;
                this.addData.status = response.data[0].status;
                this.addData.position = response.data[0].position;
                this.addData.dept = response.data[0].department;
                this.addData.section = response.data[0].section;
                this.addData.crew = response.data[0].crew;
                this.addData.empid = response.data[0].empid;
                this.addData.scanid = response.data[0].scanid;
                this.addData.foodid = response.data[0].foodid;
                this.addData.roster = response.data[0].roster;
                this.addData.scantimes = response.data[0].scantimes;
                this.addData.hours = response.data[0].working_hrs;
                this.addData.levels = response.data[0].levels;
                this.addData.contract = response.data[0].contract_type;
                this.addData.remarks = response.data[0].remarks;
            }).catch((error)=>{
                console.log(error);
            })
        },

        empAdd(){
            if(this.$store.getters.usertype == 'user'){
                this.$swal.fire({
                    text: "You don't have permission to add employee!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 1500
                })
            } else {
                this.$axios.get("/api/employee/newUserid")
                .then(res=>{
                    this.addData.userid = res.data[0].userid;
                });

                this.showList = false;
                this.showAdd = true;
                this.showDetail = true;
                this.showTab = false;
                this.btnEmpUpdate = false;
                this.btnEmpInsert = true;
                
                this.formReset();
                this.lookup();
            }
        },

        empPrev(userid){
            $('#empPreview').modal('show');

            this.$axios.get('/sanctum/csrf-cookie').then((response)=>{
                this.$axios.post(`/api/employee/prev/${userid}`)
                .then((response)=>{
                    this.prevData = response.data;
                }).catch((error)=>{
                    console.log(error);
                })
            });
        },

       async empEdit(userid){
            if(this.$store.getters.usertype == 'user'){
                this.$swal.fire({
                    text: "You don't have permission to edit employee!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 1500
                })
            } else {
                this.formReset();
                const response = await axios.post(`/api/employee/edit/${userid}`)
                this.addData.userid = response.data[0].userid;
                this.addData.gender = response.data[0].gender;
                this.addData.name = response.data[0].name;
                this.addData.surname = response.data[0].surname;
                this.addData.phone = response.data[0].phone;
                this.addData.namelao = response.data[0].namelao;
                this.addData.surnamelao = response.data[0].surnamelao;
                this.addData.birthday = response.data[0].birthday;
                this.addData.email = response.data[0].email;
                this.addData.country = response.data[0].country;
                this.addData.province = response.data[0].province;
                this.addData.district = response.data[0].district;
                this.addData.village = response.data[0].village;
                this.addData.imageName = response.data[0].images;

                if (response.data[0].images){
                    this.imagePrev = window.location.origin + '/assets/img/profile/' + response.data[0].images
                } else {
                    this.imagePrev = window.location.origin + '/assets/img/no2.jpg'
                }

                this.getDetails(userid);
                this.lookup();

                this.showList = false;
                this.showAdd = true;
                this.showDetail = false;
                this.showTab = true;
                this.btnEmpInsert = false;
                this.btnEmpUpdate = true;
            }
        },

        empDel(userid){
            
            if (this.$store.getters.usertype == 'user'){
                this.$swal.fire({
                    text: "You don't have permission to delete employee!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timer: 1500
                })
            } else {

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
                }).then((result)=>{
                    if(result.isConfirmed){
                        this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                            this.$axios.post(`/api/employee/delete/${userid}`)
                            .then((response)=>{

                                this.search = "";
                                this.btnClear = false;
                                this.getEmpList();

                                console.log(response.data);

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
            }
        },

        empCancel(){ 
            this.showList = true;
            this.showAdd = false;
        },

        empInsertNew(){
            let fd = new FormData();
                fd.append('userid', this.addData.userid);
                fd.append('gender', this.addData.gender);
                fd.append('name', this.addData.name);
                fd.append('surname', this.addData.surname);
                fd.append('namelao', this.addData.namelao);
                fd.append('surnamelao', this.addData.surnamelao);
                fd.append('phone', this.addData.phone);
                fd.append('birthday', this.addData.birthday);
                fd.append('email', this.addData.email);
                fd.append('country', this.addData.country);
                fd.append('province', this.addData.province);
                fd.append('district', this.addData.district);
                fd.append('village', this.addData.village);
                fd.append('startdate', this.addData.startdate);
                fd.append('enddate', this.addData.enddate);
                fd.append('position', this.addData.position);
                fd.append('status', this.addData.status);
                fd.append('contract', this.addData.contract);
                fd.append('levels', this.addData.levels);
                fd.append('empid', this.addData.empid);
                fd.append('scanid', this.addData.scanid);
                fd.append('foodid', this.addData.foodid);
                fd.append('roster', this.addData.roster);
                fd.append('scantimes', this.addData.scantimes);
                fd.append('hours', this.addData.hours);
                fd.append('site', this.addData.site);
                fd.append('dept', this.addData.dept);
                fd.append('section', this.addData.section);
                fd.append('crew', this.addData.crew);
                fd.append('file', this.addData.file);

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post('api/employee/empInsert', fd, {headers:{"Content-Type": "multipart/form-date"}})
                .then((response)=>{
                    if(response.data.success){
                        this.getEmpList();
                        this.showAdd = false;
                        this.showList = true;
                    } else {
                        alert(response.data.message)
                    }
                }).catch((error)=>{
                    console.log(error);
                })
            });
        },

        empUpdate(){
            let fd = new FormData();
                fd.append('userid', this.addData.userid);
                fd.append('gender', this.addData.gender);
                fd.append('name', this.addData.name);
                fd.append('surname', this.addData.surname);
                fd.append('namelao', this.addData.namelao);
                fd.append('surnamelao', this.addData.surnamelao);
                fd.append('phone', this.addData.phone);
                fd.append('birthday', this.addData.birthday);
                fd.append('email', this.addData.email);
                fd.append('country', this.addData.country);
                fd.append('province', this.addData.province);
                fd.append('district', this.addData.district);
                fd.append('village', this.addData.village);
                fd.append('imageName', this.addData.imageName);
                fd.append('file', this.addData.file);
            
            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post('api/employee/empUpdate', fd, {headers:{"Content-Type": "multipart/form-date"}})
                .then((response)=>{
                    this.getEmpList();
                    this.showAdd = false;
                    this.showList = true;
                }).catch((error)=>{
                    console.log(error);
                })
            });
        },

        async getDetails(userid){
            const response = await axios.post(`api/employee/detail/${userid}`)
            this.details = response.data;
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
            this.search = "";
            this.btnClear = false,
            this.getEmpList();
        },

        chooseImage(){
            this.$refs.fileInput.click()
        },

        onSeclected(event){
            this.addData.file = event.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(this.addData.file);
            reader.addEventListener("load", function(){
                this.imagePrev = reader.result;
            }.bind(this), false);
		},

        userType(){
            if(this.$store.getters.usertype == 'admin'){
                this.btnEdit = "";
            } else if(this.$store.getters.usertype == 'full'){
                this.btnEdit = "";
                this.btnDel = "";
            }
        },

        formReset(){
            this.addData.gender = "Male";
            this.addData.name = "";
            this.addData.surname = "";
            this.addData.namelao = "";
            this.addData.surnamelao = "";
            this.addData.phone = "";
            this.addData.birthday = "";
            this.addData.email = "";
            this.addData.country = "";
            this.addData.province = "";
            this.addData.district = "";
            this.addData.village = "";
            this.addData.startdate = "";
            this.addData.enddate = "";
            this.addData.position = "";
            this.addData.contract = "";
            this.addData.levels = "";
            this.addData.empid = "";
            this.addData.scanid = "";
            this.addData.foodid = "";
            this.addData.roster = "";
            this.addData.scantimes = "";
            this.addData.hours = "9";
            this.addData.site = "";
            this.addData.dept = "";
            this.addData.section = "";
            this.addData.crew = "";
            this.imagePrev = window.location.origin + "/assets/img/no2.jpg"
        },

        async lookup(){
            const country = await axios.get('/api/lookup/country')
            this.countryLK = country.data;

            const position = await axios.get('/api/lookup/position')
            this.positionLK = position.data;

            const status = await axios.get('/api/lookup/status')
            this.statusLK = status.data;

            const contract = await axios.get('/api/lookup/contract')
            this.contractLK = contract.data;
            
            const levels = await axios.get('/api/lookup/levels')
            this.levelsLK = levels.data;
            
            const roster = await axios.get('/api/lookup/roster')
            this.rosterLK = roster.data;
            
            const scantimes = await axios.get('/api/lookup/scantimes')
            this.scantimesLK = scantimes.data;
            
            const site = await axios.get('/api/lookup/site')
            this.siteLK = site.data;
            
            const dept = await axios.get('/api/lookup/dept')
            this.deptLK = dept.data;
            
            const section = await axios.get('/api/lookup/section')
            this.sectionLK = section.data;
            
            const crew = await axios.get('/api/lookup/crew')
            this.crewLK = crew.data;
        },

        formatNumber(value) {
			let val = (value / 1).toFixed(0).replace(",", ".");
			return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		},

        timeago(value){
            if(value){
                return moment(value).fromNow();
            }
        },

        dateTime(value) {
            if(value) {
                return moment(value).format('DD-MM-YYYY');
            }
        },
    },

    created(){
        this.$store.commit('setUsertype', window.Laravel.user.usertype); // Update store
        this.userType();
        this.getEmpList();
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