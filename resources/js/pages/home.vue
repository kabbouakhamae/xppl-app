<template>
    <div>
        
        <div class="card">
            <div class=" w-25">
                <div class="card-header border-bottom-0 pb-0">
                    <h3 class="card-title">Top Countries</h3>
                </div>
                <div class="card-body p-0">
                    <table class="table card-table country-table mb-0">
                        <tbody>
                            <tr>
                                <td class="w-1"><img src="assets/img/flags/us_flag.jpg" alt="flags" class="flag wd-30 ht-20 flag-us mt-1"></td>
                                <td>USA
                                    <div class="progress progress-sm mt-1">
                                        <div class="progress-bar bg-primary wd-80"></div>
                                    </div>
                                </td>
                                <td class="w-1 text-end"><span class="text-muted">$5235</span></td>
                            </tr>
                            <tr>
                                <td class="w-1"><img src="assets/img/flags/spain_flag.jpg" alt="flags" class="flag wd-30 ht-20 flag-us mt-1"></td>
                                <td>Spain
                                    <div class="progress progress-sm mt-1">
                                        <div class="progress-bar bg-pink wd-60"></div>
                                    </div>
                                </td>
                                <td class="text-end"><span class="text-muted">$3214</span></td>
                            </tr>
                            <tr>
                                <td class="w-1"><img src="assets/img/flags/germany_flag.jpg" alt="flags" class="flag wd-30 ht-20 flag-us mt-1"></td>
                                <td>Germany
                                    <div class="progress progress-sm mt-1">
                                        <div class="progress-bar bg-success wd-30"></div>
                                    </div>
                                </td>
                                <td class="text-end"><span class="text-muted">$4123</span></td>
                            </tr>
                            <tr>
                                <td class="w-1"><img src="assets/img/flags/russia_flag.jpg" alt="flags" class="flag wd-30 ht-20 flag-us mt-1"></td>
                                <td>Russia
                                    <div class="progress progress-sm mt-1">
                                        <div class="progress-bar bg-warning wd-50"></div>
                                    </div>
                                </td>
                                <td class="text-end"><span class="text-muted">$1543</span></td>
                            </tr>
                            <tr>
                                <td class="w-1"><img src="assets/img/flags/italy_flag.jpg" alt="flags" class="flag wd-30 ht-20 flag-us mt-1"></td>
                                <td>Italy
                                    <div class="progress progress-sm mt-1">
                                        <div class="progress-bar bg-teal wd-40"></div>
                                    </div>
                                </td>
                                <td class="text-end"><span class="text-muted ">$1543</span></td>
                            </tr>
                            <tr>
                                <td class="w-1"><img src="assets/img/flags/french_flag.jpg" alt="flags" class="flag wd-30 ht-20 flag-us mt-1"></td>
                                <td>French
                                    <div class="progress progress-sm mt-1">
                                        <div class="progress-bar bg-teal wd-40"></div>
                                    </div>
                                </td>
                                <td class="text-end"><span class="text-muted ">$1543</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>


            <div class="card card-dashboard-eight pb-2 w-25">
								<h6 class="card-title">Your Top Countries</h6><span class="d-block mg-b-10 text-muted tx-12">Sales performance revenue based by country</span>
								<div class="list-group border-top-0">
									<div class="list-group-item border-top-0" id="br-t-0">
										<i class="flag-icon flag-icon-us flag-icon-squared"></i>
										<p>United States</p><span>$1,671.10</span>
									</div>
									<div class="list-group-item">
										<i class="flag-icon flag-icon-nl flag-icon-squared"></i>
										<p>Netherlands</p><span>$1,064.75</span>
									</div>
									<div class="list-group-item">
										<i class="flag-icon flag-icon-gb flag-icon-squared"></i>
										<p>United Kingdom</p><span>$1,055.98</span>
									</div>
									<div class="list-group-item">
										<i class="flag-icon flag-icon-ca flag-icon-squared"></i>
										<p>Canada</p><span>$1,045.49</span>
									</div>
									<div class="list-group-item">
										<i class="flag-icon flag-icon-in flag-icon-squared"></i>
										<p>India</p><span>$1,930.12</span>
									</div>
									<div class="list-group-item border-bottom-0 mb-0">
										<i class="flag-icon flag-icon-au flag-icon-squared"></i>
										<p>Australia</p><span>$1,042.00</span>
									</div>
								</div>
							</div>


        </div>

    </div>
</template>

<script>
export default {
    name: 'XpplAppHome',

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