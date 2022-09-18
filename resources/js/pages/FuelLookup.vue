<template>
    <div class="row">
        <div class="col-xl-6">
            <div class="card mg-b-20">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mg-b-0">Lookup Code</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                    <p class="tx-12 tx-gray-500 mb-2">Lookup code for Fuel reservation...</p>
                </div>
                <div class="card-body pt-2">
                    <div class="row">
                        <div class="col-xl-4">
                            <table class="table table-bordered border-bottom mg-b-0 text-nowrap">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="px-2 ">Category</th>
                                    </tr>
                                </thead>
                            </table>
                            
                            <div class="table-responsive ht-230 element border-end border-bottom border-start">
                                <table class="table mg-b-0 text-nowrap">
                                    <tbody class="tx-13">
                                        <tr class="tr-hover cur-pointer" v-for="(lst, key) in category" :key="lst.category" @click="dateSelected(key, dateTime1(lst.rent_date))" :style="key === selDateRow ? 'background-color: #dadee7; border-left: 1px solid #0162e8; color: blue' : ''">
                                            <td class="px-2 py-1" style="border: none">{{lst.category}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-xl-8 ps-sm-0 pt-sm-0 pt-3" >
                            <div class="table-responsive element" style="max-height: 261.08px">
                                <table class="table table-bordered border-bottom mg-b-0 text-nowrap">
                                    <thead class="position-sticky" style="top: -1px">
                                        <tr class="bg-light">
                                            <th class="px-2">Code</th>
                                            <th class="px-2">Description</th>
                                            <th class="px-2 wd-60p">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="tx-13">
                                        <tr class="tr-hover" v-for="(lst) in category" :key="lst.category">
                                            <td class="px-2 py-1">{{lst.category}}</td>
                                            <td class="px-2 py-1">{{lst.category}}</td>

                                            
                                            <td class="p-0 align-middle">
                                                <div class="d-flex justify-content-start">
                                                    <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" title="Edit this record" @click="genCodeEdit(lst.id)">
                                                        <i class="bx bx-edit text-info" style="font-size: 16px"></i>
                                                    </button> 
                                                    <button class="btn btn-icon btn-sm btn-i wd-25 ht-25" title="Delete this record" @click="genCodeDel(lst.id)">
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
        </div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppFuelLookup',

    data() {
        return {
            category: []
        };
    },

    mounted() {
        
    },

    methods: {
        async onLoad(){
            const cate = await axios.get('/api/fuel/category')
            this.category = cate.data;
        }
    },

    created() {
        this.onLoad();
    }
};
</script>

<style>
    .element::-webkit-scrollbar {
        display: none;
    }
</style>