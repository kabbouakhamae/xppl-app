<template>
    <div v-if="loading">
        <loading/>
    </div> 
    <div v-else>
        <div class="breadcrumb-header justify-content-between align-items-center mb-1 mt-0" >
            <div>
                <h4 class="card-title mg-b-0">Finger Scan</h4>
                <p class="tx-12 tx-gray-500 mb-2">Finger scan checking...</p>
            </div>
            <div class="d-flex my-xl-auto justify-content-end">
                <div class="wd-xl-200 wd-lg-200 wd-md-200 wd-80p">
                    <Multiselect class="multi-color" v-model="dept" placeholder="Departments..." :searchable="false" :searchStart="true" :options="lkDept" @select="selDept()"/>
                </div>
                <div class="ms-1" style="width: 120px">
                    <input type="date" class="form-control" placeholder="Date..." v-model="date" @change="selDept()">
                </div>
            </div>
        </div> 

        <div class="card">
            <div class="card-body pd-t-10">
                <div class="breadcrumb-header justify-content-between align-items-center mb-2 mt-0" >
                    <div class="d-flex justify-content-start align-items-center">
                        <h6 class="m-0">{{dept}} on <span class="text-danger fw-bold">{{ mont(date) }}-{{ year(date) }} </span></h6>
                    </div>
                    <div class="d-flex my-xl-auto right-content align-items-center">
                        <div class="pos-relative me-1" style="width: 100%">
                            <input class="form-control form-control-sm ht-30 pd-l-25" type="text" placeholder="search by name..." v-model="search" @input="inputSearch()" @keyup.enter="searchChange()" title="Input the name then press Enter">
                                <i class="fe fe-search search-ism text-muted cur-pointer" @click="searchChange()" title="Click to search"></i>
                            <button class="btn btn-icon btn-sm search-csm text-muted" v-if="btnClear" @click="searchClear()"><i class="fe fe-x" style="font-size: 14px"></i></button>
                        </div>
                        <div class="d-flex justify-content-start">
                            <div class="wd-30">
                                <button type="button" class="btn btn-sm btn-outline-secondary ht-30 wd-30 p-0 border" data-bs-toggle="dropdown" title="More tools">
                                    <i class="mdi mdi-dots-horizontal tx-16"></i>
                                </button>
                                <div class="dropdown-menu tx-13">
                                    <div class="dropdown-item cur-pointer dropdown-hover">
                                        <i class="far fa-file-excel me-2"></i><span>Import AC Log</span>
                                    </div>
                                    <div class="dropdown-item cur-pointer dropdown-hover">
                                        <i class="far fa-file-excel me-2"></i><span>Export To Excel</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        

                <div class="table-responsive element" style="max-height: 700px">
                    <table class="table text-nowrap mg-b-0">
                        <thead class="position-sticky" style="top: 0px">
                            <tr>
                                <th class="text-white border-end" style="padding: 7px 8px; background-color: gray">No</th>
                                <th class="text-white border-end" style="padding: 7px 8px; background-color: gray">Name</th>
                                <th class="text-white border-end" style="padding: 7px 8px; background-color: gray">Position</th>
                                <th class="text-white border-end" style="padding: 7px 4px; background-color: gray">Scan</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">01</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">02</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">03</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">04</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">05</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">06</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">07</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">08</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">09</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">10</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">11</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">12</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">13</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">14</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">15</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">16</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">17</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">18</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">19</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">20</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">21</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">22</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">23</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">24</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">25</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">26</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">27</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">28</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">29</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3">30</th>
                                <th class="text-center text-white border-end" style="padding: 7px 10px; background-color: #5195D3" v-if="days == 31">31</th>
                                <!-- <th class="text-white wd-80p" style="padding: 7px 10px; background-color: gray">Actions</th> -->
                            </tr>
                        </thead>
                        <tbody class="tx-13">
                            <tr v-for="(lst, key) in scanData" :key="lst.id" class="tr-hover">
                                <td class="text-center py-1 px-2 border-start border-end border-bottom">{{key+1}}</td>
                                <td class="py-1 px-2 border-end border-bottom cur-pointer" @click="prvDetail(lst.id, lst.fullname)" title="Click to see the details">{{lst.fullname}}</td>
                                <td class="py-1 px-2 border-end border-bottom">{{lst.position}}</td>
                                <td class="py-1 px-1 border-end border-bottom text-center ">{{lst.scan}}</td>
                                <td :style="lst.d1 == 'W' || lst.d1 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d1 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d1 == 'R' || lst.d1 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d1 == 'A' || lst.d1 == 'A/2' || lst.d1 == 'H' || lst.d1 == 'P' ? 'background-color: #FFFF99':
                                            lst.d1 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d1 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d1 == 'T' || lst.d1 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end">
                                    {{lst.d1}}
                                </td> 
                                <td :style="lst.d2 == 'W' || lst.d2 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d2 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d2 == 'R' || lst.d2 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d2 == 'A' || lst.d2 == 'A/2' || lst.d2 == 'H' || lst.d2 == 'P' ? 'background-color: #FFFF99':
                                            lst.d2 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d2 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d2 == 'T' || lst.d2 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end">
                                    {{lst.d2}}
                                </td> 
                                <td :style="lst.d3 == 'W' || lst.d3 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d3 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d3 == 'R' || lst.d3 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d3 == 'A' || lst.d3 == 'A/2' || lst.d3 == 'H' || lst.d3 == 'P' ? 'background-color: #FFFF99':
                                            lst.d3 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d3 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d3 == 'T' || lst.d3 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end">
                                    {{lst.d3}}
                                </td> 
                                <td :style="lst.d4 == 'W' || lst.d4 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d4 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d4 == 'R' || lst.d4 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d4 == 'A' || lst.d4 == 'A/2' || lst.d4 == 'H' || lst.d4 == 'P' ? 'background-color: #FFFF99':
                                            lst.d4 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d4 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d4 == 'T' || lst.d4 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end">
                                    {{lst.d4}}
                                </td> 
                                <td :style="lst.d5 == 'W' || lst.d5 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d5 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d5 == 'R' || lst.d5 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d5 == 'A' || lst.d5 == 'A/2' || lst.d5 == 'H' || lst.d5 == 'P' ? 'background-color: #FFFF99':
                                            lst.d5 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d5 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d5 == 'T' || lst.d5 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d5}}
                                </td> 
                                <td :style="lst.d6 == 'W' || lst.d6 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d6 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d6 == 'R' || lst.d6 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d6 == 'A' || lst.d6 == 'A/2' || lst.d6 == 'H' || lst.d6 == 'P' ? 'background-color: #FFFF99':
                                            lst.d6 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d6 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d6 == 'T' || lst.d6 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end">
                                    {{lst.d6}}
                                </td>
                                <td :style="lst.d7 == 'W' || lst.d7 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d7 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d7 == 'R' || lst.d7 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d7 == 'A' || lst.d7 == 'A/2' || lst.d7 == 'H' || lst.d7 == 'P' ? 'background-color: #FFFF99':
                                            lst.d7 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d7 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d7 == 'T' || lst.d7 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d7}}
                                </td>
                                <td :style="lst.d8 == 'W' || lst.d8 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d8 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d8 == 'R' || lst.d8 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d8 == 'A' || lst.d8 == 'A/2' || lst.d8 == 'H' || lst.d8 == 'P' ? 'background-color: #FFFF99':
                                            lst.d8 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d8 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d8 == 'T' || lst.d8 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d8}}
                                </td>
                                <td :style="lst.d9 == 'W' || lst.d9 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d9 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d9 == 'R' || lst.d9 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d9 == 'A' || lst.d9 == 'A/2' || lst.d9 == 'H' || lst.d9 == 'P' ? 'background-color: #FFFF99':
                                            lst.d9 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d9 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d9 == 'T' || lst.d9 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d9}}
                                </td>
                                <td :style="lst.d10 == 'W' || lst.d10 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d10 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d10 == 'R' || lst.d10 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d10 == 'A' || lst.d10 == 'A/2' || lst.d10 == 'H' || lst.d10 == 'P' ? 'background-color: #FFFF99':
                                            lst.d10 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d10 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d10 == 'T' || lst.d10 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d10}}
                                </td>
                                <td :style="lst.d11 == 'W' || lst.d11 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d11 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d11 == 'R' || lst.d11 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d11 == 'A' || lst.d11 == 'A/2' || lst.d11 == 'H' || lst.d11 == 'P' ? 'background-color: #FFFF99':
                                            lst.d11 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d11 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d11 == 'T' || lst.d11 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d11}}
                                </td>
                                <td :style="lst.d12 == 'W' || lst.d12 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d12 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d12 == 'R' || lst.d12 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d12 == 'A' || lst.d12 == 'A/2' || lst.d12 == 'H' || lst.d12 == 'P' ? 'background-color: #FFFF99':
                                            lst.d12 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d12 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d12 == 'T' || lst.d12 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d12}}
                                </td>
                                <td :style="lst.d13 == 'W' || lst.d13 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d13 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d13 == 'R' || lst.d13 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d13 == 'A' || lst.d13 == 'A/2' || lst.d13 == 'H' || lst.d13 == 'P' ? 'background-color: #FFFF99':
                                            lst.d13 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d13 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d13 == 'T' || lst.d13 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d13}}
                                </td>
                                <td :style="lst.d14 == 'W' || lst.d14 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d14 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d14 == 'R' || lst.d14 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d14 == 'A' || lst.d14 == 'A/2' || lst.d14 == 'H' || lst.d14 == 'P' ? 'background-color: #FFFF99':
                                            lst.d14 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d14 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d14 == 'T' || lst.d14 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d14}}
                                </td>
                                <td :style="lst.d15 == 'W' || lst.d15 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d15 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d15 == 'R' || lst.d15 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d15 == 'A' || lst.d15 == 'A/2' || lst.d15 == 'H' || lst.d15 == 'P' ? 'background-color: #FFFF99':
                                            lst.d15 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d15 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d15 == 'T' || lst.d15 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d15}}
                                </td>
                                <td :style="lst.d16 == 'W' || lst.d16 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d16 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d16 == 'R' || lst.d16 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d16 == 'A' || lst.d16 == 'A/2' || lst.d16 == 'H' || lst.d16 == 'P' ? 'background-color: #FFFF99':
                                            lst.d16 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d16 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d16 == 'T' || lst.d16 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d16}}
                                </td>
                                <td :style="lst.d17 == 'W' || lst.d17 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d17 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d17 == 'R' || lst.d17 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d17 == 'A' || lst.d17 == 'A/2' || lst.d17 == 'H' || lst.d17 == 'P' ? 'background-color: #FFFF99':
                                            lst.d17 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d17 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d17 == 'T' || lst.d17 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d17}}
                                </td>
                                <td :style="lst.d18 == 'W' || lst.d18 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d18 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d18 == 'R' || lst.d18 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d18 == 'A' || lst.d18 == 'A/2' || lst.d18 == 'H' || lst.d18 == 'P' ? 'background-color: #FFFF99':
                                            lst.d18 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d18 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d18 == 'T' || lst.d18 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d18}}
                                </td>
                                <td :style="lst.d19 == 'W' || lst.d19 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d19 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d19 == 'R' || lst.d19 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d19 == 'A' || lst.d19 == 'A/2' || lst.d19 == 'H' || lst.d19 == 'P' ? 'background-color: #FFFF99':
                                            lst.d19 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d19 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d19 == 'T' || lst.d19 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d19}}
                                </td>
                                <td :style="lst.d20 == 'W' || lst.d20 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d20 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d20 == 'R' || lst.d20 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d20 == 'A' || lst.d20 == 'A/2' || lst.d20 == 'H' || lst.d20 == 'P' ? 'background-color: #FFFF99':
                                            lst.d20 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d20 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d20 == 'T' || lst.d20 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d20}}
                                </td>
                                <td :style="lst.d21 == 'W' || lst.d21 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d21 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d21 == 'R' || lst.d21 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d21 == 'A' || lst.d21 == 'A/2' || lst.d21 == 'H' || lst.d21 == 'P' ? 'background-color: #FFFF99':
                                            lst.d21 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d21 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d21 == 'T' || lst.d21 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d21}}
                                </td>
                                <td :style="lst.d22 == 'W' || lst.d22 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d22 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d22 == 'R' || lst.d22 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d22 == 'A' || lst.d22 == 'A/2' || lst.d22 == 'H' || lst.d22 == 'P' ? 'background-color: #FFFF99':
                                            lst.d22 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d22 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d22 == 'T' || lst.d22 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d22}}
                                </td>
                                <td :style="lst.d23 == 'W' || lst.d23 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d23 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d23 == 'R' || lst.d23 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d23 == 'A' || lst.d23 == 'A/2' || lst.d23 == 'H' || lst.d23 == 'P' ? 'background-color: #FFFF99':
                                            lst.d23 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d23 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d23 == 'T' || lst.d23 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d23}}
                                </td>
                                <td :style="lst.d24 == 'W' || lst.d24 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d24 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d24 == 'R' || lst.d24 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d24 == 'A' || lst.d24 == 'A/2' || lst.d24 == 'H' || lst.d24 == 'P' ? 'background-color: #FFFF99':
                                            lst.d24 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d24 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d24 == 'T' || lst.d24 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d24}}
                                </td>
                                <td :style="lst.d25 == 'W' || lst.d25 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d25 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d25 == 'R' || lst.d25 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d25 == 'A' || lst.d25 == 'A/2' || lst.d25 == 'H' || lst.d25 == 'P' ? 'background-color: #FFFF99':
                                            lst.d25 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d25 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d25 == 'T' || lst.d25 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d25}}
                                </td>
                                <td :style="lst.d26 == 'W' || lst.d26 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d26 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d26 == 'R' || lst.d26 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d26 == 'A' || lst.d26 == 'A/2' || lst.d26 == 'H' || lst.d26 == 'P' ? 'background-color: #FFFF99':
                                            lst.d26 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d26 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d26 == 'T' || lst.d26 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d26}}
                                </td>
                                <td :style="lst.d27 == 'W' || lst.d27 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d27 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d27 == 'R' || lst.d27 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d27 == 'A' || lst.d27 == 'A/2' || lst.d27 == 'H' || lst.d27 == 'P' ? 'background-color: #FFFF99':
                                            lst.d27 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d27 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d27 == 'T' || lst.d27 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d27}}
                                </td>
                                <td :style="lst.d28 == 'W' || lst.d28 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d28 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d28 == 'R' || lst.d28 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d28 == 'A' || lst.d28 == 'A/2' || lst.d28 == 'H' || lst.d28 == 'P' ? 'background-color: #FFFF99':
                                            lst.d28 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d28 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d28 == 'T' || lst.d28 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d28}}
                                </td>
                                <td :style="lst.d29 == 'W' || lst.d29 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d29 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d29 == 'R' || lst.d29 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d29 == 'A' || lst.d29 == 'A/2' || lst.d29 == 'H' || lst.d29 == 'P' ? 'background-color: #FFFF99':
                                            lst.d29 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d29 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d29 == 'T' || lst.d29 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d29}}
                                </td>
                                <td :style="lst.d30 == 'W' || lst.d30 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d30 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d30 == 'R' || lst.d30 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d30 == 'A' || lst.d30 == 'A/2' || lst.d30 == 'H' || lst.d30 == 'P' ? 'background-color: #FFFF99':
                                            lst.d30 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d30 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d30 == 'T' || lst.d30 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" >
                                    {{lst.d30}}
                                </td>
                                <td :style="lst.d31 == 'W' || lst.d31 == 'WN' ? 'background-color: #F2F4F8':
                                            lst.d31 == 'W/2' ? 'background-color: #FFC000':
                                            lst.d31 == 'R' || lst.d31 == 'RW' ? 'background-color: #FFFFCC':
                                            lst.d31 == 'A' || lst.d31 == 'A/2' || lst.d31 == 'H' || lst.d31 == 'P' ? 'background-color: #FFFF99':
                                            lst.d31 == 'S' ? 'background-color: #F2DCDB':
                                            lst.d31 == 'MR' ? 'background-color: #FF66FF':
                                            lst.d31 == 'T' || lst.d31 == 'T-' ? 'background-color: #FF0000':''" class="text-center p-1 border-bottom border-end" v-if="days == 31">
                                    {{lst.d31}}
                                </td>
                                <!-- <td class="p-0 align-middle border-end border-start">
                                    <div class="d-flex justify-content-start ms-1">
                                        <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" title="Scan detail" @click="prvDetail(lst.id, lst.fullname)">
                                            <i class="fa fa-search text-info" style="font-size: 11px"></i>
                                        </button> 
                                    </div>
                                </td> -->
                            </tr>
                            <!-- <tr class=" border-top"></tr> -->
                        </tbody>
                    </table>
                </div>

                <!-- Modal Detail -->
                <div class="modal fade effect-scale" id="detail" data-bs-keyboard="false" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header pb-1 bd-b-0">
                                <h6 class="text-muted main-content-label text-capitalize">Scan Details For <span class="text-danger">{{fullname}}</span></h6>
                                <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body pt-0">                                   
                                <div class="table-responsive element border">
                                    <table class="table main-table-reference text-nowrap mg-b-0">
                                        <thead>
                                            <tr>
                                                <th class="border-start-0">Date</th>
                                                <th>Plan</th>
                                                <th>Actual</th>
                                                <th>Time Period</th>
                                                <th>In1</th>
                                                <th>Out1</th>
                                                <th>In2</th>
                                                <th>Out2</th>
                                                <th>Timesheet</th>
                                                <th class="border-end-0 wd-60p">Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <tr class="tr-hover cur-pointer" v-for="lst in detailData" :key="lst.date" @click="prvAcLog(lst.id, lst.date)">
                                                <td class="border-start-0 py-0 text-center border-bottom-0"> {{ dateTime(lst.date) }} </td>
                                                <td :style="lst.plan == 'W' || lst.plan == 'WN' ? 'background-color: #F2F4F8':
                                                            lst.plan == 'W/2' ? 'background-color: #FFC000':
                                                            lst.plan == 'R' || lst.plan == 'RW' ? 'background-color: #FFFFCC':
                                                            lst.plan == 'A' || lst.plan == 'A/2' || lst.plan == 'H' || lst.plan == 'P' ? 'background-color: #FFFF99':
                                                            lst.plan == 'S' ? 'background-color: #F2DCDB':
                                                            lst.plan == 'MR' ? 'background-color: #FF66FF':
                                                            lst.plan == 'T' || lst.plan == 'T-' ? 'background-color: #FF0000':''" class="py-0 text-center border-bottom-0"> {{ lst.plan }} 
                                                </td>
                                                <td :style="lst.actual == 'W' || lst.actual == 'WN' ? 'background-color: #F2F4F8':
                                                            lst.actual == 'W/2' ? 'background-color: #FFC000':
                                                            lst.actual == 'R' || lst.actual == 'RW' || lst.actual == 'OR' || lst.actual == 'IR' ? 'background-color: #FFFFCC':
                                                            lst.actual == 'A' || lst.actual == 'A/2' || lst.actual == 'IA' || lst.actual == 'OA' || lst.actual == 'AA' || lst.actual == 'H' || lst.actual == 'OH' || lst.actual == 'IH' || lst.actual == 'P' ? 'background-color: #FFFF99':
                                                            lst.actual == 'S' || lst.actual == 'SS' ? 'background-color: #F2DCDB':
                                                            lst.actual == 'MR' ? 'background-color: #FF66FF':
                                                            lst.actual == 'BWB' || lst.actual == 'WO' ? 'background-color: #C6E0B4':
                                                            lst.actual == 'T' || lst.actual == 'T-' || lst.actual == 'IT' || lst.actual == 'OT' || lst.actual == 'TT' ? 'background-color: #FF0000':''" class="py-0 text-center border-bottom-0"> {{ lst.actual }} 
                                                </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.period }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.in1 }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.out1 }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.in2 }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.out2 }} </td>
                                                <td :style="lst.timesheet == 'W' || lst.timesheet == 'WN' ? 'background-color: #F2F4F8':
                                                            lst.timesheet == 'W/2' ? 'background-color: #FFC000':
                                                            lst.timesheet == 'R' || lst.timesheet == 'RW' ? 'background-color: #FFFFCC':
                                                            lst.timesheet == 'A' || lst.timesheet == 'A/2' || lst.timesheet == 'H' || lst.timesheet == 'P' ? 'background-color: #FFFF99':
                                                            lst.timesheet == 'S' ? 'background-color: #F2DCDB':
                                                            lst.timesheet == 'MR' ? 'background-color: #FF66FF':
                                                            lst.timesheet == 'T' || lst.timesheet == 'T-' ? 'background-color: #FF0000':''" class="py-0 text-center border-bottom-0"> {{ lst.timesheet }} 
                                                </td>
                                                <td class="py-0 laofont border-end-0 border-bottom-0"> {{ lst.remarks }} </td>
                                            </tr>                                                                                 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>                                              
                </div>  

                <!-- Modal AC Log -->
                <div class="modal fade effect-scale pd-t-100 bd-0 bg-black-7" id="aclog" data-bs-keyboard="false" tabindex="-1" aria-labelledby="aclogLabel" aria-hidden="true">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header pb-1 bd-b-0">
                                <h6 class="text-muted">AC Log On <span class="text-danger">{{dateTime(scanDate)}}</span></h6>
                            </div>
                            <div class="modal-body pt-0">                                   
                                <div class="table-responsive element border">
                                    <table class="table main-table-reference text-nowrap mg-b-0">
                                        <thead>
                                            <tr>
                                                <th class="border-start-0">No</th>
                                                <th>Date Time</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th class="border-end-0">Sensor ID</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            <tr class="tr-hover cur-pointer" v-for="(lst, key) in acLogData" :key="lst.datetime">
                                                <td class="py-0 text-center border-bottom-0 border-start-0"> {{ key + 1 }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ dateTime2(lst.datetimes) }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ dateTime(lst.dates) }} </td>
                                                <td class="py-0 text-center border-bottom-0"> {{ lst.times }} </td>
                                                <td class="py-0 border-end-0 border-bottom-0"> {{ lst.sensor }} </td>
                                            </tr>                                                                                 
                                        </tbody>
                                    </table>
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
    name: 'XpplAppFingerscan',

    data() {
        return {
            lkDept: [],
            scanData: [],
            detailData: [],
            acLogData: [],
            dept: '',
            date: moment(new Date()).format('YYYY-MM-DD'),
            days: '',
            search: '',
            btnClear: false,
            fullname: '',
            scanDate: '',
            loading: false

        };
    },

    mounted() {
        
    },

    methods: {
        async onLoad(){
            this.loading = true;

            const profile = await axios.get('api/profile')
			this.dept = profile.data.department;

            const depts = await axios.get('/api/lookup/depts')
            this.lkDept = depts.data;

            const scan = await axios.get(`/api/fingerscan/summary?dept=${this.dept}&date=${this.date}&search=${this.search}`)
            this.scanData = scan.data;
            this.days = scan.data[0].days;

            this.loading = false;
        },

        async selDept(){
            this.loading = true;
            this.scanData = '';

            const summary = await axios.get(`/api/fingerscan/summary?dept=${this.dept}&date=${this.date}&search=${this.search}`)
            this.scanData = summary.data;
            this.days = summary.data[0].days;

            this.loading = false;
        },

        async searchChange(){
            if(this.search.length >0){
                this.btnClear = true;
                const data = await this.selDept();
            } else {
                this.btnClear = false;
                const data = await this.selDept();
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
            this.btnClear = false,
            this.selDept();
        },

        prvDetail(id, name){
            this.fullname = name;
            $('#detail').modal('show');

            this.$axios.post('/api/fingerscan/detail', {
                dept: this.dept,
                date: this.date,
                userid: id
            }).then(res => {
                this.detailData = res.data;
            })
        },

        prvAcLog(id, date){
            this.scanDate = date;
            $('#aclog').modal('show');

             this.$axios.post('/api/fingerscan/aclog', {
                userid: id,
                date: date
            }).then(res => {
                this.acLogData = res.data;
            })
        },

    
        mont(value) {
            if(value) {
                return moment(value).format('MMMM');
            }
        },

        year(value) {
            if(value) {
                return moment(value).format('YYYY');
            }
        },

        dateTime(value) {
            if(value) {
                return moment(value).format('DD-MM-YYYY');
            }
        },

        dateTime2(value) {
            if(value) {
                return moment(value).format('DD-MM-YYYY HH:mm:ss');
            }
        },
    },

    created(){
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