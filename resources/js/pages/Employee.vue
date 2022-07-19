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
                            <button v-if="btnEmpNew" type="button" class="btn btn-primary btn-icon btn-sm wd-38 ht-38 rounded-circle" title="Add new employee" @click="empNew()"><i class="mdi mdi-account-plus"></i></button>
                        </div>
                    </div>

                    <!-- Employee table -->
                    <div class="table-responsive userlist-table">
                        <table class="table card-table table-vcenter text-nowrap mb-0 mt-2 bd bd-gray-100">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="wd-80"><span>Image</span></th>
                                    <th style="width: 50px"><span>Name</span></th>
                                    <th>
                                        <div v-if="this.$store.getters.usertype == 'full'">Position / Dept.</div>
                                        <div v-else>Position</div>
                                    </th>
                                    <th>Phone Number</th>
                                    <th>Country</th>
                                    <th><span>ID</span><span class="text-lowercase">s</span></th>
                                    <th>Started</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="tr-hover" v-for="list in empList.data" :key="list.id">
                                    <td>
                                        <div class="pos-relative">
                                            <img v-if="list.photo" alt="" class="rounded-circle avatar-md me-2 cur-pointer" :src="'assets/img/profile/'+ list.photo" @click="empPrev(list.id)">                                   
                                            <img v-if="!list.photo && list.gender == 'Male'" alt="" class="rounded-circle avatar-md me-2 cur-pointer" src="assets/img/male.png" @click="empPrev(list.id)">
                                            <img v-if="!list.photo && list.gender != 'Male'" alt="" class="rounded-circle avatar-md me-2 cur-pointer" src="assets/img/female.png" @click="empPrev(list.id)">
                                            <span v-if="list.status == 'Current' || list.status == 'Temporary'" class="rounded-circle bg-success bad"></span>
                                        </div>
                                        <!-- <span v-if="list.status == 'Current' || list.status == 'Temporary'"><span class="pulse-danger" style="left: 38px; top: 38px"></span></span> -->
                                    </td>
                                    <td>
                                        {{ list.fullname }} <br>
                                        <span class="noto-lao"> {{ list.fulllao }} </span>
                                    </td>
                                    <td> 
                                        {{ list.position }}
                                        <div v-if="this.$store.getters.usertype == 'full'">{{ list.department }}</div>
                                    </td>
                                    <td> 
                                        <i v-if="list.phone" class="fa fa-tty me-1"></i> {{ list.phone}} 
                                    </td>
                                    <td>
                                        <img width="20" class="me-1" :src="'assets/img/flags/'+ list.country + '.png'" alt="" >
                                        {{ list.country }} <br>
                                    </td>
                                    <td>
                                        <div v-if="list.empid">
                                            <i class="far fa-address-card me-1"></i> {{ list.empid }}
                                        </div>
                                        <div v-if="list.scanid">
                                            <i class="cf cf-cloak me-1"></i> {{ list.scanid }}
                                        </div>
                                    </td>
                                    <td> 
                                        {{ timeago(list.startdate) }} <br>
                                        {{ list.status }}
                                        <!-- <span v-if="list.status == 'Current'" class="pos-relative">{{ list.status }}<span class="pulse-danger" style="left: 50px; top: 0px"></span></span> -->
                                    </td>
                                    <td>        
                                        <button class="btn btn-icon btn-sm btn-i wd-38 ht-38 pos-relative" data-bs-toggle="dropdown" title="Tools">
                                            <i class="mdi mdi-dots-horizontal pos-absolute" style="left: 50%; transform: translateX(-50%); top: 50%"></i>
                                        </button>       
                                        <div  class="dropdown-menu tx-13">
                                            <div class="dropdown-item cur-pointer" @click="empPrev(list.id)">
                                                <i class="fe fe-search me-2"></i><span>Preview</span>
                                            </div>
                                            <div class="dropdown-item cur-pointer" @click="empEdit(list.id)">
                                                <i class="fe fe-edit me-2"></i><span>Edit</span>
                                            </div>
                                            <div class="dropdown-item cur-pointer" @click="empDel(list.id)">
                                                <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                                            </div>
                                        </div>
                                        <!-- <a href="#" class="btn btn-sm btn-primary" style="padding: 7px 9px" title="Preview employee" @click="empPrev(list.id)"><i class="fe fe-search"></i></a>
                                        <a href="#" class="btn btn-sm btn-info btn-b" style="padding: 7px 9px" title="Edit employee" @click="empEdit(list.id)"><i class="fe fe-edit"></i></a> 
                                        <a href="#" class="btn btn-sm btn-danger" style="padding: 7px 9px" title="Delete employee" @click="empDel(list.id)"><i class="fe fe-trash-2"></i></a> -->
                                        <!-- las la-pen -->
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
                                <img class="cur-pointer" style="width: 160px; height: 200px; border: solid 1px #cccc;" title="Choose an Image" :src="photoPrev" @click="chooseImage">
                                <!-- <img class="cur-pointer" style="width: 160px; height: 200px; border: solid 1px #cccc;" title="Choose an Image" src="assets/img/no.jpg" @click="chooseImage"> -->
                                <input class="d-none" ref="fileInput" type="file" accept="image/*"  @change="onSeclected">
                            </div> 
                            <label class="rdiobox mt-4 ms-2 cur-pointer"><input name="rdio" type="radio" value="Male" checked="" v-model="data.gender"><span>Male</span></label>
                            <label class="rdiobox mb-4 ms-2 cur-pointer"><input name="rdio" type="radio" value="Female" v-model="data.gender"><span>Female</span></label>                         
                        </div>

                        <div class="col-xxl-10">
                            <!-- Row1 -->
                            <div class="row">
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Name Eng  <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Name..." v-model="data.name">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Surname Eng</label>
                                        <input type="text" class="form-control" placeholder="Surname..." v-model="data.surname">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12">
                                    <div class="form-group">
                                        <label class="mb-0">Phone Number</label>
                                        <input type="text" class="form-control" placeholder="Phone numbers..." v-model="data.phone">
                                    </div>
                                </div>
                            </div>

                            <!-- Row2 -->
                            <div class="row">
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Name Lao  <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control noto-lao" placeholder="ຊື່..." v-model="data.namelao">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Surname Lao</label>
                                        <input type="text" class="form-control noto-lao" placeholder="ນາມສະກຸນ..." v-model="data.surnamelao">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="mb-0">Birthday</label>
                                        <input type="date" class="form-control" v-model="data.birthday">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <label class="mb-0">Email</label>
                                        <input type="eamil" class="form-control" placeholder="Email..." v-model="data.email">
                                    </div>
                                </div>
                            </div>

                            <!-- Row3 -->
                            <h6 class="text-muted mt-2">Employee Address</h6>
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-4">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Country  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="data.country" placeholder="Select" searchable="true" :options="countryLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-8 col-md-6 col-sm-8">
                                    <div class="form-group">
                                        <label class="mb-0">Province</label>
                                        <input type="text" class="form-control" placeholder="Province..." v-model="data.province">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">District</label>
                                        <input type="text" class="form-control" placeholder="District..." v-model="data.district">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Village</label>
                                        <input type="text" class="form-control" placeholder="Village..." v-model="data.village">
                                    </div>
                                </div>
                            </div>

                            <!-- Employee detail -->
                            <div v-if="showDetail">
                                <h6 class="text-muted mt-2">Employee detail</h6>
                                <!-- Row4 -->
                                <div class="row">
                                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Start Date  <span class=" text-danger">*</span></label>
                                            <input type="date" class="form-control" v-model="data.startdate">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">End Date</label>
                                            <input type="date" class="form-control" v-model="data.enddate">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Position  <span class=" text-danger">*</span></label> 
                                            <Multiselect v-model="data.position" placeholder="Select" searchable="true" :options="positionLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Contract Type</label> 
                                            <Multiselect v-model="data.contract" placeholder="Select" :options="contractLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Levels</label> 
                                            <Multiselect v-model="data.levels" placeholder="Select" :options="levelsLK"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row5 -->
                                <div class="row">
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Employee ID</label>
                                            <input type="text" class="form-control" placeholder="Employee id..." v-model="data.empid">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Scan ID  <span class=" text-danger">*</span></label>
                                            <input type="number" class="form-control" placeholder="Scan id..." v-model="data.scanid">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Food ID</label>
                                            <input type="text" class="form-control" placeholder="Food id..." v-model="data.foodid">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Roster  <span class=" text-danger">*</span></label> 
                                            <Multiselect v-model="data.roster" placeholder="Select" :options="rosterLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-4 col-sm-4 col-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Scan Times  <span class=" text-danger">*</span></label> 
                                            <Multiselect v-model="data.scantimes" placeholder="Select" :options="scantimesLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Working hrs  <span class=" text-danger">*</span></label>
                                            <input type="number" class="form-control" placeholder="Working hrs..." v-model="data.hours">
                                        </div>
                                    </div>
                                </div>
                                <!-- Row6 -->
                                <div class="row">
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Site  <span class=" text-danger">*</span></label> 
                                            <Multiselect v-model="data.site" placeholder="Select" :options="siteLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-9 col-md-8 col-sm-8">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Department  <span class=" text-danger">*</span></label> 
                                            <Multiselect v-model="data.dept" placeholder="Select" searchable="true" :options="deptLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Section</label> 
                                            <Multiselect v-model="data.section" placeholder="Select" searchable="true" :options="sectionLK"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group multi-color">
                                            <label class="mb-0">Crew</label> 
                                            <Multiselect v-model="data.crew" placeholder="Select" searchable="true" :options="crewLK"/>
                                        </div>
                                    </div>
                                </div>
                            </div>  <!-- End of employee detail --> 
                        </div>
                    </div>
                    
                    <!-- Tabs -->
                    <div class="panel panel-primary tabs-style-1 mt-4" v-if="showTab">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li class="nav-item"><a href="#tab1" class="nav-link active" data-bs-toggle="tab">Employee Detail</a></li>
                                    <li class="nav-item"><a href="#tab2" class="nav-link" data-bs-toggle="tab">Emergency Contact</a></li>
                                    <li class="nav-item"><a href="#tab3" class="nav-link" data-bs-toggle="tab">Bank Acount</a></li>
                                </ul>
                            </div>
                        </div>
                       
                        <div class="panel-body tabs-menu-body main-content-body-right border-top-0 border">
                            <div class="tab-content">
                                <div class="tab-pane active overflow-auto" id="tab1" style="height: 270px">
                                    <!-- <div class=" d-flex justify-content-start">
                                        <button class="btn btn-icon btn-sm cur-pointer btn-i mt-0" @click="detailNew()"><i class="fa fa-plus-circle text-primary"></i></button>
                                    </div> -->
   
                                    <div class="table-responsive mt-1">
                                        <table class="table main-table-reference text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th class="cur-pointer text-center" style="padding: 8px 10px" @click="detailNew()" title="Add"><i class="fa fa-plus-circle tx-13 text-primary"></i></th>
                                                    <th style="letter-spacing: 0px">Site</th>
                                                    <th style="letter-spacing: 0px">Start Date</th>
                                                    <th style="letter-spacing: 0px">End Date</th>
                                                    <th style="letter-spacing: 0px">Status</th>
                                                    <th style="letter-spacing: 0px">Position</th>
                                                    <th style="letter-spacing: 0px">Department</th>
                                                    <th style="letter-spacing: 0px">Section</th>
                                                    <th style="letter-spacing: 0px">Crew</th>
                                                    <th style="letter-spacing: 0px">Employee ID</th>
                                                    <th style="letter-spacing: 0px">Scan ID</th>
                                                    <th style="letter-spacing: 0px">Food ID</th>
                                                    <th style="letter-spacing: 0px">Roster</th>
                                                    <th style="letter-spacing: 0px">Scan Times</th>
                                                    <th style="letter-spacing: 0px">Hours</th>
                                                    <th style="letter-spacing: 0px">Levels</th>
                                                    <th style="letter-spacing: 0px">Contract</th>
                                                    <th style="letter-spacing: 0px">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <tr class="tr-hover" v-for="lst in detail" :key="lst.id">
                                                    <!-- <td style="padding: 4px 10px"> 
                                                        <i class="fa fa-edit cur-pointer text-info" @click="detailEdit(lst.id)" title="Edit"></i>
                                                        <i class="far fa-trash-alt cur-pointer text-danger ms-2" @click="detailDel(lst.id)" title="Delete"></i>
                                                    </td> -->
                                                    <td style="padding: 0px 4px">
                                                        <button class="btn btn-icon btn-sm btn-i wd-25 ht-25"  data-bs-toggle="dropdown" title="Tools">
                                                            <i class="mdi mdi-dots-horizontal"></i>
                                                        </button> 

                                                        <div class="dropdown-menu tx-13">
                                                            <div class="dropdown-item cur-pointer" @click="detailEdit(lst.id)">
                                                                <i class="fe fe-edit me-2"></i><span>Edit</span>
                                                            </div>
                                                            <div class="dropdown-item cur-pointer" @click="detailDel(lst.id)">
                                                                <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="padding: 4px 10px"> {{ lst.site }} </td>
                                                    <td style="padding: 4px 10px"> {{ dateTime(lst.startdate) }} </td>
                                                    <td style="padding: 4px 10px"> {{ dateTime(lst.enddate) }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.status }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.position }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.department }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.section }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.crew }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.empid }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.scanid }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.foodid }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.roster }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.scantimes }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.working_hrs }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.levels }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.contract }} </td>
                                                    <td style="padding: 4px 10px"> {{ lst.remarks }} </td>
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
                        <button v-if="btnEmpUpdate" type="button" class="btn btn-info btn-b" :class="btnEmpUpdateShow" @click="empUpdate()"><i class="fe fe-check-circle"></i> 
                            <span class="mx-1">Update</span>
                        </button>
                        <button v-if="btnEmpAdd" type="button" class="btn btn-primary" :class="btnEmpAddShow" @click="empAdd()"><i class="fe fe-plus"></i> 
                            <span class="mx-1">Add</span>
                        </button>
                        <button type="button" class="btn btn-secondary ms-2" @click="empCancel()"><i class="fe fe-x"></i> 
                            <span class="mx-1">Close</span>
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
            <div class="modal fade" id="detailAddEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailAddEditLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted main-content-label">Employee detail</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <!-- Row1 -->
                            <div class="row">
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Site  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="data.site" placeholder="Select" :options="siteLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Start Date  <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" placeholder="Working hrs..." v-model="data.startdate">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">End Date</label>
                                        <input type="date" class="form-control" placeholder="Working hrs..." v-model="data.enddate">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Status  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="data.status" placeholder="Select" :options="statusLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Position  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="data.position" placeholder="Select" :options="positionLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Department  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="data.dept" placeholder="Select" :options="deptLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Section</label> 
                                        <Multiselect v-model="data.section" placeholder="Select" :options="sectionLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Crew</label> 
                                        <Multiselect v-model="data.crew" placeholder="Select" :options="crewLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Employee ID</label>
                                        <input type="text" class="form-control" placeholder="Employee id..." v-model="data.empid">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Scan ID <span class=" text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Scan id..." v-model="data.scanid">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Food ID</label>
                                        <input type="text" class="form-control" placeholder="Food id..." v-model="data.foodid">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Roster  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="data.roster" placeholder="Select" :options="rosterLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Scan Times  <span class=" text-danger">*</span></label> 
                                        <Multiselect v-model="data.scantimes" placeholder="Select" :options="scantimesLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Working hrs  <span class=" text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Working hrs..." v-model="data.hours">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Levels</label> 
                                        <Multiselect v-model="data.levels" placeholder="Select" :options="levelsLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-6">
                                    <div class="form-group multi-color">
                                        <label class="mb-0">Contract Type</label> 
                                        <Multiselect v-model="data.contract" placeholder="Select" :options="contractLK"/>
                                    </div>
                                </div>
                                <div class="col-xl-10">
                                    <div class="form-group">
                                        <label class="mb-0">Remarks</label>
                                        <input type="text" class="form-control" placeholder="Remarks..." v-model="data.remarks">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button v-if="btnDetailUpdate" type="button" class="btn btn-info btn-b" :class="btnDetailShow" @click="detailUpdate()"><i class="fe fe-check-circle"></i> 
                                <span class="mx-1">Update</span>
                            </button>
                            <button v-if="btnDetailAdd" type="button" class="btn btn-primary" :class="btnDetailShow" @click="detailAdd()"><i class="fe fe-plus"></i> 
                                <span class="mx-1">Add</span>
                            </button>
                            <button type="button" class="btn btn-secondary ms-2" data-bs-dismiss="modal"><i class="fe fe-x"></i> 
                                <span class="mx-1">Close</span>
                            </button>
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
            showList: true
            ,showAdd: ''
            ,showDetail: ''
            ,showTab: ''
            ,btnClear: false
            ,search: ''
            ,btnEmpUpdate: ''
            ,btnEmpNew: false
            ,btnEmpAdd: ''
            ,btnDetailUpdate: ''
            ,btnDetailAdd: ''

            ,empList: []
            ,countryLK: []
            ,positionLK: []
            ,statusLK: []
            ,contractLK: []
            ,levelsLK: []
            ,rosterLK: []
            ,scantimesLK: []
            ,siteLK: []
            ,deptLK: []
            ,sectionLK: []
            ,crewLK: []
            ,detail: []

            ,data: {
                id: ''
                ,userid: ''
                ,gender: 'Male'
                ,name: ''
                ,surname: ''
                ,namelao: ''
                ,surnamelao: ''
                ,phone: ''
                ,birthday: ''
                ,email: ''
                ,country: ''
                ,province: ''
                ,district: ''
                ,village: ''
                ,startdate: ''
                ,enddate: ''
                ,position: ''
                ,status: 'Current'
                ,contract: ''
                ,levels: ''
                ,empid: ''
                ,scanid: ''
                ,foodid: ''
                ,roster: ''
                ,scantimes: ''
                ,hours: '9'
                ,site: ''
                ,dept: ''
                ,section: ''
                ,crew: ''
                ,photo: ''
                ,remarks: ''
            }
            ,photoPrev: window.location.origin + '/assets/img/no.jpg'

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
        btnEmpAddShow(){
            if(this.data.name == '' || this.data.namelao == '' || this.data.country == null || this.data.startdate == '' || this.data.scanid == '' || this.data.roster == null || this.data.scantimes == null || this.data.hours == '' || this.data.site == null || this.data.dept == null ){
                return 'disabled'
            } else {
                return ''
            }
        },
        
        btnEmpUpdateShow(){
            if (this.data.name == '' || this.data.namelao == '' || this.data.country == null){
                return 'disabled'
            } else {
                return ''
            }
        },

        btnDetailShow(){
            if (this.data.site == null || this.data.startdate == '' || this.data.status == null || this.data.scanid == '' || this.data.roster == null || this.data.scantimes == null || this.data.hours == '' || this.data.dept == null){
                return 'disabled'
            } else {
                return ''
            }
        }
    },

    methods: {
        
        async getEmpList(page){
			const response = await axios.get(`/api/employee?page=${page}&search=${this.search}`)
            this.empList = response.data;

            if (response.data[0].photo){
                this.photoPrev = window.location.origin + '/assets/img/profile/' + response.data[0].photo
            } else {
                this.photoPrev = window.location.origin + '/assets/img/no.jpg'
            }
        },

        empNew(){
            // if(this.$store.getters.usertype == 'user'){
            //     this.$swal.fire({
            //         text: "You don't have permission to add employee!",
            //         icon: 'error',
            //         showCancelButton: false,
            //         showConfirmButton: false,
            //         allowOutsideClick: false,
            //         timerProgressBar: true,
            //         timer: 1000
            //     })
            // } else {
                this.showList = false;
                this.showAdd = true;
                this.showDetail = true;
                this.showTab = false;
                this.btnEmpUpdate = false;
                this.btnEmpAdd = true;
                this.empClear();
                this.detailClear();
            // }
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

       async empEdit(id){
            if(this.$store.getters.usertype == 'user'){
                this.$swal.fire({
                    text: "You don't have permission to edit employee!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1000
                })
            } else {

                this.empClear();
                const response = await axios.post(`/api/employee/edit/${id}`)
                    this.data.userid = response.data.id;
                    this.data.gender = response.data.gender;
                    this.data.name = response.data.name;
                    this.data.surname = response.data.surname;
                    this.data.phone = response.data.phone;
                    this.data.namelao = response.data.namelao;
                    this.data.surnamelao = response.data.surnamelao;
                    this.data.birthday = response.data.birthday;
                    this.data.email = response.data.email;
                    this.data.country = response.data.country;
                    this.data.province = response.data.province;
                    this.data.district = response.data.district;
                    this.data.village = response.data.village;

                    if (response.data.photo){
                        this.photoPrev = window.location.origin + '/assets/img/profile/' + response.data.photo
                    } else {
                        this.photoPrev = window.location.origin + '/assets/img/no.jpg'
                    }
                    this.getDetail(id);
                    this.showList = false;
                    this.showAdd = true;
                    this.showDetail = false;
                    this.showTab = true;
                    this.btnEmpAdd = false;
                    this.btnEmpUpdate = true;
            }
        },

        empCancel(){ 
            this.showList = true;
            this.showAdd = false;
        },

        empAdd(){
            let fd = new FormData();
                fd.append('gender', this.data.gender);
                fd.append('name', this.data.name);
                fd.append('surname', this.data.surname);
                fd.append('namelao', this.data.namelao);
                fd.append('surnamelao', this.data.surnamelao);
                fd.append('phone', this.data.phone);
                fd.append('birthday', this.data.birthday);
                fd.append('email', this.data.email);
                fd.append('country', this.data.country);
                fd.append('province', this.data.province);
                fd.append('district', this.data.district);
                fd.append('village', this.data.village);
                fd.append('startdate', this.data.startdate);
                fd.append('enddate', this.data.enddate);
                fd.append('position', this.data.position);
                fd.append('status', this.data.status);
                fd.append('contract', this.data.contract);
                fd.append('levels', this.data.levels);
                fd.append('empid', this.data.empid);
                fd.append('scanid', this.data.scanid);
                fd.append('foodid', this.data.foodid);
                fd.append('roster', this.data.roster);
                fd.append('scantimes', this.data.scantimes);
                fd.append('hours', this.data.hours);
                fd.append('site', this.data.site);
                fd.append('dept', this.data.dept);
                fd.append('section', this.data.section);
                fd.append('crew', this.data.crew);
                fd.append('photo', this.data.photo);

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post('api/employee/add', fd, {headers:{"Content-Type": "multipart/form-date"}})
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
            this.$swal.fire({
                text: "Do you want to save the changes?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fe fe-save"></i> <span class="font-weight-light">Save</span>',
                cancelButtonText: '<i class="fe fe-x"></i> <span class="font-weight-light">Cancel</span>',
                allowEnterKey: false,
                allowOutsideClick: false,
            }).then((result)=>{
                if(result.isConfirmed){
                    let fd = new FormData();
                        fd.append('id', this.data.userid);
                        fd.append('gender', this.data.gender);
                        fd.append('name', this.data.name);
                        fd.append('surname', this.data.surname);
                        fd.append('namelao', this.data.namelao);
                        fd.append('surnamelao', this.data.surnamelao);
                        fd.append('phone', this.data.phone);
                        fd.append('birthday', this.data.birthday);
                        fd.append('email', this.data.email);
                        fd.append('country', this.data.country);
                        fd.append('province', this.data.province);
                        fd.append('district', this.data.district);
                        fd.append('village', this.data.village);
                        fd.append('photo', this.data.photo);
                    
                    this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                        this.$axios.post('api/employee/update', fd, {headers:{"Content-Type": "multipart/form-date"}})
                        .then((response)=>{

                            this.getEmpList();
                            this.showAdd = false;
                            this.showList = true;

                        }).catch((error)=>{
                            console.log(error);
                        })
                    });
                }
            });
        },

        empDel(id){
            if (this.$store.getters.usertype == 'user' || this.$store.getters.usertype == 'admin'){
                this.$swal.fire({
                    text: "You don't have permission to delete employee!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1000

                })
            } else {

                this.$swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="font-weight-light">Delete</span>',
                    cancelButtonText: '<i class="fe fe-x"></i> <span class="font-weight-light">Cancel</span>',
                    confirmButtonColor: '#d33',
                    allowEnterKey: false,
                    allowOutsideClick: false,
                }).then((result)=>{
                    if(result.isConfirmed){
                        this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                            this.$axios.post(`/api/employee/delete/${id}`)
                            .then((response)=>{

                                this.search = '';
                                this.btnClear = false;
                                this.getEmpList();

                                this.$swal.fire({
                                    title: 'Deleted!',
                                    text: 'The employee has been deleted.',
                                    icon: 'success',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    timerProgressBar: true,
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

        async getDetail(id){
            const response = await axios.post(`api/employee/detail/${id}`)
            this.detail = response.data;
        },

        detailNew(){
            $('#detailAddEdit').modal('show');
            this.detailClear();
            this.btnDetailUpdate = false;
            this.btnDetailAdd = true;

        },

        detailAdd(){
            let fd = new FormData();
                fd.append('userid', this.data.userid);
                fd.append('site', this.data.site);
                fd.append('startdate', this.data.startdate);
                fd.append('enddate', this.data.enddate);
                fd.append('status', this.data.status);
                fd.append('position', this.data.position);
                fd.append('dept', this.data.dept);
                fd.append('section', this.data.section);
                fd.append('crew', this.data.crew);
                fd.append('empid', this.data.empid);
                fd.append('scanid', this.data.scanid);
                fd.append('foodid', this.data.foodid);
                fd.append('roster', this.data.roster);
                fd.append('scantimes', this.data.scantimes);
                fd.append('hours', this.data.hours);
                fd.append('levels', this.data.levels);
                fd.append('contract', this.data.contract);
                fd.append('remarks', this.data.remarks);

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post('api/employee/detailAdd', fd, {headers:{"Content-Type": "multipart/form-date"}})
                .then((response)=>{
                    if(response.data.success){

                        $('#detailAddEdit').modal('hide');
                        this.getDetail(this.data.userid);
                        this.getEmpList();

                    } else {
                        alert(response.data.message)
                    }
                }).catch((error)=>{
                    console.log(error);
                })
            });
        },

        detailEdit(id){
            $('#detailAddEdit').modal('show');
            this.$axios.post(`/api/employee/detailEdit/${id}`)
            .then((response)=>{

                this.detailClear();
                this.btnDetailAdd = false;
                this.btnDetailUpdate = true;

                this.data.id = response.data.id;
                this.data.site = response.data.site;
                this.data.startdate = response.data.startdate;
                this.data.enddate = response.data.enddate;
                this.data.status = response.data.status;
                this.data.position = response.data.position;
                this.data.dept = response.data.department;
                this.data.section = response.data.section;
                this.data.crew = response.data.crew;
                this.data.empid = response.data.empid;
                this.data.scanid = response.data.scanid;
                this.data.foodid = response.data.foodid;
                this.data.roster = response.data.roster;
                this.data.scantimes = response.data.scantimes;
                this.data.hours = response.data.working_hrs;
                this.data.levels = response.data.levels;
                this.data.contract = response.data.contract;
                this.data.remarks = response.data.remarks;

            }).catch((error)=>{
                console.log(error);
            })
        },

        detailUpdate(id){
            let fd = new FormData();
                fd.append('id', this.data.id);
                fd.append('site', this.data.site);
                fd.append('startdate', this.data.startdate);
                fd.append('enddate', this.data.enddate);
                fd.append('status', this.data.status);
                fd.append('position', this.data.position);
                fd.append('dept', this.data.dept);
                fd.append('section', this.data.section);
                fd.append('crew', this.data.crew);
                fd.append('empid', this.data.empid);
                fd.append('scanid', this.data.scanid);
                fd.append('foodid', this.data.foodid);
                fd.append('roster', this.data.roster);
                fd.append('scantimes', this.data.scantimes);
                fd.append('hours', this.data.hours);
                fd.append('levels', this.data.levels);
                fd.append('contract', this.data.contract);
                fd.append('remarks', this.data.remarks);
            
            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post('api/employee/detailUpdate', fd, {headers:{"Content-Type": "multipart/form-date"}})
                .then((response)=>{

                    $('#detailAddEdit').modal('hide');
                    this.getDetail(this.data.userid);
                    this.getEmpList();

                }).catch((error)=>{
                    console.log(error);
                })
            });
        },

        detailDel(id){
            if (this.$store.getters.usertype == 'user' || this.$store.getters.usertype == 'admin'){
                this.$swal.fire({
                    text: "You don't have permission to delete!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1000
                })
            } else {

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
                        this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                            this.$axios.post(`/api/employee/detailDel/${id}`)
                            .then((response)=>{

                                this.getDetail(this.data.userid);
                                this.getEmpList();

                            }).catch((error)=>{
                                console.log(error);
                            })
                        })
                    }
                });
            }

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

        chooseImage(){
            this.$refs.fileInput.click()
        },

        onSeclected(event){
            this.data.photo = event.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(this.data.photo);
            reader.addEventListener("load", function(){
                this.photoPrev = reader.result;
            }.bind(this), false);
		},

        empClear(){
            let f = this.data;
            f.gender = 'Male';
            f.name = '';
            f.surname = '';
            f.namelao = '';
            f.surnamelao = '';
            f.phone = '';
            f.birthday = '';
            f.email = '';
            f.country = '';
            f.province = '';
            f.district = '';
            f.village = '';
            f.photo = '';
            this.photoPrev = window.location.origin + '/assets/img/no.jpg'
        },

        detailClear(){
            let f = this.data;
            f.startdate = '';
            f.enddate = '';
            f.position = '';
            f.contract = '';
            f.levels = '';
            f.empid = '';
            f.scanid = '';
            f.foodid = '';
            f.roster = '';
            f.scantimes = '';
            f.hours = '9';
            f.site = '';
            f.dept = '';
            f.section = '';
            f.crew = '';
            f.remarks = '';
        },

        async getLookup(){
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

        userType(){
            if(this.$store.getters.usertype == 'admin'){
                this.btnEdit = '';
                this.btnEmpNew = true;
            } else if(this.$store.getters.usertype == 'full'){
                this.btnEmpNew = true;
                this.btnEdit = '';
                this.btnDel ='';
            }
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
        this.getLookup();
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

    .bad{
        position: absolute;
        height: 12px;
        width: 12px;
        border: 2px solid white;
        right: 8px;
        bottom: 2px;
    }
    .cur-pointer{
        cursor: pointer;
    }

    /* Search box */
    .search-i{
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
    }
    .search-c:hover{
        background: #E9EBEC;
    }
    .search-c{ 
        position: absolute;
        z-index: 999;
        top: 50%;
        transform: translateY(-50%);
        right: 5px;
        width: 30px;
        height: 30px;
        color: gray;
        border-radius: 50px;
    }

    .tr-hover:hover{
        background: #f9f9ff; 
    }

	/* Button icon */
	.btn-i:hover{
		background: #E9EBEC;
        color: blue;
	}
	.btn-i{
		border-radius: 50px;
	}

</style>