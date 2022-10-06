<template>
    <div v-if="loading">
        <loading/>
    </div> 
    <div v-else>
        <div class="card">
            <div class="card-body pd-t-10">
                <!-- <div class="d-flex justify-content-between">
                    <h4 class="card-title mg-b-0 text-muted text-capitalize">Roster From <span class="text-danger">{{date1(datefr)}}</span> To <span class="text-danger">{{date1(dateto)}}</span></h4>
                    <div class="d-flex justify-content-start">
                        <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" data-bs-toggle="dropdown" title="Tools">
                            <i class="mdi mdi-dots-horizontal text-gray" style="font-size: 15px"></i>
                        </button> 
                        <div class="dropdown-menu tx-13">
                            <div class="dropdown-item cur-pointer dropdown-hover" @click="addDelete()">
                                <i class="fas fa-exchange-alt me-2"></i><span>Add/Delete</span>
                            </div>
                            <div class="dropdown-item cur-pointer dropdown-hover" @click="getRosCode()">
                                <i class="fa fa-server me-2"></i><span>Lookup Code</span>
                            </div>
                            <div class="dropdown-item cur-pointer dropdown-hover">
                                <i class="far fa-file-excel me-2"></i><span>Export To Excel</span>
                            </div>
                        </div>
                    </div>
                </div> -->
                <h4 class="card-title mg-b-0 text-muted text-capitalize">{{dept}} Roster From <span class="text-danger">{{date1(datefr)}}</span> To <span class="text-danger">{{date1(dateto)}}</span></h4>



                <div class="d-xl-flex justify-content-between mt-0 mb-1">
                    <div class="wd-lg-300 wd-100p">
                        <div class="pos-relative">
                            <input class="form-control form-control-sm pd-l-25 box-height" type="text" placeholder="Search by name..." v-model="search" @input="searchChange()" @keyup.enter="getRoster()" title="Search by name, crew and position">
                                <i class="fe fe-search search-ism text-muted"></i>
                            <button class="btn btn-icon btn-sm search-csm text-muted" v-if="btnClear" @click="searchClear()"><i class="fe fe-x" style="font-size: 14px"></i></button>
                        </div>
                    </div>
                    <div class="d-md-flex justify-content-end mt-xl-0 mt-lg-1 mt-md-1 mt-1">
                        <div class="wd-lg-200 wd-md-200 wd-100p me-1 my-md-0 my-1" v-if="permiss.ros_all == 1" >
                            <Multiselect class="multi-color box-height" v-model="dept" placeholder="Departments..." :searchable="false" :searchStart="true" :options="lkDept" @select="getRoster()"/>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="wd-md-150 wd-100p">
                                <input type="date" class="form-control form-control-sm box-height" placeholder="Date..." v-model="datefr" @change="getRoster()">
                            </div>
                            <div class="wd-md-150 wd-100p ms-1">
                                <input type="date" class="form-control form-control-sm box-height" placeholder="Date..." v-model="dateto" @change="getRoster()">
                            </div>
                            <!-- <div class="btn-tools ms-1">
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-tools p-0 border" data-bs-toggle="dropdown" title="More tools">
                                    <i class="mdi mdi-dots-horizontal tx-16"></i>
                                </button>
                                <div class="dropdown-menu tx-13">
                                    <div class="dropdown-item cur-pointer dropdown-hover" @click="addDelete()">
                                        <i class="fas fa-exchange-alt me-2"></i><span>Add/Delete</span>
                                    </div>
                                    <div class="dropdown-item cur-pointer dropdown-hover" @click="getRosCode()">
                                        <i class="fa fa-server me-2"></i><span>Lookup Code</span>
                                    </div>
                                    <div class="dropdown-item cur-pointer dropdown-hover">
                                        <i class="far fa-file-excel me-2"></i><span>Export To Excel</span>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>

                <div class="table-responsive border" style="max-height: 75vh">
                    <table class="table main-table-reference text-nowrap mg-b-0">
                        <thead class="position-sticky" style="top: 0px; z-index: 1">
                            <tr>
                                <th class="border-start-0 px-1">No</th>
                                <th class="px-1">Crew</th>
                                <th class="px-1 position-sticky" style="left: -1px">Name and Surname</th>
                                <th class="px-1">Position</th>
                                <th class="px-1">Type</th>
                                <th v-for="(col, colInx) in colData" :key="colInx" class="text-center" style="padding: 7px 5px" :title="col.mont" 
                                    :style="headDate(col.colid) == cdate ? 'background-color: yellow; color: blue; font-weight: bold' : ''"
                                >
                                    {{ col.colname }} 
                                </th>
                            </tr>
                        </thead>
                        <tbody class="tx-13">
                            <tr v-for="(row, rowInx) in rosData" :key="rowInx" @click="selectRow(rowInx, row.name, row.rtype)" :style="rowInx === rowSel && row.rtype == 'P' ? 'color: red; font-weight: 500' : rowInx === rowSel && row.rtype == 'A' ? 'color: blue; font-weight: 500' : ''">
                                <td class="px-1 text-center border-start-0">{{rowInx + 1}}</td>
                                <td class="px-1">{{row.crew}}</td>
                                <td class="px-1 position-sticky cur-pointer" style="left: -1px; background-color: #FFFFFF" title="Double click to see details" @dblclick="rosDetail(row.userid)">{{row.fullname}}</td>
                                <td class="px-1">{{row.position}}</td>
                                <td class="px-1 text-center">{{row.rtype}}</td>
                                <td v-for="(col, colInx) in colData" :key="colInx" class="px-1 text-center cur-pointer" :title="mentDate(col.colid) +'  '+ row[col.colid]" 
                                    
                                    @dblclick="editRos(row.userid, col.colid, row.rtype, code(row[col.colid]), row.name, comments(row[col.colid]))"
                                    @click="countDay(rowInx, headDate1(col.colid))"

                                    :style="code(row[col.colid]) == 'W' || code(row[col.colid]) == 'WN' ? 'background-color: #F2F4F8':
                                            code(row[col.colid]) == 'W/2' ? 'background-color: #FFC000':
                                            code(row[col.colid]) == 'R' || code(row[col.colid]) == 'RW' || code(row[col.colid]) == 'OR' || code(row[col.colid]) == 'IR' ? 'background-color: #FFFFCC':
                                            code(row[col.colid]) == 'A' || code(row[col.colid]) == 'A/2' || code(row[col.colid]) == 'IA' || code(row[col.colid]) == 'OA' || code(row[col.colid]) == 'AA' || code(row[col.colid])== 'H' || code(row[col.colid]) == 'OH' || code(row[col.colid]) == 'IH' || code(row[col.colid]) == 'P' ? 'background-color: #FFFF99':
                                            code(row[col.colid]) == 'S' || code(row[col.colid]) == 'SS' || code(row[col.colid]) == 'IS' || code(row[col.colid]) == 'OS' ? 'background-color: #F2DCDB':
                                            code(row[col.colid]) == 'MR' ? 'background-color: #FF66FF':
                                            code(row[col.colid]) == 'BWB' || code(row[col.colid]) == 'WO' || code(row[col.colid]) == 'IW' || code(row[col.colid]) == 'OW' ? 'background-color: #C6E0B4':
                                            code(row[col.colid]) == 'T' || code(row[col.colid]) == 'T-' || code(row[col.colid]) == 'IT' || code(row[col.colid]) == 'OT' || code(row[col.colid]) == 'TT' ? 'background-color: #FF0000':''" 
                                >
                                    {{ code(row[col.colid]) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="text" class="mt-2 tx-13 text-end me-1">
                    {{text}}<span class="fw-bold text-primary">{{count}}</span> days
                </div>
            </div>
        </div>

        <!-- Modal Update Rotser -->
        <div class="modal fade effect-scale" id="roster" data-bs-backdrop="static" back data-bs-keyboard="false" tabindex="-1" aria-labelledby="workOrderLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header pb-1 bd-b-0">
                        <h6 class="main-content-label text-capitalize">{{name}} (<span class="text-danger">{{rosForm.rtype}}</span>)</h6>
                        <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body pt-2">  
                        <div class=" d-flex justify-content-start mb-2">
                            <label class="rdiobox cur-pointer"><input name="upd" type="radio" value="date" checked v-model="updMethod"><span>Date</span></label>
                            <label class="rdiobox cur-pointer ms-5"><input name="upd" type="radio" value="range" v-model="updMethod"><span>Date Range</span></label>  
                        </div>
                        <div v-if="updMethod == 'date'"> 
                             <div class="row">
                                <div class="col-6 pe-1">
                                    <div class="form-group">
                                        <label class="mb-0">Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control px-2" placeholder="Phone numbers..." v-model="rosForm.rdatefr">
                                    </div>
                                </div>
                                <div class="col-6 ps-1">
                                   <div class="form-group">
                                        <label class="mb-0">Code <span class="text-danger">*</span></label> 
                                        <Multiselect class="multi-color ht-40" v-model="rosForm.rcode" placeholder="Select" searchable="true" searchStart="true" :options="lkCode"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">Comments</label>
                                <textarea class="form-control laofont" placeholder="Comments..." style="height: 100px" v-model="rosForm.comment"></textarea>
                            </div>   
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" :class="rosDateDis" @click="updRosDate()"><i class="fe fe-save"></i><span class="mx-1">Save</span></button> 
                                <button type="button" class="btn btn-secondary ms-1" :class="rosDateDis" @click="updRosDateRefresh()"><i class="fe fe-save"></i><span class="mx-1">Save and Refresh</span></button> 
                            </div>
                        </div>
                        <div v-else>
                            <div class="row">
                                <div class="col-6 pe-1">
                                    <div class="form-group">
                                        <label class="mb-0">From <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control px-2" placeholder="Phone numbers..." v-model="rosForm.rdatefr">
                                    </div>
                                </div>
                                <div class="col-6 ps-1">
                                    <div class="form-group">
                                        <label class="mb-0">To <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control px-2" placeholder="Phone numbers..." v-model="rosForm.rdateto">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">Code <span class="text-danger">*</span></label> 
                                <Multiselect class="multi-color ht-40" v-model="rosForm.rcode" placeholder="Select" searchable="true" searchStart="true" :options="lkCode"/>
                            </div>
                            <div class="form-group">
                                <label class="mb-0">Comments</label>
                                <textarea class="form-control laofont" placeholder="Comments..." style="height: 100px" v-model="rosForm.comment"></textarea>
                            </div>   
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" :class="rosRangeDis" @click="updRosRange()"><i class="fe fe-save"></i><span class="mx-1">Save</span></button> 
                                <button type="button" class="btn btn-secondary ms-1" :class="rosRangeDis" @click="updRosRangeRefresh()"><i class="fe fe-save"></i><span class="mx-1">Save and Refresh</span></button> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>                                              
        </div>

        <!-- Modal Detail -->
        <div class="modal fade effect-scale" id="detail" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header pb-1 bd-b-0">
                        <h6 class="main-content-label text-capitalize">{{name}}</h6>
                        <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body pt-0">                                   
                        <div class="table-responsive border" style="max-height: 700px">
                            <table class="table main-table-reference text-nowrap mg-b-0">
                                <thead class="position-sticky" style="top: 0px">
                                    <tr>
                                        <th class="border-start-0">Date</th>
                                        <th>Plan</th>
                                        <th>Actual</th>
                                        <th>Ref Code</th>
                                        <th>Time Period</th>
                                        <th>Updated At</th>
                                        <th>Updated By</th>
                                        <th>Actual note </th>
                                        <th class="border-end-0 wd-60p">Plan Note</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    <tr class="tr-hover" v-for="lst in detailData" :key="lst.rdate">
                                        <td class="border-start-0 py-0 text-center border-bottom-0"> {{ date1(lst.rdate) }} </td>
                                        <td :style="lst.pcode == 'W' || lst.pcode == 'WN' ? 'background-color: #F2F4F8':
                                                    lst.pcode == 'W/2' ? 'background-color: #FFC000':
                                                    lst.pcode == 'R' || lst.pcode == 'RW' ? 'background-color: #FFFFCC':
                                                    lst.pcode == 'A' || lst.pcode == 'A/2' || lst.pcode == 'H' || lst.pcode == 'P' ? 'background-color: #FFFF99':
                                                    lst.pcode == 'S' ? 'background-color: #F2DCDB':
                                                    lst.pcode == 'MR' ? 'background-color: #FF66FF':
                                                    lst.pcode == 'T' || lst.pcode == 'T-' ? 'background-color: #FF0000':''" class="py-0 text-center border-bottom-0"> {{ lst.pcode }} 
                                        </td>
                                        <td :style="lst.acode == 'W' || lst.acode == 'WN' ? 'background-color: #F2F4F8':
                                                    lst.acode == 'W/2' ? 'background-color: #FFC000':
                                                    lst.acode == 'R' || lst.acode == 'RW' || lst.acode == 'OR' || lst.acode == 'IR' ? 'background-color: #FFFFCC':
                                                    lst.acode == 'A' || lst.acode == 'A/2' || lst.acode == 'IA' || lst.acode == 'OA' || lst.acode == 'AA' || lst.acode == 'H' || lst.acode == 'OH' || lst.acode == 'IH' || lst.acode == 'P' ? 'background-color: #FFFF99':
                                                    lst.acode == 'S' || lst.acode == 'SS' ? 'background-color: #F2DCDB':
                                                    lst.acode == 'MR' ? 'background-color: #FF66FF':
                                                    lst.acode == 'BWB' || lst.acode == 'WO' ? 'background-color: #C6E0B4':
                                                    lst.acode == 'T' || lst.acode == 'T-' || lst.acode == 'IT' || lst.acode == 'OT' || lst.acode == 'TT' ? 'background-color: #FF0000':''" class="py-0 text-center border-bottom-0"> {{ lst.acode }} 
                                        </td>
                                        <td :style="lst.ref_code == 'W' || lst.ref_code == 'WN' ? 'background-color: #F2F4F8':
                                                    lst.ref_code == 'W/2' ? 'background-color: #FFC000':
                                                    lst.ref_code == 'R' || lst.ref_code == 'RW' ? 'background-color: #FFFFCC':
                                                    lst.ref_code == 'A' || lst.ref_code == 'A/2' || lst.ref_code == 'H' || lst.ref_code == 'P' ? 'background-color: #FFFF99':
                                                    lst.ref_code == 'S' ? 'background-color: #F2DCDB':
                                                    lst.ref_code == 'MR' ? 'background-color: #FF66FF':
                                                    lst.ref_code == 'T' || lst.ref_code == 'T-' ? 'background-color: #FF0000':''" class="py-0 text-center border-bottom-0"> {{ lst.ref_code }} 
                                        </td>
                                        <td class="py-0 text-center border-bottom-0"> {{ lst.working_time }} </td>
                                        <td class="py-0 text-muted border-bottom-0"> {{ date2(lst.updated_at) }} </td>
                                        <td class="py-0 text-muted border-bottom-0 text-capitalize"> {{ lst.updated_by }} </td>
                                        <td class="py-0 laofont border-bottom-0"> {{ lst.anote }} </td>
                                        <td class="py-0 laofont border-bottom-0"> {{ lst.pnote }} </td>
                                    </tr>                                                                                 
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>                                              
        </div>  

        <!-- Modal Add Delete -->
        <div class="modal fade effect-scale" id="addDelete" data-bs-backdrop="static" back data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header pb-1 bd-b-0">
                        <h6 class="main-content-label text-capitalize">{{addMethod}} Roster</h6>
                        <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body pt-2">  
                        <div class=" d-flex justify-content-start mb-2">
                            <label class="rdiobox cur-pointer" @click="addMethodChanged()"><input name="add" type="radio" value="add" checked v-model="addMethod"><span>Add</span></label>
                            <label class="rdiobox cur-pointer ms-5" @click="addMethodChanged()"><input name="add" type="radio" value="delete" v-model="addMethod"><span>Delete</span></label>  
                        </div>
                        <div class="form-group">
                            <label v-if="addMethod == 'add'" class="mb-0">Add Until <span class="text-danger">*</span></label>
                            <label v-else class="mb-0">Delete From <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" placeholder="Phone numbers..." v-model="addDelDate">
                        </div>
                        <div class="form-group">
                            <label class="mb-0">Name <span class="text-danger">*</span></label> 
                            <Multiselect class="multi-color ht-40" v-model="userids" placeholder="Select" mode="multiple" :close-on-select="true" :searchable="true" :searchStart="true" :options="lkEmp"/>
                        </div> 
                        <div class="d-flex justify-content-end">
                            <button v-if="addMethod == 'add'" type="button" class="btn btn-primary" :class="addDelDis" @click="addRos()"><i class="fe fe-plus"></i><span class="mx-1">Add</span></button> 
                            <button v-else type="button" class="btn btn-danger" :class="addDelDis" @click="delRos()"><i class="fe fe-trash-2"></i><span class="mx-1">Delete</span></button> 
                        </div>
                    </div>
                </div>
            </div>                                              
        </div>

        <!-- Modal Lookup Code -->
        <div class="modal fade effect-scale" id="lookupcode" back data-bs-keyboard="false" tabindex="-1" aria-labelledby="addLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                     <div class="modal-header pb-1 bd-b-0">
                        <h6 class="main-content-label text-capitalize">Roster Lookup Code</h6>
                        <button v-if="permiss.lk_ros != 1" aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        <button v-else type="button" class="btn btn-sm btn-rounded btn-primary" style="padding: 3.2px 11.2px" title="Add new record" @click="newCode()"><i class="fe fe-plus"></i> 
                            <span class="mx-1">New</span>
                        </button>
                    </div>
                    <div class="modal-body pt-0">    
                        <div class="table-responsive element ht-md-700">
                            <table class="table main-table-reference text-nowrap mg-b-0">
                                <thead class="position-sticky" style="top: 0px">
                                    <tr>
                                        <th>Actual</th>
                                        <th>Timesheet</th>
                                        <th>Description Lao</th>
                                        <th>Description Eng</th>  
                                        <th v-if="permiss.lk_ros == 1">Period</th>      
                                        <th class="wd-70p" v-else>Period</th>      
                                        <th class="wd-70p" v-if="permiss.lk_ros == 1">Actions</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    <tr v-for="lst in rosCodeData" :key="lst.id">
                                        <td class="text-center">{{ lst.rcode }}</td>
                                        <td class="text-center">{{ lst.ref_code }}</td>
                                        <td class="laofont">{{ lst.descr_lao }}</td>
                                        <td> {{ lst.descr_eng }} </td>
                                        <td> {{ lst.working_time }} </td>
                                        <td v-if="permiss.lk_ros == 1" class="p-0 align-middle">
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
                    </div>
                </div>
            </div>                                              
        </div>

        <!-- Lookup Code Roster Add/Edite -->
        <div class="modal fade effect-scale pd-t-100 bd-0 bg-black-5" id="rosCodeEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="rosCodeLabel" aria-hidden="true">
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
</template>

<script>
export default {
    name: 'XpplAppRoster',

    data() {
        return {
            permiss: [],
            lkDept: [],
            lkCode: [],
            lkEmp: [],
            colData: [],
            rosData: [],
            detailData: [],
            rosCodeData: [],

            dept: '',
            datefr: '',
            dateto: '',
            search: '',
            btnClear: '',

            rosForm: {userid: '', rtype: '', rdatefr: '', rdateto: '', rcode: '', comment: ''},
            rosCodeForm: {id: '', rcode: '', ref_code: '', descr_lao: '', descr_eng: '', working_time: '', used: '1'},
            rowSel: '',
            loading: false,
            cdate: '',
            updMethod: 'date',
            addMethod: 'add',
            userids: [],
            addDelDate: '',
            bntAddShow: '',

            selDate: [],
            count: '',
            text: ''
          
        };
    },

    mounted() {

    },

    computed: {
        rosDateDis(){
            if (this.rosForm.rdatefr == '' || this.rosForm.rcode == null){
                return 'disabled';
            } else {
                return '';
            }
        },

        rosRangeDis(){
            if (this.rosForm.rdatefr == '' || this.rosForm.rdateto == '' || this.rosForm.rcode == null){
                return 'disabled';
            } else {
                return '';
            }
        },

        addDelDis(){
            if (this.addDelDate == '' || this.userids == ''){
                return 'disabled';
            } else {
                return '';
            }
        },
    },

    methods: {
        async onLoad(){
            this.loading = true;
            const resPermiss = await axios.get('/api/permiss')
            this.permiss = resPermiss.data;

            const profile = await axios.get('api/profile')
			this.dept = profile.data.department;

            let today = new Date();
            this.datefr = moment(new Date(today.getFullYear(), today.getMonth() - 1, 15)).format('YYYY-MM-DD');
            this.dateto = moment(new Date(today.getFullYear(), today.getMonth() + 1, 15)).format('YYYY-MM-DD');

            this.cdate = moment(today).format('YYYY-MM-DD');

            const colhead = await axios.get(`/api/roster/datecol?datefr=${this.datefr}&dateto=${this.dateto}`)
            this.colData = colhead.data;

            const roster = await axios.get(`/api/roster/roster?dept=${this.dept}&datefr=${this.datefr}&dateto=${this.dateto}&search=${this.search}`)
            this.rosData = roster.data;

            this.loading = false;

            const dept = await axios.get('/api/lookup/depts')
            this.lkDept = dept.data;

            const rcode = await axios.get('/api/roster/rcode')
            this.lkCode = rcode.data;

        },

        async getRoster(){
            this.loading = true;
            this.rowSel = '';

            if (this.dept != '' && this.datefr != '' && this.dateto != ''){
                const resCol = await axios.get(`/api/roster/datecol?datefr=${this.datefr}&dateto=${this.dateto}`)
                this.colData = resCol.data;

                const resRos = await axios.get(`/api/roster/roster?dept=${this.dept}&datefr=${this.datefr}&dateto=${this.dateto}&search=${this.search}`)
                this.rosData = resRos.data;
            }

            this.loading = false;
        },

        async searchChange(){
            if(this.search.length >0){
                this.btnClear = true;
                // const data = await this.getRoster();
            } else {
                this.btnClear = false;
                // const data = await this.getRoster();
            }
        },

        inputSearch(){
            if(this.search.length >0){
                this.btnClear = true;
            } else {
                this.btnClear = false;
            }
        },

        searchClear(){
            this.search = '';
            this.btnClear = false;
            this.getRoster();
        },

        selectRow(inx, name, type){
             this.rowSel = inx;
             this.name = name;
             this.rosForm.rtype = type;
        },

        editRos(id, date, type, code, name, comm){
            if(this.permiss.ros_edit == 0){
                this.$swal.fire({
                    text: "You don't have permission update!",
                    icon: 'error',
                    showCancelButton: false,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    timerProgressBar: true,
                    timer: 1500
                })
            } else {
                this.rosFormClear();

                this.name = name;
                this.rosForm.userid = id;
                this.rosForm.rdatefr = moment(date.split('c')[1]).format('YYYY-MM-DD');
                this.rosForm.rtype = type;
                this.rosForm.rcode = code;
                this.rosForm.comment = comm;
                $('#roster').modal('show');
            }
        },

        updRosDate(){
            this.$axios.post('/api/roster/updrosdate', this.rosForm)
            .then(res => {
                this.rosForm.rdatefr = '';
                this.rosForm.comment = '';
                // $('#roster').modal('hide');
            }).catch((error)=>{
                console.log(error);
            })
        },

        updRosDateRefresh(){
            $('#roster').modal('hide');
            this.updRosDate();
            this.getRoster();
        },
        
        updRosRange(){
            this.$axios.post('/api/roster/updrosrange', this.rosForm)
            .then(res => {
                $('#roster').modal('hide');
            }).catch((error)=>{
                console.log(error);
            })
        },

        updRosRangeRefresh(){
            $('#roster').modal('hide');
            this.updRosRange();
            this.getRoster();
        },
        
        rosDetail(id){
            this.$axios.post('/api/roster/rosdetail', {
                dept: this.dept,
                datefr: this.datefr,
                dateto: this.dateto,
                userid: id
            }).then(res => {
                this.detailData = res.data;
                $('#detail').modal('show');
            })

        },

        addDelete(){
            this.userids = [];
            this.addDelDate = '';
            this.addMethod = 'add'
            $('#addDelete').modal('show');

            this.$axios.post('/api/roster/emplist', {dept: this.dept})
            .then(res => this.lkEmp = res.data)

        },

        addMethodChanged(){
            this.userids = [];
            this.addDelDate = '';
        },

        addRos(){
            this.$axios.post('/api/roster/addros', {
                list: this.userids,
                date: this.addDelDate
            }).then(res => {
                $('#addDelete').modal('hide');
                this.getRoster();
            })
        },

        delRos(){
            $('#addDelete').modal('hide');
            this.$swal.fire({
                text: "Are you sure?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fe fe-trash-2"></i> <span class="font-weight-light">Delete</span>',
                cancelButtonText: '<i class="fe fe-x"></i> <span class="font-weight-light">Cancel</span>',
                confirmButtonColor: '#d33',
                allowEnterKey: false,
                allowOutsideClick: false,
            }).then((result)=>{
                if(result.isConfirmed){
                    this.$axios.post('/api/roster/delros', {
                        list: this.userids,
                        date: this.addDelDate
                    }).then(res => {
                        $('#addDelete').modal('hide');
                        this.getRoster();
                    })
                } else {
                    $('#addDelete').modal('show');
                }
            });
        },

        getRosCode(){
            $('#lookupcode').modal('show');

            this.$axios.get('/api/roster/rosCode')
            .then(res => this.rosCodeData = res.data)
        },

        newCode(){
            this.rosCodeFormClear();
            this.bntAddShow = true;
            $('#rosCodeEdit').modal('show');
        },

        rosCodeAdd(){
            this.$axios.post('/api/roster/rosCodeAdd', this.rosCodeForm)
            .then((res) => {
                if(res.data.success){
                    $('#rosCodeEdit').modal('hide');
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
            $('#rosCodeEdit').modal('show');

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

                $('#rosCodeEdit').modal('hide');
                this.getRosCode();

            }).catch((error)=>{
                console.log(error);
            })
        },

        rosCodeDel(id){
            $('#lookupcode').modal('hide');
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
                $('#lookupcode').modal('show');
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
        },

        countDay(inx, value){
            this.text = '';
            this.selDate.push({
                inx: inx,
                d: value
            });

            let d1 = this.selDate[0].d;
            let d2 = this.selDate[1].d;

            let inx1 = this.selDate[0].inx;
            let inx2 = this.selDate[1].inx;

            if (inx1 == inx2 && d1 !='' && d2 != '' && d2 > d1){
                let date1 = new Date(d1);
                let date2 = new Date(d2);

                let diff = date2.getTime() - date1.getTime();
                let TotalDays = Math.ceil(diff / (1000 * 3600 * 24)) + 1;

                this.text = 'From: ' + moment(date1).format("DD/MM/YYYY") +' To '+ moment(date2).format("DD/MM/YYYY") +': ';
                this.count = TotalDays;
                this.selDate = [];
            } else {
                this.selDate = [];
            }
        },

        code(text){
            if (text) {
                return text.split("_")[0];
            }
        },

        mentDate(text){
            if (text) {
                return moment(text.split("c")[1]).format("DD/MM/YYYY");
            }
        },

        headDate(text){
            if (text) {
                return moment(text.split("c")[1]).format("YYYY-MM-DD");
            }
        },

        headDate1(text){
            if (text) {
                return moment(text.split("c")[1]).format("MM-DD-YYYY");
            }
        },

        comments(text){
            if (text) {
                return text.split("_")[1];
            }
        },

        rosFormClear(){
            this.updMethod = 'date';
            let f = this.rosForm;
                f.rdateto = '';
                f.comment = '';
        },

        date1(value){
            if (value) {
                return moment(value).format("DD-MM-YYYY");
            }
        },

        date2(value){
            if (value) {
                return moment(value).format("DD-MM-YYYY HH:ss");
            }
        }
        
    },

    created() {
        this.onLoad();
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

</style>