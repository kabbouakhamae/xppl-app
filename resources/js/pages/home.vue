<template>
    <div class="">
        <div class="row">
            
            <div class="col-xxl-3">
                <div class="card card-dashboard-eight">
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
            <div class="col-xxl-3">
                <div class="card card-dashboard-eight">
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