<template>
    <div>
        

    
<!-- Page -->
		<div class="page">

			<!-- main-sidebar -->
			<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
			<aside class="app-sidebar sidebar-scroll" v-if="isSignin">
				<div class="main-sidebar-header active">
					<a class="desktop-logo logo-light active" href="index.html"><img src="assets/img/brand/xppl3.jpg" class="main-logo" alt="logo"></a>
					<!-- <a class="desktop-logo logo-dark active" href="index.html"><img src="assets/img/brand/PSG1.jpg" class="main-logo dark-theme" alt="logo"></a> -->
					<a class="logo-icon mobile-logo icon-light active" href="index.html"><img src="assets/img/brand/xppl3.jpg" class="logo-icon" alt="logo"></a>
					<!-- <a class="logo-icon mobile-logo icon-dark active" href="index.html"><img src="assets/img/brand/favicon-white.png" class="logo-icon dark-theme" alt="logo"></a> -->
				</div>
				<div class="main-sidemenu">
					<div class="app-sidebar__user clearfix">
	
					</div>
					<ul class="side-menu">
						<li class="side-item side-item-category">Admin</li>
                        <li class="slide " @click="login_click">
							<router-link class="side-menu__item" :class="login_act" to="/employee">
								<span class="side-menu__label"><i class="far fa-user ibox"></i><span class="mx-2">Staff</span></span>
								<span class="badge bg-success text-light" id="bg-side-text">1</span>
							</router-link>
						</li>

                        <li class="slide" @click="employee_click">
							<router-link class="side-menu__item " :class="employee_act"  to="/test">
								<span class="side-menu__label"><i class="fa fa-users ibox"></i><span class="mx-2">Roster</span></span>
							</router-link>
						</li>

						

                        <li class="slide is-expanded" :class="otherinfo_exp" @click="otherinfo_click">
							<a class="side-menu__item active" :class="otherinfo_act" href="#">
								<span class="side-menu__label"><i class="fa fa-info-circle ibox"></i><span class="mx-2">Other Info</span></span>
								<i class="angle fe fe-chevron-down"></i>
							</a>
							<ul class="slide-menu">
								<li><router-link class="slide-item" @click="otherinfosub_click" to="/annualLeave">Annual Leave</router-link></li>
								<li><router-link class="slide-item" @click="otherinfosub_click" to="/leaveInfo">Leave Info</router-link></li>
								<li><router-link class="slide-item" @click="otherinfosub_click" to="/transport">Daily Transport</router-link></li>			
							</ul>
						</li>



                        <li class="side-item side-item-category">Feul</li>
						<li class="slide" :class="consump_exp" @click="consump_click">
						<a class="side-menu__item" :class="consump_act" href="#">
								<span class="side-menu__label"><i class="fa fa-info-circle ibox"></i><span class="mx-2">Feul Consumption</span></span>
								<i class="angle fe fe-chevron-down"></i>
							</a>
							<ul class="slide-menu">
								<li><a class="slide-item" @click="consumpsub_click" href="/register">Register</a></li>
								<li><a class="slide-item" @click="consumpsub_click" href="#">Draggablecards</a></li>
								<li><a class="slide-item" @click="consumpsub_click" href="#">Range-slider</a></li>
								<li><a class="slide-item" @click="consumpsub_click" href="#">Calendar</a></li>
							</ul>
						</li>
						
	
	
						
					</ul>
				</div>
			</aside>
			<!-- main-sidebar -->

			<!-- main-content -->
			<div :class="appClass">

			<!-- main-header -->
			<div class="main-header sticky side-header nav nav-item" v-if="isSignin">
				<div class="container-fluid">
					<div class="main-header-left ">
	
						<div class="app-sidebar__toggle" data-bs-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>

                        <div class=" pt-2 mx-3 text-muted">
                                <h5>{{ signinInfo.department }}</h5>
                        </div>

						<!-- <div class="main-header-center ms-3 d-sm-none d-md-none d-lg-block">
							<input class="form-control" placeholder="Search for anything..." type="search"> <button
								class="btn"><i class="fas fa-search d-none d-md-block"></i></button>
						</div> -->
					</div>
					<div class="main-header-right">
						<ul class="nav nav-item  navbar-nav-right ms-auto">
						
                        	<li class="nav-item full-screen fullscreen-button">
								<a class="new nav-link full-screen-link" href="#" title="Full screen"><svg
										xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
										fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
										stroke-linejoin="round">
										<path
											d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
										</path>
									</svg></a>
							</li>

							<li class="dropdown main-profile-menu nav nav-item nav-link">
								<a class="profile-user d-flex pt-2" href="">
                                    <p class=" pt-2 me-2 text-muted">{{ fullname }}</p>
                                    <img alt="" v-if="images" :src="'assets/img/profile/'+ images">
                                    <img alt="" v-if="!images && gender == 'Male'" src="assets/img/male.png">
                                    <img alt="" v-if="!images && gender != 'Male'" src="assets/img/female.png">
                                </a>
								
                                <div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
											<div v-if="images" class="main-img-user"><img alt="" :src="'assets/img/profile/'+ images"></div>
											<div v-if="!images && gender == 'Male'" class="main-img-user"><img alt="" src="assets/img/male.png"></div>
											<div v-if="!images && gender != 'Male'" class="main-img-user"><img alt="" src="assets/img/female.png"></div>											
											<div class="ms-3 my-auto">
												<h6>{{ name }}</h6><span> User type: {{ signinInfo.usertype }}</span>
											</div>
										</div>
									</div>
									<a class="dropdown-item disabled" href=""><i class="bx bx-user-circle"></i>Profile</a>
									<a class="dropdown-item disabled" href=""><i class="bx bx-cog"></i> Edit Profile</a>
									<a class="dropdown-item disabled" href=""><i class="bx bxs-inbox"></i>Inbox</a>
									<a class="dropdown-item disabled" href=""><i class="bx bx-envelope"></i>Messages</a>
									<a class="dropdown-item disabled" href=""><i class="bx bx-slider-alt"></i> Account
										Settings</a>
									<a class="dropdown-item" href="" @click="signOut()"><i class="bx bx-log-out"></i> Sign out</a>
								</div>
							</li>
							

	

						</ul>
					</div>
				</div>
			</div>
			<!-- /main-header -->

				<!-- container -->
				<div class="container-fluid">

                    <router-view></router-view>

				</div>
				<!-- /Container -->
			</div>


			<!-- Footer opened -->
			<div class="main-footer ht-40" v-if="isSignin">
				<div class="container-fluid pd-t-0-f ht-100p">
					<span>Copyright © 2022 <a href="#">XPPL</a>. Designed by <a href="#">Chamlong</a> All rights reserved.</span>
				</div>
			</div>
			<!-- Footer closed -->

		</div>
		<!-- End Page -->


    </div>
