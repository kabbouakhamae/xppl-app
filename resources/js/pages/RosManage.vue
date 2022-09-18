<template>
    <div>
        <h1>Roster Manage</h1>
        <hr>
        <h1 class="laofont mt-5">ຢູ່ພາຍ​ໃຕ້​ການ​ພັດ​ທະ​ນາ!</h1>
        <h1>Under Development!</h1>

        <div class="row">
            <div class="col-xl-4">
                <div class="card card-body">
                    <h4 class="card-title text-muted mb-0 my-auto text-capitalize">Roster Update</h4>
                    <div class=" d-flex justify-content-start mt-3 mb-2">
                        <label class="rdiobox cur-pointer"><input name="rdio" type="radio" value="Plan"><span>Plan</span></label>
                        <label class="rdiobox cur-pointer ms-4"><input name="rdio" type="radio" value="Actual" checked><span>Actual</span></label>  
                    </div>
                    <div class="form-group">
                        <label class="mb-0">Name</label> 
                        <Multiselect class="multi-color " placeholder="Select" searchable="true" :options="lkCountry"/>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="mb-0">From</label>
                                <input type="date" class="form-control" placeholder="Province...">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="mb-0">To</label>
                                <input type="date" class="form-control" placeholder="Province...">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="mb-0">Leave Types</label> 
                        <Multiselect class="multi-color " placeholder="Select" searchable="true" :options="lkCountry"/>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppRosManage',

    data() {
        return {
            
        };
    },

    mounted() {
        
    },

    methods: {
        
    },

    beforeRouteEnter(to, from, next){
        if(!window.Laravel.isLoggedin_laravel){
            window.location.href = "/signin";
        }
        next();
	}
};
</script>

<style lang="scss" scoped>

</style>