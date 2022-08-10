<template>
    <div>
        <div v-if="!!parseInt(loginPermiss.permiss)" class="card">
            <div class="card-body">
                <div class="row">
                    <div class="wd-250" style="min-width: 250px">
                        <div class="pos-relative">
                            <input class="form-control form-control-sm pd-l-30" type="text" placeholder="Search..." v-model="search" @input="searchChange()" >
                            <i class="fe fe-search search-i text-muted"></i>
                            <button class="btn btn-icon btn-sm search-c text-muted" v-if="btnClear" @click="searchClear()"><i class="fe fe-x"></i></button>
                        </div>
                        <div class="table-responsive border mt-1" style="max-height: 700px">
                            <table class="table main-table-reference text-nowrap table-hover cur-pointer" >
                                <thead class="position-sticky" style="top: -1px">
                                    <tr>
                                        <th style="letter-spacing: 0px">Name</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    <tr v-for="(lst, key) in userList" :key="lst.id" @click="permissEdit(key, lst.id)" :style="key === selectedRow ? 'background-color: #ecf0fa; border-left: 1px solid #0162e8;' : ''">
                                        <td style="border: none; padding: 4px 10px" > {{ lst.name }} {{ lst.surname }}  </td>
                                    </tr>                                                
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-xl-2 col-3">
                        <h6 class="text-muted">Setting</h6>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="permiss"  v-model="permissData.permiss" @change='$emit("input", $event.target.checked)'>
                            <label class="custom-control-label cur-pointer" for="permiss">Permission</label>
                        </div>

                        <h6 class=" text-muted mt-4">Department Tools</h6>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="geo"  v-model="permissData.geo" @change='$emit("input", $event.target.checked)'>
                            <label class="custom-control-label cur-pointer" for="geo">Geology</label>
                        </div>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" id="mining"  v-model="permissData.mining" @change='$emit("input", $event.target.checked)'>
                            <label class="custom-control-label cur-pointer" for="mining">Mining</label>
                        </div>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" id="safety"  v-model="permissData.safety" @change='$emit("input", $event.target.checked)'>
                            <label class="custom-control-label cur-pointer" for="safety">Safety</label>
                        </div>
                        <button class="mt-4" @click="permissUpdate()">Update</button>
                    </div>

                    <div class="col-xl-3 col-lg-4">
                        <h6 class=" text-muted">Employee</h6>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="empAll" v-model="permissData.empAll" @change='$emit("input", $event.target.checked)'>
                            <label class="custom-control-label cur-pointer" for="empAll">View all</label>
                        </div>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" id="empAdd" v-model="permissData.empAdd" @change='$emit("input", $event.target.checked)'>
                            <label class="custom-control-label cur-pointer" for="empAdd">Add</label>
                        </div>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" id="empDel"  v-model="permissData.empDel" @change='$emit("input", $event.target.checked)'>
                            <label class="custom-control-label cur-pointer" for="empDel">Delete</label>
                        </div>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" id="empEdit" v-model="permissData.empEdit" @change='$emit("input", $event.target.checked)'>
                            <label class="custom-control-label cur-pointer" for="empEdit">Edit</label>
                        </div>
                        <div v-if="permissData.empEdit">
                            <div class="custom-control custom-switch mt-2 ms-4">
                                <input type="checkbox" class="custom-control-input" id="detailDel" v-model="permissData.detailDel" @change='$emit("input", $event.target.checked)'>
                                <label class="custom-control-label cur-pointer" for="detailDel">Detail delete</label>
                            </div>
                            <div class="custom-control custom-switch mt-2 ms-4">
                                <input type="checkbox" class="custom-control-input" id="contDel" v-model="permissData.contDel" @change='$emit("input", $event.target.checked)'>
                                <label class="custom-control-label cur-pointer" for="contDel">Contact person delete</label>
                            </div>
                            <div class="custom-control custom-switch mt-2 ms-4">
                                <input type="checkbox" class="custom-control-input" id="bankDel" v-model="permissData.bankDel" @change='$emit("input", $event.target.checked)'>
                                <label class="custom-control-label cur-pointer" for="bankDel">Bank info delete</label>
                            </div>
                            <div class="custom-control custom-switch mt-2 ms-4">
                                <input type="checkbox" class="custom-control-input" id="cardDel" v-model="permissData.cardDel" @change='$emit("input", $event.target.checked)'>
                                <label class="custom-control-label cur-pointer" for="cardDel">Personal card delete</label>
                            </div>
                            <div class="custom-control custom-switch mt-2 ms-4">
                                <input type="checkbox" class="custom-control-input" id="alDel" v-model="permissData.alDel" @change='$emit("input", $event.target.checked)'>
                                <label class="custom-control-label cur-pointer" for="alDel">Annual leave delete</label>
                            </div>
                            <div class="custom-control custom-switch mt-2 ms-4">
                                <input type="checkbox" class="custom-control-input" id="fileDel" v-model="permissData.fileDel" @change='$emit("input", $event.target.checked)'>
                                <label class="custom-control-label cur-pointer" for="fileDel">Document and File delete</label>
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
    name: 'XpplAppPermission',

    data() {
        return {
            loginPermiss: [],
            userList: [],
            permissData: {
                id: '',
                permiss: '',
                geo: '',
                mining: '',
                safety: '',
                lkAdd: '',
                lkEdit: '',
                lkDel: '',
                empAll: '',
                empAdd: '',
                empEdit: '',
                empDel: '',
                detailDel: '',
                contDel: '',
                bankDel: '',
                cardDel: '',
                alDel: '',
                fileDel: ''
            },
            search: '',
            selectedRow: null,
        };
    },

    mounted() {
        
    },

    methods: {
        async getPermiss(){
            const response = await axios.get('/api/permiss')
            this.loginPermiss = response.data;
        },

        getUsername(){
            this.$axios.get(`/api/username?search=${this.search}`)
            .then((res) => {
                this.userList = res.data;
            }).catch ((err) => {
                console.log(err);
            })
        },

        permissEdit(key, id){
            this.selectedRow = key;
            this.$axios.post(`/api/permissEdit/${id}`).then((res) => {
            
            this.resetForm();
            let dt = this.permissData;
                dt.id = res.data.id;
                dt.permiss = !!parseInt(res.data.permiss);
                dt.geo = !!parseInt(res.data.geo);
                dt.mining = !!parseInt(res.data.mining);
                dt.safety = !!parseInt(res.data.safety);
                dt.lkAdd = !!parseInt(res.data.lk_add);
                dt.lkEdit = !!parseInt(res.data.lk_edit);
                dt.lkDel = !!parseInt(res.data.lk_del);
                dt.empAll = !!parseInt(res.data.emp_all);
                dt.empAdd = !!parseInt(res.data.emp_add);
                dt.empEdit = !!parseInt(res.data.emp_edit);
                dt.empDel = !!parseInt(res.data.emp_del);
                dt.detailDel = !!parseInt(res.data.detail_del);
                dt.contDel = !!parseInt(res.data.cont_del);
                dt.bankDel = !!parseInt(res.data.bank_del);
                dt.cardDel = !!parseInt(res.data.card_del);
                dt.alDel = !!parseInt(res.data.al_del);
                dt.fileDel = !!parseInt(res.data.file_del);

            }).catch((err) => {
                console.log(err);
            })
        },

        permissUpdate(){
            this.$axios.post('api/permissUpdate', this.permissData)
            .then((response) => {

                this.getPermiss();
                window.location.reload();

            }).catch ((err) => {
                console.log(err);
            })
        },

        resetForm(){
            let dt = this.permissData;
                dt.permiss = '';
                dt.geo = '';
                dt.mining = '';
                dt.safety = '';
                dt.lkAdd = '';
                dt.lkEdit = '';
                dt.lkDel = '';
                dt.empAll = '';
                dt.empAdd = '';
                dt.empEdit = '';
                dt.empDel = '';
                dt.detailDel = '';
                dt.contDel = '';
                dt.bankDel = '';
                dt.cardDel = '';
                dt.alDel = '';
                dt.fileDel = '';
        },
        
        searchChange(){
            if(this.search.length >0){
                this.btnClear = true;
                this.getUsername();
            } else {
                this.btnClear = false;
                this.getUsername();
            }
        },

        searchClear(){
            this.search = '';
            this.btnClear = false,
            this.getUsername();
        },
            
    },

    created(){
        this.getPermiss();
        this.getUsername();
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