</template>

<script>
export default {
    name: 'XpplAppApp',

    data() {
        return {
            isSignin: false,
            appClass: '',
            signinInfo: [],
			name: '',
			fullname: '',
			gender: '',
			images: '',
        };
    },

    mounted() {
        
    },

    methods: {
        signOut(){
            this.$axios.post("api/signOut").then((response) => {
                if(response.data.success){
                    window.location.href = "/" // ໄປໜ້າທຳອິດ
                } else {
                    console.log(response.data.message);
                }
            }).cath(function(error){
                console.error(error);
            });
        },
		
		getProfile(){
			this.$axios.post('api/profile',{
					userid : this.signinInfo.userid		
				}).then((response) =>{
					this.images = response.data[0].images;
					this.fullname = response.data[0].fullname;
					this.name = response.data[0].name;
					this.gender = response.data[0].gender;
				}).catch((error)=>{
					console.log(error);
				})
		},

    },

    created(){

        // console.log("ສະຖານະ Login: "+window.Laravel.isLoggedin_laravel);
		// console.log(window.Laravel.user);

        if(window.Laravel.isLoggedin_laravel){
            this.isSignin = true;
            this.appClass = "main-content app-content";
            this.signinInfo = window.Laravel.user;
			this.getProfile();
        } else {
			this.isSignin = false;
            this.appClass = "";
        }
		
  }
};
</script>

<style>

    .ibox{
		width: 25px;
		text-align: center;
	}

    .mult-color{
        color: #4E5976;
    }
    .tr-hover:hover{
        background: #f9f9ff; 
    }
    .cur-pointer{
        cursor: pointer;
    }
    .search-i{
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        /* color: gray; */
    }

    .search-c:hover{
        background: #E9EBEC;
    }

    .search-c{ 
        position: absolute;
        z-index: 999;
        top: 50%;
        transform: translateY(-50%);
        right: 5px;
        width: 30px;
        height: 30px;
        color: gray;
        border-radius: 50px;
    }

	.btn-i:hover{
		background: #E9EBEC;
	}
	.btn-i{
		border-radius: 50px;
	}


</style>

