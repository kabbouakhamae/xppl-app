<template>
    <div>


<!-- Page -->
		<div class="page">


				<div class="row no-gutter">
					<!-- The image half -->
					<div class="col-md-6 col-lg-6 col-xl-7 d-none d-md-flex bg-primary-transparent">
						<div class="row wd-100p mx-auto text-center">
							<div class="col-md-12 col-lg-12 col-xl-12 my-auto mx-auto wd-100p">
								<img src="assets/img/media/login.png" class="my-auto ht-xl-80p wd-md-100p wd-xl-80p mx-auto" alt="logo">
							</div>
						</div>
					</div>
					<!-- The content half -->
					<div class="col-md-6 col-lg-6 col-xl-5 bg-white">
						<div class="login d-flex align-items-center py-2">
							<!-- Demo content-->
							<div class="container p-0">
								<div class="row">
									<div class="col-md-10 col-lg-10 col-xl-9 mx-auto">
										<div class="card-sigin">
											<div class="mb-5 d-flex">
												<a href="index.html"><img src="assets/img/brand/favicon.png" class="sign-favicon-a ht-40" alt="logo">
												<img src="assets/img/brand/favicon-white.png" class="sign-favicon-b ht-40" alt="logo">
												</a>
												<h1 class="main-logo1 ms-1 me-0 my-auto tx-28">XPPL</h1>
											</div>
											<div class="card-sigin main-signup-header">
												<!-- <div class="main-signup-header"> -->
													<h2>Welcome back!</h2>
													<h5 class="fw-semibold mb-4">Please sign in to continue.</h5>

		
														<div class="form-group">
															<label>Name</label> <input class="form-control" placeholder="Enter your email" type="text" v-model="txtName">
														</div>

														<div class="form-group">
															<label>Password</label> <input class="form-control" placeholder="Enter your password" type="password" v-model="txtPassword" @keyup.enter="fncSignin()">
														</div>
														<button class="btn btn-primary btn-block" @click="fncSignin()">Sign In</button>
					
                                                        <div class="alert alert-warning mt-2" role="alert" v-if="showErr">

															<button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
																<!-- <span aria-hidden="true">×</span> -->
															</button>
															
															<strong>Warning!</strong> {{textErr}}
                                                        </div>


													<div class="main-signin-footer mt-5">
														<p>Don't have an account? <router-link to="/signup"> &nbsp; <strong>Create an Account</strong></router-link></p>
													</div>
												<!-- </div> -->
											</div>
										</div>
									</div>
								</div>
							</div><!-- End -->
						</div>
					</div><!-- End -->
				</div>
		

		</div>
		<!-- End Page -->


    </div>
</template>

<script>
export default {
    name: 'XpplAppLogin',

    data() {
        return {
            showErr: false,
            textErr: '',
            txtName: '',
            txtPassword: '',
        };
    },

    mounted() {
        
    },

    methods: {

        fncSignin(){
			if(this.txtName != "" && this.txtPassword !=""){

				this.showErr = false;
				this.textErr = "";
				
					this.$axios.post("api/signin",
                        {   
                            txtNameVal: this.txtName,
                            txtPasswordVal: this.txtPassword
                        }).then((response) => {
                            
                            if(response.data.success){
                                //this.$router.push('login'); // ໄປໜ້າ Login
								window.location.href = "/";
                            } else {
                                this.showErr = true;
                                this.textErr = response.data.message;
                            }
                        }).cath(function(error){
                            console.error(error);
                        });


			} else {
				this.showErr = true;
				this.textErr = "Please fill out all required fields!";
			}

        },
        
    },

    beforeRouteEnter(to, from, next){
        if(window.Laravel.isLoggedin_laravel){
            window.location.href = "/";
        }

        next();
	}
};
</script>

<style lang="scss" scoped>

</style>