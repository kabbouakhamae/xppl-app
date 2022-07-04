<template>
    <div>
        <div class="page">

			<!-- <div class="container-fluid"> -->
				<div class="row no-gutter justify-content-center">

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
											
                                                        <!-- <h5 class="fw-normal mb-4">Sign up form</h5> -->

                                                        <div class="form-group multi-color">
                                                            <label>Department</label> 
                                                            <Multiselect
                                                                v-model="txtDept"
                                                                placeholder="Select your department"
                                                                searchable= true
                                                                :options="deptList"
                                                            />
                                                        </div>  

                                                        <div class="form-group">
                                                            <label>Name</label> 
                                                            <input class="form-control" placeholder="Enter your name" type="text" v-model="txtName">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Password</label> 
                                                            <input class="form-control" placeholder="Enter your password" type="password" v-model="txtPassword">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Confirm Password</label> 
                                                            <input class="form-control" placeholder="Confirm your password" type="password" v-model="txtPassword2" @keyup.enter="fncSignup()">
                                                        </div>

                                                        <button class="btn btn-primary btn-block" @click="fncSignup()">Create Account</button>

                                                        <div class="alert alert-warning mt-2" role="alert" v-if="showErr">
                                                            <button aria-label="Close" class="close" data-bs-dismiss="alert" type="button">
                                                                <!-- <span aria-hidden="true">×</span> -->
                                                            </button>
                                                            <strong>Warning!</strong> {{textErr}}
                                                        </div>
                                                    
                                                        <div class="main-signup-footer mt-5">
                                                            <p>Already have an account? <router-link to="/signin"> &nbsp; <strong>Sign In</strong></router-link></p>
                                                        </div>



										</div>
									</div>
								</div>
							</div><!-- End -->
						</div>
					</div><!-- End -->
				</div>
			<!-- </div> -->

		</div>
    </div>
</template>

<script>
export default {
    name: 'XpplAppfncSignup',

    data() {
        return {
            deptList: [],
            showErr: false,
            textErr: '',
            txtName: '',
            txtDept: '',
            txtPassword: '',
            txtPassword2: ''
            
        };
    },

    mounted() {
        
    },

    methods: {
        fncDeptList(){
            this.$axios.get("api/department").then((response) => {
                this.deptList = response.data;
            }).catch((error) => {
                console.log(error);
            });
        },

        fncSignup(){
            if(this.txtName == '' || this.txtDept =='' || this.txtPassword ==''){
                this.showErr = true;
                this.textErr = "Please fill out all required fields!";
            } else {

                if(this.txtPassword == this.txtPassword2)
                    {
                        this.showErr = false;
                        this.textErr = "";

                        /// ທຳການຍິງຂໍ້ມູນ ສົ່ງໄປ Back-end ໂດຍໃຊ້ axios
                        this.$axios.post("api/signup",{   
                            txtNameVal: this.txtName,
                            txtDeptVal: this.txtDept,
                            txtPasswordVal: this.txtPassword
                        }).then((response) => {
                            
                            if(response.data.success){
                                this.$router.push('signin'); // ໄປໜ້າ Login
                            } else {
                                this.showErr = true;
                                this.textErr = response.data.message;
                            }
                        }).cath(function(error){
                            console.error(error);
                        });

                    } else {
                        this.showErr = true;
                        this.textErr = "Confirm password doesn't match!"
                    }
            }

        },
        
    },

    created(){
        this.fncDeptList()
    },

    beforeRouteEnter(to, from, next){
        if(window.Laravel.isLoggedin_laravel){
            window.location.href = "/";
        }

        next();
	}
};
</script>

<style src="@vueform/multiselect/themes/default.css">

</style>