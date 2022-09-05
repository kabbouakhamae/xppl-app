<template>
    <div class="">
        <div class="row">
            <div class="col-xl-3 col-lg-5 col-md-6 col-12">
                <div class="card bg-primary-gradient text-white ">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="icon1 mt-2 text-center">
                                    <i class="fe fe-users tx-40"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">All Employee</span>
                                    <h2 class="text-white mb-0">{{ allemp }}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-dashboard-eight">
                    <h6 class="card-title">by Countries <span class="text-danger">{{ allemp }}</span></h6>
                    <span class="d-block mg-b-10 text-muted tx-12">Current employee based by country</span>
                    <div class="list-group border-top-0" v-for="lst in countCounty" :key="lst.country" >
                        <div class="list-group-item border-top-0" id="br-t-0">
                            <i v-if="lst.country == 'Lao PDR'" class="flag-icon flag-icon-la flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Thailand'" class="flag-icon flag-icon-th flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Philippines'" class="flag-icon flag-icon-ph flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Indonesia'" class="flag-icon flag-icon-id flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Vietnam'" class="flag-icon flag-icon-vn flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Australia'" class="flag-icon flag-icon-au flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'China'" class="flag-icon flag-icon-cn flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Undefine'" class="flag-icon flag-icon-squared"></i>
                            <p>{{ lst.country }}</p><span>{{ lst.cnt }}</span>
                        </div>
                    </div>
                    <div class="mt-1 text-end">
                        {{ allemp }}
                    </div>
                </div>
                
                <div class="card card-dashboard-eight">
                    <h6 class="card-title">By Department</h6>
                    <span class="d-block mg-b-10 text-muted tx-12">Current employee based by department</span>
                    <div class="list-group border-top-0" v-for="lst in countDept" :key="lst.department" >
                        <div class="list-group-item border-top-0" id="br-t-0">
                            <p class="ms-0">{{ lst.department }}</p><span>{{ lst.cnt }}</span>
                        </div>
                    </div>
                </div>

            </div>
            <!-- <div class="col-lg-6 col-xl-3 col-md-6 col-12">
						<div class="card bg-danger-gradient text-white">
							<div class="card-body">
								<div class="row">
									<div class="col-6">
										<div class="icon1 mt-2 text-center">
											<i class="fe fe-shopping-cart tx-40"></i>
										</div>
									</div>
									<div class="col-6">
										<div class="mt-0 text-center">
											<span class="text-white">Sales</span>
											<h2 class="text-white mb-0">854</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

            <div class="col-lg-6 col-xl-3 col-md-6 col-12">
                <div class="card bg-success-gradient text-white">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="icon1 mt-2 text-center">
                                    <i class="fe fe-bar-chart-2 tx-40"></i>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-0 text-center">
                                    <span class="text-white">Profits</span>
                                    <h2 class="text-white mb-0">98K</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           <div class="col-lg-6 col-xl-3 col-md-6 col-12">
						<div class="card bg-warning-gradient text-white">
							<div class="card-body">
								<div class="row">
									<div class="col-6">
										<div class="icon1 mt-2 text-center">
											<i class="fe fe-pie-chart tx-40"></i>
										</div>
									</div>
									<div class="col-6">
										<div class="mt-0 text-center">
											<span class="text-white">Taxes</span>
											<h2 class="text-white mb-0">876</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> -->
            
            <!-- <div class="col-xl-3 col-lg-4">
                <div class="card card-dashboard-eight">
                    <h6 class="card-title">by Countries <span class="text-danger">{{ allemp }}</span></h6>
                    <span class="d-block mg-b-10 text-muted tx-12">Current employee based by country</span>
                    <div class="list-group border-top-0" v-for="lst in countCounty" :key="lst.country" >
                        <div class="list-group-item border-top-0" id="br-t-0">
                            <i v-if="lst.country == 'Lao PDR'" class="flag-icon flag-icon-la flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Thailand'" class="flag-icon flag-icon-th flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Philippines'" class="flag-icon flag-icon-ph flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Indonesia'" class="flag-icon flag-icon-id flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Vietnam'" class="flag-icon flag-icon-vn flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Australia'" class="flag-icon flag-icon-au flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'China'" class="flag-icon flag-icon-cn flag-icon-squared"></i>
                            <i v-else-if="lst.country == 'Undefine'" class="flag-icon flag-icon-squared"></i>
                            <p>{{ lst.country }}</p><span>{{ lst.cnt }}</span>
                        </div>
                    </div>
                    <div class="mt-1 text-end">
                        {{ allemp }}
                    </div>
                </div>
                
                <div class="card card-dashboard-eight">
                    <h6 class="card-title">By Department</h6>
                    <span class="d-block mg-b-10 text-muted tx-12">Current employee based by department</span>
                    <div class="list-group border-top-0" v-for="lst in countDept" :key="lst.department" >
                        <div class="list-group-item border-top-0" id="br-t-0">
                            <p class="ms-0">{{ lst.department }}</p><span>{{ lst.cnt }}</span>
                        </div>
                    </div>
                </div>


            </div> -->


                
        </div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppHome',

    data() {
        return {
            profile: [],
            countCounty: [],
            countDept: [],
            allemp: '',

        };
    },

    mounted() {
        
    },

    methods: {
         
        async getProfile(){
			const response = await axios.get('api/profile')
			this.profile = response.data;
		},

        async getInfo(){
            const cntAllEmp = await axios.get('/api/home/allemp')
            this.allemp = cntAllEmp.data[0].cnt;

            const cntCountry = await axios.get('/api/home/countcountry')
            this.countCounty = cntCountry.data;
       
            const cntEmpDept = await axios.get('/api/home/countdept')
            this.countDept = cntEmpDept.data;
       
       
       },
       
    },

    created(){
        this.getProfile();
        this.getInfo();
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
    .card{
        margin-bottom: 10px;
    }
</style>