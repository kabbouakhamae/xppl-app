<template>
    <div>
        <div class="card">
            <div class="card-body">
                <div v-if="showList">
                    <div class="breadcrumb-header justify-content-between align-items-center mb-2 mt-0" >
                        <div class="d-flex">
                            <h4 class="card-title text-muted mb-0 my-auto">Employee List</h4>
                        </div>
                        <div class="d-flex my-xl-auto right-content align-items-center">
                            <div class="pos-relative me-1" style="width: 100%">
                                <input class="form-control pd-l-30" type="text" placeholder="Search by name..." v-model="search" @input="searchChange()" >
                                    <i class="fe fe-search search-i text-muted"></i>
                                <button class="btn btn-icon btn-sm search-c text-muted" v-if="btnClear" @click="searchClear()"><i class="fe fe-x"></i></button>
                            </div>
                            <div style="width: 40px">
                                <button type="button" class="btn ripple btn-primary" style="padding: 0px; width: 40px; height: 39.5px" title="Add new employee" @click="empNew()"><i class="mdi mdi-account-plus tx-20"></i></button>
                            </div>
                        </div>
                    </div>

                    <!-- Employee table -->
                    <div class="table-responsive userlist-table">
                        <table class="table card-table text-nowrap mb-0">
                            <thead class="bg-gray-100" style="border-bottom: 0.5px solid #ECEFF6">
                                <tr>
                                    <th style="letter-spacing: 0px; width: 10px; padding: 6px 4px 6px 4px" class="text-muted fw-bold"><span>Image</span></th>
                                    <th style="letter-spacing: 0px; width: 50px; padding: 6px 12px 6px 0px" class="text-muted fw-bold"><span>Name</span></th>
                                    <th style="letter-spacing: 0px; padding: 6px 12px" class="text-muted fw-bold">
                                        <div v-if="!!parseInt(loginPermiss.emp_all)">Position / Dept.</div>
                                        <div v-else>Position</div>
                                    </th>
                                    <th style="letter-spacing: 0px; padding: 6px 12px" class="text-muted fw-bold">Phone Number</th>
                                    <th style="letter-spacing: 0px; padding: 6px 12px" class="text-muted fw-bold">Country</th>
                                    <th style="letter-spacing: 0px; padding: 6px 12px" class="text-muted fw-bold"><span>ID</span><span class="text-lowercase">s</span></th>
                                    <th style="letter-spacing: 0px; padding: 6px 12px" class="text-muted fw-bold">Started</th>
                                    <th style="letter-spacing: 0px; padding: 6px 12px" class="text-muted fw-bold">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="tx-13">
                                <tr class="tr-hover" v-for="list in empData.data" :key="list.id">
                                    <td style="padding: 6px 4px 6px 0px; border: none">
                                        <div class="pos-relative">
                                            <img v-if="list.photo" alt="" class="rounded-circle avatar-md me-2 cur-pointer" :src="'assets/img/profile/'+ list.photo" @click="empPrev(list.id)">                                   
                                            <img v-if="!list.photo && list.gender == 'Male'" alt="" class="rounded-circle avatar-md me-2 cur-pointer" src="assets/img/male.png" @click="empPrev(list.id)">
                                            <img v-if="!list.photo && list.gender != 'Male'" alt="" class="rounded-circle avatar-md me-2 cur-pointer" src="assets/img/female.png" @click="empPrev(list.id)">
                                            <span v-if="list.status == 'Current' || list.status == 'Temporary'" class="rounded-circle bg-success bad"></span>
                                        </div>
                                    </td>
                                    <td style="padding: 6px 12px 6px 0px; border-top: 0px; border-bottom: 0.5px solid #e3e8f7">
                                        {{ list.name }} {{ list.surname }} <br>
                                        <span class="laofont">{{ list.namelao }} {{ list.surnamelao }}</span>
                                    </td>
                                    <td style="padding: 6px 12px; border-top: 0px; border-bottom: 0.5px solid #e3e8f7"> 
                                        {{ list.position }}
                                        <div v-if="!!parseInt(loginPermiss.emp_all)">{{ list.department }}</div>
                                    </td>
                                    <td style="padding: 6px 12px; border-top: 0px; border-bottom: 0.5px solid #e3e8f7"> 
                                        <i v-if="list.phone" class="fa fa-tty me-1"></i> {{ list.phone}} 
                                    </td>
                                    <td style="padding: 6px 12px; border-top: 0px; border-bottom: 0.5px solid #e3e8f7">
                                        <img width="20" class="me-1" :src="'assets/img/flags/'+ list.country + '.png'" alt="" >{{ list.country }}
                                    </td>
                                    <td style="padding: 6px 12px; border-top: 0px; border-bottom: 0.5px solid #e3e8f7">
                                        <div v-if="list.empid">
                                            <!-- <i class="far fa-address-card me-1"></i> -->
                                            {{ list.empid }}
                                        </div>
                                        <div v-if="list.scanid">
                                            <!-- <i class="cf cf-cloak me-1"></i> {{ list.scanid }} -->
                                            <!-- <img width="15" src="assets/img/scan.jpg">  -->
                                            Scan: {{ list.scanid }}
                                        </div>
                                    </td>
                                    <td style="padding: 6px 12px; border-top: 0px; border-bottom: 0.5px solid #e3e8f7"> 
                                        {{ timeago(list.startdate) }} <br>
                                        {{ list.status }}
                                    </td>
                                    <td style="padding: 6px 12px; border-top: 0px; border-bottom: 0.5px solid #e3e8f7">        
                                        <button class="btn btn-icon btn-sm btn-i wd-38 ht-38 pos-relative" data-bs-toggle="dropdown" title="Actions">
                                            <i class="mdi mdi-dots-horizontal text-gray pos-absolute" style="left: 50%; transform: translateX(-50%); top: 50%"></i>
                                        </button>       
                                        <div class="dropdown-menu tx-13">
                                            <div class="dropdown-item cur-pointer dropdown-hover" @click="empPrev(list.id)">
                                                <i class="fe fe-search me-2"></i><span>Preview</span>
                                            </div>
                                            <div class="dropdown-item cur-pointer dropdown-hover" @click="empEdit(list.id)">
                                                <i class="fe fe-edit me-2"></i><span>Edit</span>
                                            </div>
                                            <div class="dropdown-item cur-pointer dropdown-hover" @click="empDel(list.id)">
                                                <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <pagination :pagination="empData" @paginate="getEmpData($event)" :offset="2"></pagination>
                </div> <!-- End employee list -->

                <!-- Add and Edit employee -->
                <div v-if="showAdd">
                    <div class="row">
                        <div class="col-xxl-2">
                            <div style="height: 200px; width: 100%;">
                                <img class="cur-pointer" style="width: 160px; height: 200px; border: solid 1px #cccc;" title="Choose an Image" :src="photoPrev" @click="chooseImage">
                                <!-- <img class="cur-pointer" style="width: 160px; height: 200px; border: solid 1px #cccc;" title="Choose an Image" src="assets/img/no.jpg" @click="chooseImage"> -->
                                <input class="d-none" ref="fileInput" type="file" accept="image/*"  @change="onSeclected">
                            </div> 
                            <label class="rdiobox mt-4 cur-pointer"><input name="rdio" type="radio" value="Male" checked="" v-model="empForm.gender"><span>Male</span></label>
                            <label class="rdiobox mb-4 cur-pointer"><input name="rdio" type="radio" value="Female" v-model="empForm.gender"><span>Female</span></label>                         
                        </div>

                        <div class="col-xxl-10">
                            <!-- Row1 -->
                            <div class="row">
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Name Eng  <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Name..." v-model="empForm.name">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Surname Eng</label>
                                        <input type="text" class="form-control" placeholder="Surname..." v-model="empForm.surname">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12">
                                    <div class="form-group">
                                        <label class="mb-0">Phone Number</label>
                                        <input type="text" class="form-control" placeholder="Phone numbers..." v-model="empForm.phone">
                                    </div>
                                </div>
                            </div>

                            <!-- Row2 -->
                            <div class="row">
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Name Lao  <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control laofont" placeholder="ຊື່..." v-model="empForm.namelao">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Surname Lao</label>
                                        <input type="text" class="form-control laofont" placeholder="ນາມສະກຸນ..." v-model="empForm.surnamelao">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-4 col-md-4 col-sm-4">
                                    <div class="form-group">
                                        <label class="mb-0">Birthday</label>
                                        <input type="date" class="form-control" v-model="empForm.birthday">
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-8 col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <label class="mb-0">Email</label>
                                        <input type="eamil" class="form-control" placeholder="Email..." v-model="empForm.email">
                                    </div>
                                </div>
                            </div>

                            <!-- Row3 -->
                            <h6 class="text-muted mt-2">Employee Address</h6>
                            <div class="row">
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-4">
                                    <div class="form-group">
                                        <label class="mb-0">Country  <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="empForm.country" placeholder="Select" :options="lkCountry"/>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-8 col-md-6 col-sm-8">
                                    <div class="form-group">
                                        <label class="mb-0">Province</label>
                                        <input type="text" class="form-control laofont" placeholder="Province..." v-model="empForm.province">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">District</label>
                                        <input type="text" class="form-control laofont" placeholder="District..." v-model="empForm.district">
                                    </div>
                                </div>
                                <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6">
                                    <div class="form-group">
                                        <label class="mb-0">Village</label>
                                        <input type="text" class="form-control laofont" placeholder="Village..." v-model="empForm.village">
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
                                            <input type="date" class="form-control" v-model="empForm.startdate">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">End Date</label>
                                            <input type="date" class="form-control" v-model="empForm.enddate">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12">
                                        <div class="form-group">
                                            <label class="mb-0">Position  <span class=" text-danger">*</span></label> 
                                            <Multiselect class="multi-color" v-model="empForm.position" placeholder="Select" searchable="true" :options="lkPosition"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Contract Type</label> 
                                            <Multiselect class="multi-color" v-model="empForm.contract" placeholder="Select" :options="lkContract"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Levels</label> 
                                            <Multiselect class="multi-color" v-model="empForm.levels" placeholder="Select" :options="lkLevels"/>
                                        </div>
                                    </div>
                                </div>
                                <!-- Row5 -->
                                <div class="row">
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Employee ID</label>
                                            <input type="text" class="form-control" placeholder="Employee id..." v-model="empForm.empid">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Scan ID  <span class=" text-danger">*</span></label>
                                            <input type="number" class="form-control" placeholder="Scan id..." v-model="empForm.scanid">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Food ID</label>
                                            <input type="text" class="form-control" placeholder="Food id..." v-model="empForm.foodid">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Roster  <span class=" text-danger">*</span></label> 
                                            <Multiselect class="multi-color" v-model="empForm.roster" placeholder="Select" :options="lkRoster"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Scan Times  <span class=" text-danger">*</span></label> 
                                            <Multiselect class="multi-color" v-model="empForm.scantimes" placeholder="Select" :options="lkScantimes"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-4 col-sm-4 col-6">
                                        <div class="form-group">
                                            <label class="mb-0">Working hrs  <span class=" text-danger">*</span></label>
                                            <input type="number" class="form-control" placeholder="Working hrs..." v-model="empForm.hours">
                                        </div>
                                    </div>
                                </div>
                                <!-- Row6 -->
                                <div class="row">
                                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-4">
                                        <div class="form-group">
                                            <label class="mb-0">Site  <span class=" text-danger">*</span></label> 
                                            <Multiselect class="multi-color" v-model="empForm.site" placeholder="Select" :options="lkSite"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-9 col-md-8 col-sm-8">
                                        <div class="form-group">
                                            <label class="mb-0">Department  <span class=" text-danger">*</span></label> 
                                            <Multiselect class="multi-color" v-model="empForm.dept" placeholder="Select" searchable="true" :options="lkDept"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="mb-0">Section</label> 
                                            <Multiselect class="multi-color" v-model="empForm.section" placeholder="Select" searchable="true" :options="lkSection"/>
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <label class="mb-0">Crew</label> 
                                            <Multiselect class="multi-color" v-model="empForm.crew" placeholder="Select" searchable="true" :options="lkCrew"/>
                                        </div>
                                    </div>
                                </div>
                            </div>  <!-- End of employee detail --> 
                        </div>
                    </div>
                    
                    <!-- Tabs -->
                    <div class="panel panel-primary tabs-style-2 mt-4" v-if="showTab">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab1" class="nav-link active" style="padding: 4px 18px" data-bs-toggle="tab">Employee Detail</a></li>
					                <li><a href="#tab2" class="nav-link" :class="actTab" style="padding: 4px 18px" data-bs-toggle="tab">Contact Person</a></li>
					                <li><a href="#tab3" class="nav-link" :class="actTab" style="padding: 4px 18px" data-bs-toggle="tab">Bank Acount</a></li>
					                <li><a href="#tab4" class="nav-link" :class="actTab" style="padding: 4px 18px" data-bs-toggle="tab">Personal Cards</a></li>
					                <li><a href="#tab5" class="nav-link" :class="actTab" style="padding: 4px 18px" data-bs-toggle="tab">Annual Leave</a></li>
					                <li><a href="#tab6" class="nav-link" :class="actTab" style="padding: 4px 18px" data-bs-toggle="tab">Document and File</a></li>
                                </ul>
                            </div>
                        </div>
                       
                       <!-- Details -->
                        <div class="panel-body tabs-menu-body main-content-body-right" style="padding: 6px 0px">
                            <div class="tab-content">
                                <div class="tab-pane overflow-auto active" id="tab1">
                                    <div class="table-responsive" style="height: 270px">
                                        <table class="table main-table-reference text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="padding: 0px 0px; vertical-align: middle; width: 34px; height: 26px">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-icon btn-sm btn-add wd-25 ht-25" @click="detailNew()" title="Add new detail">
                                                                <i class="fa fa-plus-circle text-primary" style="font-size: 15px"></i>
                                                            </button> 
                                                        </div>
                                                    </th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Site</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Start Date</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">End Date</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Status</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Position</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Department</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Section</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Crew</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Employee ID</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Scan ID</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Food ID</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Roster</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Scan Times</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Hours</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Levels</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">contact</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <tr class="tr-hover" v-for="lst in detailData" :key="lst.id">
                                                    <td style="padding: 0px 4px; vertical-align: middle">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" data-bs-toggle="dropdown" title="Tools">
                                                                <i class="fa fa-ellipsis-h" style="font-size: 11px; color: #606469"></i>
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
                                                    <td class="text-center" style="padding: 3px 10px"> {{ lst.site }} </td>
                                                    <td style="padding: 3px 10px"> {{ dateTime(lst.startdate) }} </td>
                                                    <td style="padding: 3px 10px"> {{ dateTime(lst.enddate) }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.status }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.position }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.department }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.section }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.crew }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.empid }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.scanid }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.foodid }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.roster }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.scantimes }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.working_hrs }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.levels }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.contact }} </td>
                                                    <td style="padding: 3px 10px" class="laofont"> {{ lst.remarks }} </td>
                                                </tr>                                                  
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- contact person -->
                                <div class="tab-pane overflow-auto" :class="actTab" id="tab2">
                                    <div class="table-responsive" style="height: 270px">
                                        <table class="table main-table-reference text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="padding: 0px 0px; vertical-align: middle; width: 34px; height: 26px">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-icon btn-sm btn-add wd-25 ht-25" @click="contactNew()" title="Add new contact">
                                                                <i class="fa fa-plus-circle text-primary" style="font-size: 15px"></i>
                                                            </button> 
                                                        </div>
                                                    </th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">contact Person</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">relate</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Phone</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px; width: 60%">Address</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <tr class="tr-hover" v-for="lst in contData" :key="lst.id">
                                                    <td style="padding: 0px 4px; vertical-align: middle">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-icon btn-sm btn-i wd-25 ht-25"  data-bs-toggle="dropdown" title="Actions">
                                                                <i class="fa fa-ellipsis-h" style="font-size: 11px; color: #606469"></i>
                                                            </button> 
                                                            <div class="dropdown-menu tx-13">
                                                                <div class="dropdown-item cur-pointer dropdown-hover" @click="contactEdit(lst.id)">
                                                                    <i class="fe fe-edit me-2"></i><span>Edit</span>
                                                                </div>
                                                                <div class="dropdown-item cur-pointer dropdown-hover" @click="contactDel(lst.id)">
                                                                    <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="padding: 3px 10px" class="laofont"> {{ lst.name }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.relate }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.phone }} </td>
                                                    <td style="padding: 3px 10px" class="laofont"> {{ lst.address }} </td>
                                                </tr>                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <!-- Bank Account -->
                                <div class="tab-pane overflow-auto" :class="actTab" id="tab3">
                                    <div class="table-responsive" style="height: 270px">
                                        <table class="table main-table-reference text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="padding: 0px 0px; vertical-align: middle; width: 34px; height: 26px">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-icon btn-sm btn-add wd-25 ht-25" @click="bankNew()" title="Add new bank info">
                                                                <i class="fa fa-plus-circle text-primary" style="font-size: 15px"></i>
                                                            </button> 
                                                        </div>
                                                    </th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Bank Name</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Branch</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Account Name</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Account No</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px; width: 60%">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <tr class="tr-hover" v-for="lst in bankData" :key="lst.id">
                                                    <td style="padding: 0px 4px; vertical-align: middle">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-icon btn-sm btn-i wd-25 ht-25"  data-bs-toggle="dropdown" title="Actions">
                                                                <i class="fa fa-ellipsis-h" style="font-size: 11px; color: #606469"></i>
                                                            </button> 
                                                            <div class="dropdown-menu tx-13">
                                                                <div class="dropdown-item cur-pointer dropdown-hover" @click="bankEdit(lst.id)">
                                                                    <i class="fe fe-edit me-2"></i><span>Edit</span>
                                                                </div>
                                                                <div class="dropdown-item cur-pointer dropdown-hover" @click="bankDel(lst.id)">
                                                                    <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="padding: 3px 10px"> {{ lst.bank_name }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.branch }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.acct_name }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.acct_no }} </td>
                                                    <td style="padding: 3px 10px" class="laofont"> {{ lst.remarks }} </td>
                                                </tr>                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Personal cards -->
                                <div class="tab-pane overflow-auto" :class="actTab" id="tab4">
                                    <div class="table-responsive" style="height: 270px">
                                        <table class="table main-table-reference text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="padding: 0px 0px; vertical-align: middle; width: 34px; height: 26px">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-icon btn-sm btn-add wd-25 ht-25" @click="cardNew()" title="Add new bank info">
                                                                <i class="fa fa-plus-circle text-primary" style="font-size: 15px"></i>
                                                            </button> 
                                                        </div>
                                                    </th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Card Type</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Card ID</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Expire Date</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px; width: 60%">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <tr class="tr-hover" v-for="lst in cardData" :key="lst.id">
                                                    <td style="padding: 0px 4px; vertical-align: middle">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-icon btn-sm btn-i wd-25 ht-25"  data-bs-toggle="dropdown" title="Actions">
                                                                <i class="fa fa-ellipsis-h" style="font-size: 11px; color: #606469"></i>
                                                            </button> 
                                                            <div class="dropdown-menu tx-13">
                                                                <div class="dropdown-item cur-pointer dropdown-hover" @click="cardEdit(lst.id)">
                                                                    <i class="fe fe-edit me-2"></i><span>Edit</span>
                                                                </div>
                                                                <div class="dropdown-item cur-pointer dropdown-hover" @click="cardDel(lst.id)">
                                                                    <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="padding: 3px 10px"> {{ lst.cardtype }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.cardid }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.expiredate }} </td>
                                                    <td style="padding: 3px 10px" class="laofont"> {{ lst.remarks }} </td>
                                                </tr>                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Annual Leave -->
                                <div class="tab-pane overflow-auto" :class="actTab" id="tab5">
                                    <div class="table-responsive" style="height: 270px">
                                        <table class="table main-table-reference text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="padding: 0px 0px; vertical-align: middle; width: 34px; height: 26px">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-icon btn-sm btn-add wd-25 ht-25" @click="alNew()" title="Add new bank info">
                                                                <i class="fa fa-plus-circle text-primary" style="font-size: 15px"></i>
                                                            </button> 
                                                        </div>
                                                    </th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Year</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px">Remain</th>
                                                    <th style="letter-spacing: 0px; padding: 4px 10px; width: 80%">Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <tr class="tr-hover" v-for="lst in alData" :key="lst.id">
                                                    <td style="padding: 0px 4px; vertical-align: middle">
                                                        <div class="d-flex justify-content-center">
                                                            <button class="btn btn-icon btn-sm btn-i wd-25 ht-25"  data-bs-toggle="dropdown" title="Actions">
                                                                <i class="fa fa-ellipsis-h" style="font-size: 11px; color: #606469"></i>
                                                            </button> 
                                                            <div class="dropdown-menu tx-13">
                                                                <div class="dropdown-item cur-pointer dropdown-hover" @click="alEdit(lst.id)">
                                                                    <i class="fe fe-edit me-2"></i><span>Edit</span>
                                                                </div>
                                                                <div class="dropdown-item cur-pointer dropdown-hover" @click="alDel(lst.id)">
                                                                    <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="padding: 3px 10px"> {{ lst.years }} </td>
                                                    <td style="padding: 3px 10px"> {{ lst.remain }} </td>
                                                    <td style="padding: 3px 10px" class="laofont"> {{ lst.remarks }} </td>
                                                </tr> 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Document and Files -->
                                <div class="tab-pane overflow-auto" :class="actTab" id="tab6">
                                    <div class="table-responsive" style="height: 270px">
                                        <table class="table main-table-reference text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th style="padding: 0px 0px; height: 26px">                                                    
                                                        <div class="ms-1 d-flex justify-content-start align-items-center">
                                                            <button class="btn btn-icon btn-sm btn-add wd-25 ht-25" @click="fileNew()" title="Add new files">
                                                                <i class="fa fa-plus-circle text-primary" style="font-size: 15px"></i>
                                                                <input class="d-none" ref="fileInput2" type="file" multiple  @change="fileAdd()" >
                                                            </button>                                                        
                                                            <div class="" style="letter-spacing: 0px; padding: 4px 10px">File Name</div>
                                                        </div>
                                                    </th>
                                                    <!-- <th style="letter-spacing: 0px; padding: 4px 10px">Description</th> -->
                                                    <th style="letter-spacing: 0px; padding: 4px 10px; width: 80%">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <tr class="tr-hover" v-for="lst in fileData" :key="lst.id">
                                                    <td style="padding: 3px 10px"> {{ lst.filename }} </td>
                                                    <td style="padding: 0px 10px; vertical-align: middle;"> 
                                                        <div class="d-flex justify-content-start">
                                                            <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" title="Download file" @click="fileDownload(lst.filename)">
                                                                <i class="bx bxs-download text-primary" style="font-size: 16px"></i>
                                                            </button> 
                                                            <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" title="Delete file" @click="fileDel(lst.filename)">
                                                                <i class="bx bx-trash text-danger" style="font-size: 16px"></i>
                                                            </button> 
                                                        </div>
                                                    </td>
                                                </tr>                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- EndTabs -->

                    <div class="d-flex justify-content-end mt-2">
                        <button v-if="btnEmpUpd" type="button" class="btn btn-info btn-b" :class="btnEmpUpdShow" @click="empUpdate()"><i class="fe fe-check-circle"></i> 
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
            <div class="modal fade effect-scale" id="empPreview" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="empPreviewLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl"> <!-- modal-dialog-centered  -->
                    <div class="modal-content">
                        <div class="modal-header">
                            <!-- <h5 class="modal-title" id="staticBackdropLabel">Sign In</h5> -->
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                            <h6 class="modal-title text-muted">Employee Info.</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>

                        </div>
                        <div class="modal-body">
                            <h1>Preview</h1>
                            {{ lkCountry }}

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary">Insert Data</button>
                        </div>
                    </div>
                </div>                                              
            </div> <!-- End of modal employee preview -->

            <!-- Modal add edit detail -->
            <div class="modal fade effect-scale" id="detailAddEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailAddEditLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted">Employee details</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <!-- Row1 -->
                            <div class="row">
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Site  <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="empForm.site" placeholder="Select" :options="lkSite"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Start Date  <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" placeholder="Working hrs..." v-model="empForm.startdate">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">End Date</label>
                                        <input type="date" class="form-control" placeholder="Working hrs..." v-model="empForm.enddate">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Status  <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="empForm.status" placeholder="Select" :options="lkStatus"/>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-0">Position  <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="empForm.position" placeholder="Select" searchable="true" :options="lkPosition"/>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-0">Department  <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="empForm.dept" placeholder="Select" searchable="true" :options="lkDept"/>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-0">Section</label> 
                                        <Multiselect class="multi-color" v-model="empForm.section" placeholder="Select" searchable="true" :options="lkSection"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Crew</label> 
                                        <Multiselect class="multi-color" v-model="empForm.crew" placeholder="Select" searchable="true" :options="lkCrew"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Employee ID</label>
                                        <input type="text" class="form-control" placeholder="Employee id..." v-model="empForm.empid">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Scan ID <span class=" text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Scan id..." v-model="empForm.scanid">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Food ID</label>
                                        <input type="text" class="form-control" placeholder="Food id..." v-model="empForm.foodid">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Roster  <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="empForm.roster" placeholder="Select" :options="lkRoster"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Scan Times  <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="empForm.scantimes" placeholder="Select" :options="lkScantimes"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Working hrs  <span class=" text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Working hrs..." v-model="empForm.hours">
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Levels</label> 
                                        <Multiselect class="multi-color" v-model="empForm.levels" placeholder="Select" :options="lkLevels"/>
                                    </div>
                                </div>
                                <div class="col-xl-2 col-lg-6">
                                    <div class="form-group">
                                        <label class="mb-0">contact Type</label> 
                                        <Multiselect class="multi-color" v-model="empForm.contract" placeholder="Select" :options="lkContract"/>
                                    </div>
                                </div>
                                <div class="col-xl-10">
                                    <div class="form-group">
                                        <label class="mb-0">Remarks</label>
                                        <input type="text" class="form-control laofont" placeholder="Remarks..." v-model="empForm.remarks">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="modal-footer">
                            <button v-if="btnDetailUpd" type="button" class="btn btn-info btn-b" :class="btnDetailShow" @click="detailUpdate()"><i class="fe fe-check-circle"></i> 
                                <span class="mx-1">Update</span>
                            </button>
                            <button v-if="btnDetailAdd" type="button" class="btn btn-primary" :class="btnDetailShow" @click="detailAdd()"><i class="fe fe-plus"></i> 
                                <span class="mx-1">Add</span>
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fe fe-x"></i> 
                                <span class="mx-1">Close</span>
                            </button>
                        </div>
                    </div>
                </div>                                              
            </div> <!-- End of modal add edit detail -->

            <!-- Modal contact -->
            <div class="modal fade effect-scale" id="contact" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="contactLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted">Contact Person</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-7 col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control laofont" placeholder="Full name..." v-model="contForm.name">
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">relate <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="contForm.relate" placeholder="Select" searchable="true"  :options="lkRelate"/>
                                    </div>
                                </div>
                                <div class="col-lg-5 col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">Phone  <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Phone number..." v-model="contForm.phone">
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">Address</label>
                                        <input type="text" class="form-control laofont" placeholder="Address..." v-model="contForm.address">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="btnContUpd" type="button" class="btn btn-info btn-b" :class="btnContAddShow" @click="contactUpdate()"><i class="fe fe-check-circle"></i> 
                                <span class="mx-1">Update</span>
                            </button>
                            <button v-if="btnContAdd" type="button" class="btn btn-primary" :class="btnContAddShow" @click="contactAdd()"><i class="fe fe-plus"></i> 
                                <span class="mx-1">Add</span>
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fe fe-x"></i> 
                                <span class="mx-1">Close</span>
                            </button>
                        </div>
                    </div>
                </div>                                              
            </div> <!-- End of modal contact -->

            <!-- Modal bank info -->
            <div class="modal fade effect-scale" id="bank" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="bankLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted">Bank Account</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">Bank Name <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="bankForm.bankname" placeholder="Select" searchable="true"  :options="lkBank"/>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">Branch</label>
                                        <input type="text" class="form-control" placeholder="Branch..." v-model="bankForm.branch">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">Account Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Account name..." v-model="bankForm.acctname">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">Account No <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Account no..." v-model="bankForm.acctno">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="mb-0">Remarks</label>
                                        <input type="text" class="form-control laofont" placeholder="Remarks..." v-model="bankForm.remarks">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="btnBankUpd" type="button" class="btn btn-info btn-b" :class="btnBankAddShow" @click="bankUpdate()"><i class="fe fe-check-circle"></i> 
                                <span class="mx-1">Update</span>
                            </button>
                            <button v-if="btnBankAdd" type="button" class="btn btn-primary" :class="btnBankAddShow" @click="bankAdd()"><i class="fe fe-plus"></i> 
                                <span class="mx-1">Add</span>
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fe fe-x"></i> 
                                <span class="mx-1">Close</span>
                            </button>
                        </div>
                    </div>
                </div>                                              
            </div> <!-- End of modal contact -->

            <!-- Modal Personal Cards -->
            <div class="modal fade" id="cards" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cardLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted">Personal Cards</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">Card Type <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="cardForm.cardtype" placeholder="Select" :options="lkCard"/>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">Card ID <span class=" text-danger">*</span></label>
                                        <input type="text" class="form-control" placeholder="Card id..." v-model="cardForm.cardid">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">Expire Date</label>
                                        <input type="date" class="form-control" placeholder="Expire date..." v-model="cardForm.expire">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="mb-0">Remarks</label>
                                        <input type="text" class="form-control laofont" placeholder="Remarks..." v-model="cardForm.remarks">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="btnCardUpd" type="button" class="btn btn-info btn-b" :class="btnCardAddShow" @click="cardUpdate()"><i class="fe fe-check-circle"></i> 
                                <span class="mx-1">Update</span>
                            </button>
                            <button v-if="btnCardAdd" type="button" class="btn btn-primary" :class="btnCardAddShow" @click="cardAdd()"><i class="fe fe-plus"></i> 
                                <span class="mx-1">Add</span>
                            </button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fe fe-x"></i> 
                                <span class="mx-1">Close</span>
                            </button>
                        </div>
                    </div>
                </div>                                              
            </div>

            <!-- Modal Annual Leave -->
            <div class="modal fade effect-scale" id="al" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="alLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-muted">Annual Leave</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Year <span class=" text-danger">*</span></label> 
                                        <Multiselect class="multi-color" v-model="alForm.years" placeholder="Select" :options="lkYear"/>
                                    </div>
                                </div>
                                <div class="col-md-6 col-6">
                                    <div class="form-group">
                                        <label class="mb-0">Remain <span class=" text-danger">*</span></label>
                                        <input type="number" class="form-control" placeholder="Card id..." v-model="alForm.remain">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="mb-0">Remarks</label>
                                        <input type="text" class="form-control laofont" placeholder="Remarks..." v-model="alForm.remarks">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button v-if="btnAlUpd" type="button" class="btn btn-info btn-b" :class="btnAlAddShow" @click="alUpdate()"><i class="fe fe-check-circle"></i> 
                                <span class="mx-1">Update</span>
                            </button>
                            <button v-if="btnAlAdd" type="button" class="btn btn-primary" :class="btnAlAddShow" @click="alAdd()"><i class="fe fe-plus"></i> 
                                <span class="mx-1">Add</span>
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
    name: 'XpplAppEmployee',

    data() {
        return {
            lkCountry: [],
            lkPosition: [],
            lkStatus: [],
            lkContract: [],
            lkLevels: [],
            lkRoster: [],
            lkScantimes: [],
            lkSite: [],
            lkDept: [],
            lkSection: [],
            lkCrew: [],
            lkRelate: [],
            lkBank: [],
            lkCard: [],
            lkYear: [],

            detailData: [],
            empData: [],
            contData: [],
            bankData: [],
            cardData: [],
            alData: [],
            fileData: [],
            loginPermiss: [],

            showList: true,
            showAdd: '',
            showDetail: '',
            showTab: '',
            search: '',
            btnClear: false,
            btnEmpUpd: '',
            btnEmpAdd: '',
            btnDetailUpd: '',
            btnDetailAdd: '',
            btnContUpd: '',
            btnContAdd: '',
            btnBankUpd: '',
            btnBankAdd: '',
            btnCardUpd: '',
            btnCardAdd: '',
            btnAlUpd: '',
            btnAlAdd: '',
            actTab: '',


            photoPrev: window.location.origin + '/assets/img/no.jpg',
            empForm: { id: '', userid: '', gender: 'Male', name: '', surname: '', namelao: '', surnamelao: '', phone: '', birthday: '', email: '', country: '', province: '', district: '', village: '', startdate: '', enddate: '', position: '', status: 'Current', contract: '', levels: '', empid: '', scanid: '', foodid: '', roster: '', scantimes: '', hours: '9', site: '', dept: '', section: '', crew: '', photo: '', remarks: ''},
            contForm: { id: '', userid: '', name: '', relate: '', phone: '', address: '' },
            bankForm: { id: '', userid: '', bankname: '', branch: '', acctname: '', acctno: '', remarks: '' },
            cardForm: { id: '', userid: '', cardtype: '', cardid: '', expire: '', remarks: '' },
            alForm: { id: '', userid: '', years: '', remain: '', remarks: '' }
            

        };
    },

    mounted() {
        
    },

    computed:{
        btnEmpAddShow(){
            if(this.empForm.name == '' || this.empForm.namelao == '' || this.empForm.country == null || this.empForm.startdate == '' || this.empForm.scanid == '' || this.empForm.roster == null || this.empForm.scantimes == null || this.empForm.hours == '' || this.empForm.site == null || this.empForm.dept == null ){
                return 'disabled'
            } else {
                return ''
            }
        },
        
        btnEmpUpdShow(){
            if (this.empForm.name == '' || this.empForm.namelao == '' || this.empForm.country == null){
                return 'disabled'
            } else {
                return ''
            }
        },

        btnDetailShow(){
            if (this.empForm.site == null || this.empForm.startdate == '' || this.empForm.status == null || this.empForm.scanid == '' || this.empForm.roster == null || this.empForm.scantimes == null || this.empForm.hours == '' || this.empForm.dept == null){
                return 'disabled'
            } else {
                return ''
            }
        },

        btnContAddShow(){
            if (this.contForm.name == '' || this.contForm.relate == null || this.contForm.phone == ''){
                return 'disabled'
            } else {
                return ''
            }
        },

        btnBankAddShow(){
            if (this.bankForm.bankname == null || this.bankForm.acctname == '' || this.bankForm.acctno == ''){
                return 'disabled'
            } else {
                return ''
            }
        },

        btnCardAddShow(){
            if (this.cardForm.cardtype == null || this.cardForm.cardid == ''){
                return 'disabled'
            } else {
                return ''
            }
        },

        btnAlAddShow(){
            if (this.alForm.years == null || this.alForm.remain == ''){
                return 'disabled'
            } else {
                return ''
            }
        }
    },

    methods: {    
        async getEmpData(page){
			const response = await axios.get(`/api/employee?page=${page}&search=${this.search}`)
            this.empData = response.data;

            if (response.data[0].photo){
                this.photoPrev = window.location.origin + '/assets/img/profile/' + response.data[0].photo
            } else {
                this.photoPrev = window.location.origin + '/assets/img/no.jpg'
            }
        },

        empNew(){
            if(this.loginPermiss.emp_add == 0){
                this.$swal.fire({
                    text: "You don't have permission to add employee!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1500
                })
            } else {
                this.showList = false;
                this.showAdd = true;
                this.showDetail = true;
                this.showTab = false;
                this.btnEmpUpd = false;
                this.btnEmpAdd = true;
                this.empFormClear();
                this.detailFormClear();
            }
        },

        empPrev(id){
            $('#empPreview').modal('show');

            this.$axios.get('/sanctum/csrf-cookie').then((response)=>{
                this.$axios.post(`/api/employee/preview/${id}`)
                .then((response)=>{
                    this.prevData = response.data;
                }).catch((error)=>{
                    console.log(error);
                })
            });
        },

       async empEdit(id){
            if(this.loginPermiss.emp_edit == 0){
                this.$swal.fire({
                    text: "You don't have permission to edit employee!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1500
                })
            } else {

                this.empFormClear();
                const response = await axios.post(`/api/employee/edit/${id}`)
                    this.userid = response.data.id;

                    this.empForm.userid = response.data.id;
                    this.contForm.userid = response.data.id;
                    this.bankForm.userid = response.data.id;
                    this.cardForm.userid = response.data.id;
                    this.alForm.userid = response.data.id;

                    this.empForm.gender = response.data.gender;
                    this.empForm.name = response.data.name;
                    this.empForm.surname = response.data.surname;
                    this.empForm.phone = response.data.phone;
                    this.empForm.namelao = response.data.namelao;
                    this.empForm.surnamelao = response.data.surnamelao;
                    this.empForm.birthday = response.data.birthday;
                    this.empForm.email = response.data.email;
                    this.empForm.country = response.data.country;
                    this.empForm.province = response.data.province;
                    this.empForm.district = response.data.district;
                    this.empForm.village = response.data.village;

                    if (response.data.photo){
                        this.photoPrev = window.location.origin + '/assets/img/profile/' + response.data.photo
                    } else {
                        this.photoPrev = window.location.origin + '/assets/img/no.jpg'
                    }

                    this.getDetail(id);
                    this.getContact(id);
                    this.getBank(id);
                    this.getCard(id);
                    this.getAl(id);
                    this.getFiles(id);

                    this.actTab = '';
                    this.showList = false;
                    this.showAdd = true;
                    this.showDetail = false;
                    this.showTab = true;
                    this.btnEmpAdd = false;
                    this.btnEmpUpd = true;

            }
        },

        empCancel(){ 
            this.showList = true;
            this.showAdd = false;
        },

        empAdd(){
            let fd = new FormData();
                fd.append('gender', this.empForm.gender);
                fd.append('name', this.empForm.name);
                fd.append('surname', this.empForm.surname);
                fd.append('namelao', this.empForm.namelao);
                fd.append('surnamelao', this.empForm.surnamelao);
                fd.append('phone', this.empForm.phone);
                fd.append('birthday', this.empForm.birthday);
                fd.append('email', this.empForm.email);
                fd.append('country', this.empForm.country);
                fd.append('province', this.empForm.province);
                fd.append('district', this.empForm.district);
                fd.append('village', this.empForm.village);
                fd.append('startdate', this.empForm.startdate);
                fd.append('enddate', this.empForm.enddate);
                fd.append('position', this.empForm.position);
                fd.append('status', this.empForm.status);
                fd.append('contact', this.empForm.contract);
                fd.append('levels', this.empForm.levels);
                fd.append('empid', this.empForm.empid);
                fd.append('scanid', this.empForm.scanid);
                fd.append('foodid', this.empForm.foodid);
                fd.append('roster', this.empForm.roster);
                fd.append('scantimes', this.empForm.scantimes);
                fd.append('hours', this.empForm.hours);
                fd.append('site', this.empForm.site);
                fd.append('dept', this.empForm.dept);
                fd.append('section', this.empForm.section);
                fd.append('crew', this.empForm.crew);
                fd.append('photo', this.empForm.photo);

            this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                this.$axios.post('/api/employee/add', fd, {headers:{"Content-Type": "multipart/form-date"}})
                .then((response)=>{
                    if(response.data.success){

                        this.getEmpData();
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
                        fd.append('id', this.userid);
                        fd.append('gender', this.empForm.gender);
                        fd.append('name', this.empForm.name);
                        fd.append('surname', this.empForm.surname);
                        fd.append('namelao', this.empForm.namelao);
                        fd.append('surnamelao', this.empForm.surnamelao);
                        fd.append('phone', this.empForm.phone);
                        fd.append('birthday', this.empForm.birthday);
                        fd.append('email', this.empForm.email);
                        fd.append('country', this.empForm.country);
                        fd.append('province', this.empForm.province);
                        fd.append('district', this.empForm.district);
                        fd.append('village', this.empForm.village);
                        fd.append('photo', this.empForm.photo);
                    
                    this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
                        this.$axios.post('/api/employee/update', fd, {headers:{"Content-Type": "multipart/form-date"}})
                        .then((response)=>{

                            this.getEmpData();
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
            if (this.loginPermiss.emp_del == 0){
                this.$swal.fire({
                    text: "You don't have permission to delete employee!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1500
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
                                this.getEmpData();

                                this.$swal.fire({
                                    title: 'Deleted!',
                                    text: 'The employee has been deleted.',
                                    icon: 'success',
                                    showCancelButton: false,
                                    showConfirmButton: false,
                                    allowOutsideClick: false,
                                    timerProgressBar: true,
                                    timer: 1500
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
            const response = await axios.post(`/api/detail/data/${id}`)
            this.detailData = response.data;
        },

        detailNew(){
            $('#detailAddEdit').modal('show');
            this.detailFormClear();
            this.btnDetailUpd = false;
            this.btnDetailAdd = true;

        },

        detailAdd(){
            this.$axios.post('/api/detail/add', this.empForm)
            .then((response)=>{
                if(response.data.success){

                    $('#detailAddEdit').modal('hide');
                    this.getDetail(this.empForm.userid);

                } else {
                    alert(response.data.message)
                }
            }).catch((error)=>{
                console.log(error);
            })
        },

        detailEdit(id){
            $('#detailAddEdit').modal('show');
            this.$axios.post(`/api/detail/edit/${id}`)
            .then((response)=>{

                this.detailFormClear();
                this.btnDetailAdd = false;
                this.btnDetailUpd = true;

                this.empForm.id = response.data.id;
                this.empForm.site = response.data.site;
                this.empForm.startdate = response.data.startdate;
                this.empForm.enddate = response.data.enddate;
                this.empForm.status = response.data.status;
                this.empForm.position = response.data.position;
                this.empForm.dept = response.data.department;
                this.empForm.section = response.data.section;
                this.empForm.crew = response.data.crew;
                this.empForm.empid = response.data.empid;
                this.empForm.scanid = response.data.scanid;
                this.empForm.foodid = response.data.foodid;
                this.empForm.roster = response.data.roster;
                this.empForm.scantimes = response.data.scantimes;
                this.empForm.hours = response.data.working_hrs;
                this.empForm.levels = response.data.levels;
                this.empForm.contract = response.data.contract;
                this.empForm.remarks = response.data.remarks;

            }).catch((error)=>{
                console.log(error);
            })
        },

        detailUpdate(){
            this.$axios.post('/api/detail/update', this.empForm)
            .then((response)=>{

                $('#detailAddEdit').modal('hide');
                this.getDetail(this.empForm.userid);

            }).catch((error)=>{
                console.log(error);
            })
        },

        detailDel(id){
            if (this.loginPermiss.detail_del == 0){
                this.$swal.fire({
                    text: "You don't have permission to delete!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1500
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
                            this.$axios.post(`/api/detail/delete/${id}`)
                            .then((response)=>{

                                this.getDetail(this.userid);

                            }).catch((error)=>{
                                console.log(error);
                            })
                        })
                    }
                });
            }

        },

        async getContact(id){
            const response = await axios.post(`/api/contact/data/${id}`)
            this.contData = response.data;
        },

        contactNew(){
            $('#contact').modal('show');
            this.contFormClear();
            this.getRelateLK();
            this.btnContUpd = false;
            this.btnContAdd = true;
        },

        contactAdd(){
            this.$axios.post('/api/contact/add', this.contForm)
            .then((res) => {
                 if(res.data.success){

                    $('#contact').modal('hide');
                    this.getContact(this.contForm.userid);

                } else {
                    alert(res.data.message)
                }
            }).catch ((err) =>{
                console.log(err);
            })
        },

        contactEdit(id){
            $('#contact').modal('show');
            this.$axios.post(`/api/contact/edit/${id}`)
            .then((res)=>{

                this.contFormClear();
                this.getRelateLK();
                this.btnContAdd = false;
                this.btnContUpd = true;

                this.contForm.id = res.data.id;
                this.contForm.name = res.data.name;
                this.contForm.relate = res.data.relate;
                this.contForm.phone = res.data.phone;
                this.contForm.address = res.data.address;

            }).catch((error)=>{
                console.log(error);
            })
        },

        contactUpdate(){
            this.$axios.post('/api/contact/update', this.contForm)
            .then((response)=>{

                $('#contact').modal('hide');
                this.getContact(this.contForm.userid);

            }).catch((error)=>{
                console.log(error);
            })
        },

        contactDel(id){
            if (this.loginPermiss.cont_del == 0){
                this.$swal.fire({
                    text: "You don't have permission to delete!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1500
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
                        this.$axios.post(`/api/contact/delete/${id}`)
                        .then((response)=>{

                            this.getContact(this.userid);

                        }).catch((error)=>{
                            console.log(error);
                        })
                    }
                });
            }
        },

        async getBank(id){
            const response = await axios.post(`/api/bank/data/${id}`)
            this.bankData = response.data;
        },

        bankNew(){
            $('#bank').modal('show');
            this.bankFormClear();
            this.getBankLK();
            this.btnBankUpd = false;
            this.btnBankAdd = true;
        },

        bankAdd(){
            this.$axios.post('/api/bank/add', this.bankForm)
            .then((res) => {
                 if(res.data.success){

                    $('#bank').modal('hide');
                    this.getBank(this.userid);

                } else {
                    alert(res.data.message)
                }
            }).catch ((err) => {
                console.log(err);
            })
        },

        bankEdit(id){
            $('#bank').modal('show');
            this.$axios.post(`/api/bank/edit/${id}`)
            .then((res)=>{

                this.bankFormClear();
                this.getBankLK();
                this.btnBankAdd = false;
                this.btnBankUpd = true;

                this.bankForm.id = res.data.id;
                this.bankForm.bankname = res.data.bank_name;
                this.bankForm.branch = res.data.branch;
                this.bankForm.acctname = res.data.acct_name;
                this.bankForm.acctno = res.data.acct_no;
                this.bankForm.remarks = res.data.remarks;

            }).catch((error)=>{
                console.log(error);
            })
        },

        bankUpdate(){
            this.$axios.post('/api/bank/update', this.bankForm)
            .then((response)=>{

                $('#bank').modal('hide');
                this.getBank(this.userid);

            }).catch((error)=>{
                console.log(error);
            })
        },

        bankDel(id){
            if (this.loginPermiss.bank_del == 0){
                this.$swal.fire({
                    text: "You don't have permission to delete!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1500
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
                        this.$axios.post(`/api/bank/delete/${id}`)
                        .then((response)=>{

                            this.getBank(this.userid);

                        }).catch((error)=>{
                            console.log(error);
                        })
                    }
                });
            }
        },

        async getCard(id){
            const response = await axios.post(`/api/card/data/${id}`)
            this.cardData = response.data;
        },

        cardNew(){
            $('#cards').modal('show');
            this.cardFormClear();
            this.getCardLK();
            this.btnCardUpd = false;
            this.btnCardAdd = true;
        },
        
        cardAdd(){
            this.$axios.post('/api/card/add', this.cardForm)
            .then((res) => {
                 if(res.data.success){
                    $('#cards').modal('hide');
                    this.getCard(this.cardForm.userid);
                } else {
                    alert(res.data.message)
                }
            }).catch ((err) =>{
                console.log(err);
            })
        },

        cardEdit(id){
            $('#cards').modal('show');
            this.$axios.post(`/api/card/edit/${id}`)
            .then((res)=>{

                this.cardFormClear();
                this.getCardLK();
                this.btnCardAdd = false;
                this.btnCardUpd = true;

                this.cardForm.id = res.data.id;
                this.cardForm.cardtype = res.data.cardtype;
                this.cardForm.cardid = res.data.cardid;
                this.cardForm.expire = res.data.expiredate;
                this.cardForm.remarks = res.data.remarks;

            }).catch((error)=>{
                console.log(error);
            })
        },

        cardUpdate(){
            this.$axios.post('/api/card/update', this.cardForm)
            .then((response)=>{
                $('#cards').modal('hide');
                this.getCard(this.cardForm.userid);
            }).catch((error)=>{
                console.log(error);
            })
        },

        cardDel(id){
            if (this.loginPermiss.card_del == 0){
                this.$swal.fire({
                    text: "You don't have permission to delete!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1500
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
                        this.$axios.post(`/api/card/delete/${id}`)
                        .then((response)=>{

                            this.getCard(this.cardForm.userid);

                        }).catch((error)=>{
                            console.log(error);
                        })
                    }
                });
            }
        },

        async getAl(id){
            const response = await axios.post(`/api/annual/data/${id}`)
            this.alData = response.data;
        },

        alNew(){
            $('#al').modal('show');
            this.alFormClear();
            this.getYearLK();
            this.btnAlUpd = false;
            this.btnAlAdd = true;
        },
        
        alAdd(){
            this.$axios.post('/api/annual/add', this.alForm)
            .then((res) => {
                if(res.data.success){

                    $('#al').modal('hide');
                    this.getAl(this.alForm.userid);

                } else {
                    alert(res.data.message)
                }
            }).catch ((err) =>{
                console.log(err);
            })
        },

        alEdit(id){
            $('#al').modal('show');
            this.$axios.post(`/api/annual/edit/${id}`)
            .then((res)=>{

                this.alFormClear();
                this.getYearLK();
                this.btnAlAdd = false;
                this.btnAlUpd = true;

                this.alForm.id = res.data.id;
                this.alForm.years = res.data.years;
                this.alForm.remain = res.data.remain;
                this.alForm.remarks = res.data.remarks;

            }).catch((error)=>{
                console.log(error);
            })
        },

        alUpdate(){
            this.$axios.post('/api/annual/update', this.alForm)
            .then((response)=>{

                $('#al').modal('hide');
                this.getAl(this.alForm.userid);

            }).catch((error)=>{
                console.log(error);
            })
        },

        alDel(id){
            if (this.loginPermiss.al_del == 0){
                this.$swal.fire({
                    text: "You don't have permission to delete!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1500
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
                        this.$axios.post(`/api/annual/delete/${id}`)
                        .then((response)=>{

                            this.getAl(this.alForm.userid);

                        }).catch((error)=>{
                            console.log(error);
                        })
                    }
                });
            }
        },

        async getFiles(id){
            const response = await axios.post(`/api/file/data/${id}`)
            this.fileData = response.data;
        },


        fileNew(){
            this.$refs.fileInput2.click();
        },

        fileAdd(){
            let fd = new FormData();
            for (let i = 0; i < this.$refs.fileInput2.files.length; i++){
                
                let file = this.$refs.fileInput2.files[i];
                    fd.append('files[' + i + ']', file);
                    fd.append('userid', this.empForm.userid);
            }
            this.$swal.fire({
                text: "Do you want to add selected file?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fe fe-plus"></i> <span class="font-weight-light">Add</span>',
                cancelButtonText: '<i class="fe fe-x"></i> <span class="font-weight-light">Cancel</span>',
                allowEnterKey: false,
                allowOutsideClick: false,
            }).then((result)=>{
                if(result.isConfirmed){
                    this.$axios.post('/api/file/add', fd, {headers:{"Content-Type": "multipart/form-date"}})
                    .then(response => {   

                            this.getFiles(this.empForm.userid);

                    }).catch (err => {
                        console.log(err);
                    });
                }
            });
        },
        
        fileDownload(file){
            const url = `/api/file/download/${file}`;
            window.location.href = url;
        },

        fileDel(file){
            if (this.loginPermiss.file_del == 0){
                this.$swal.fire({
                    text: "You don't have permission to delete!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1500
                })
            } else {
                this.$swal.fire({
                    text: "Do you want to delete this file?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="font-weight-light">Delete</span>',
                    cancelButtonText: '<i class="fe fe-x"></i> <span class="font-weight-light">Cancel</span>',
                    confirmButtonColor: '#d33',
                    allowEnterKey: false,
                    allowOutsideClick: false,
                }).then((result)=>{
                    if(result.isConfirmed){
                        this.$axios.post(`api/file/delete/${file}`)
                        .then((response)=>{

                            this.getFiles(this.empForm.userid);

                        }).catch((error)=>{
                            console.log(error);
                        })
                    }
                });
            }
        },

        async searchChange(){
            if(this.search.length >0){
                this.btnClear = true;
                const data = await this.getEmpData();
            } else {
                this.btnClear = false;
                const data = await this.getEmpData();
            }
        },

        searchClear(){
            this.search = '';
            this.btnClear = false,
            this.getEmpData();
        },

        chooseImage(){
            this.$refs.fileInput.click()
        },

        onSeclected(event){
            this.empForm.photo = event.target.files[0];
            let reader = new FileReader();
            reader.readAsDataURL(this.empForm.photo);
            reader.addEventListener("load", function(){
                this.photoPrev = reader.result;
            }.bind(this), false);
		},

        empFormClear(){
            let f = this.empForm;
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

        detailFormClear(){
            let f = this.empForm;
                f.startdate = '';
                f.enddate = '';
                f.position = '';
                f.contact = '';
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

        contFormClear(){
            let f = this.contForm;
                f.name = '';
                f.relate = '';
                f.phone = '';
                f.address = '';
        },

        bankFormClear(){
            let f = this.bankForm;
                f.bankname = '';
                f.branch = '';
                f.acctname = '';
                f.acctno = '';
                f.remarks = '';
        },

        cardFormClear(){
            let f = this.cardForm;
                f.cardtype = '';
                f.cardid = '';
                f.expire = '';
                f.remarks = '';
        },

        alFormClear(){
            let f = this.alForm;
                f.year = '';
                f.remain = '';
                f.remarks = '';
        },

        async getLookup(){
            const country = await axios.get('/api/lookup/country')
            this.lkCountry = country.data;

            const position = await axios.get('/api/lookup/position')
            this.lkPosition = position.data;

            const status = await axios.get('/api/lookup/status')
            this.lkStatus = status.data;

            const contract = await axios.get('/api/lookup/contract')
            this.lkContract = contract.data;
            
            const levels = await axios.get('/api/lookup/levels')
            this.lkLevels = levels.data;
            
            const roster = await axios.get('/api/lookup/roster')
            this.lkRoster = roster.data;
            
            const scantimes = await axios.get('/api/lookup/scantimes')
            this.lkScantimes = scantimes.data;
            
            const site = await axios.get('/api/lookup/site')
            this.lkSite = site.data;
            
            const dept = await axios.get('/api/lookup/dept')
            this.lkDept = dept.data;
            
            const section = await axios.get('/api/lookup/section')
            this.lkSection = section.data;
            
            const crew = await axios.get('/api/lookup/crew')
            this.lkCrew = crew.data;
        },

        getRelateLK(){
            this.$axios.get('/api/lookup/relate').then((res) => {
                this.lkRelate = res.data;
            })
        },

        getBankLK(){
            this.$axios.get('/api/lookup/bank').then((res) => {
                this.lkBank = res.data;
            })
        },

        getCardLK(){
            this.$axios.get('/api/lookup/card').then((res) => {
                this.lkCard = res.data;
            })
        },

        getYearLK(){
            this.$axios.get('/api/lookup/year').then((res) => {
                this.lkYear = res.data;
            })
        },

        async getPermiss(){
            const response = await axios.get('/api/permiss')
            this.loginPermiss = response.data;
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
        this.getPermiss();
        this.getEmpData();
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

    .multi-color{
        color: #4D5875;
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
        background: #f2f4f8; 
    }

	/* Button icon */
	.btn-i:hover{
		background: #E9EBEC;
        color: blue;
	}
	.btn-i{
		border-radius: 50px;
	}

    .dropdown-hover:hover{
        color: blue;
        font-weight: 500;
    }

    .btn-add:hover{
        background: #DDE1E5;
        border-radius: 50px;
    }

    .ff{
        border-color: blue;

    }

</style>