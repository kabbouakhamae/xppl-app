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
						<li class="side-item side-item-category"></li>
						<li class="slide" @click="homeClick()">
							<router-link class="side-menu__item " :class="homeAct"  to="/">
								<span class="side-menu__label"><i class="fa fa-home text-center wd-20"></i><span class="mx-2">Home</span></span>
							</router-link>
						</li>

                        <li class="slide " @click="empClick()">
							<router-link class="side-menu__item" :class="empAct" to="/employee">
								<span class="side-menu__label"><i class="fa fa-users text-center wd-20"></i><span class="mx-2">Employee</span></span>
								<!-- <span class="badge bg-success rounded-circle wd-15 ht-15 text-light" id="bg-side-text">1</span> -->
							</router-link>
						</li>

						<!-- Roster -->
                        <li class="slide" :class="rosExp" @click="rosClick()">
							<a class="side-menu__item" :class="rosAct" href="#">
								<span class="side-menu__label"><i class="far fa-calendar text-center wd-20"></i><span class="mx-2">Roster</span></span>
								<i class="angle fe fe-chevron-down"></i>
							</a>
							<ul class="slide-menu">
								<li><router-link class="slide-item" :class="rosPreviewAct" @click="rosPreviewClick()" to="/rospreview">Preview</router-link></li>
								<li><router-link class="slide-item" :class="rosManageAct" @click="rosManageClick()" to="/rosmanage">Manage</router-link></li>
								<li><router-link class="slide-item" :class="rosCodeAct" @click="rosCodeClick()" to="/roscode">Code</router-link></li>			
							</ul>
						</li>

						<!-- Other Info -->
                        <li class="slide" :class="infoExp" @click="infoClick()">
							<a class="side-menu__item" :class="infoAct" href="#">
								<span class="side-menu__label"><i class="fa fa-info text-center wd-20"></i><span class="mx-2">Other Info</span></span>
								<i class="angle fe fe-chevron-down"></i>
							</a>
							<ul class="slide-menu">
								<li><router-link class="slide-item" :class="alAct" @click="alClick()" to="/annual">Annual Leave</router-link></li>
								<li><router-link class="slide-item" :class="leaveAct" @click="leaveClick()" to="/leaveinfo">Leave Info</router-link></li>
								<li><router-link class="slide-item" :class="transAct" @click="transClick()" to="/transport">Daily Transport</router-link></li>			
							</ul>
						</li>

						<!-- Fuel -->
						<div v-if="!!parseInt(permiss.fuel)">
							<li class="slide" :class="fuelExp" @click="fuelClick()">
								<a class="side-menu__item" :class="fuelAct" href="#">
									<span class="side-menu__label"><i class="fa fa-tint text-center wd-20"></i><span class="mx-2">Fuels</span></span>
									<i class="angle fe fe-chevron-down"></i>
								</a>
								<ul class="slide-menu">
									<li><router-link class="slide-item" :class="fuelConsAct" @click="fuelConsClick()" to="/fuelcons">Reservation</router-link></li>
									<li><router-link class="slide-item" :class="fuelReportAct" @click="fuelReportClick()" to="/fuelreport">Report</router-link></li>
									<li><router-link class="slide-item" :class="fuelLookup_act" @click="fuelLookup()" to="/fuellookup">Lookup</router-link></li>
								</ul>
							</li>
						</div>

						<!-- Safety -->
						<div v-if="!!parseInt(permiss.safety)">
							<!-- <li class="side-item side-item-category mt-4">Safety Dept.</li> -->
							<li class="slide">
								<a class="side-menu__item" href="#">
									<span class="side-menu__label"><i class="fa fa-fire-extinguisher text-center wd-20"></i><span class="mx-2">Safety</span></span>
									<i class="angle fe fe-chevron-down"></i>
								</a>
								<ul class="slide-menu">
									<li><a class="slide-item" href="#">Register</a></li>
									<li><a class="slide-item" href="#">Draggablecards</a></li>
									<li><a class="slide-item" href="#">Range-slider</a></li>
									<li><a class="slide-item" href="#">Calendar</a></li>
								</ul>
							</li>
						</div>

						<!-- Addmin Car Rental -->
						<div v-if="!!parseInt(permiss.car_acc)">
							<li class="slide" :class="carRent_exp" @click="carRent()">
								<a class="side-menu__item" :class="carRent_act" href="#">
									<span class="side-menu__label"><i class="fas fa-taxi text-center wd-20"></i><span class="mx-2">Car Rentals</span></span>
									<i class="angle fe fe-chevron-down"></i>
								</a>
								<ul class="slide-menu">
									<li><router-link class="slide-item" :class="carRentDetal_act" @click="carRentDetail()" to="/carrentdetail">Rental Detail</router-link></li>
									<li><router-link class="slide-item" :class="carRentReport_act" @click="carRentReport()" to="/carrentreport">Report</router-link></li>
									<li><router-link class="slide-item" :class="carRentCode_act" @click="carRentCode()" to="/carrentcode">Code</router-link></li>
								</ul>
							</li>
						</div>
						



						
						<!-- Setting -->
						<li class="slide" :class="settExp" @click="settClick()">
							<a class="side-menu__item" :class="settAct" href="#">
								<span class="side-menu__label"><i class="fa fa-cog text-center wd-20"></i><span class="mx-2">Setting</span></span>
								<i class="angle fe fe-chevron-down"></i>
							</a>
							<ul class="slide-menu">
								<li v-if="!!parseInt(permiss.lk_add)"><router-link class="slide-item" :class="lookupAct" @click="lookupClick()" to="/lookup">Lookup</router-link></li>
								<li v-if="!!parseInt(permiss.permiss)"><router-link class="slide-item" :class="permissAct" @click="permissClick()" to="/permiss">Permission</router-link></li>
							</ul>
						</li>

						<li v-if="!!parseInt(permiss.mac_acc)" class="slide " @click="macro()">
							<router-link class="side-menu__item" :class="macro_act" to="/macro">
								<span class="side-menu__label"><i class="far fa-file-excel text-center wd-20"></i><span class="mx-2">Excel Macro</span></span>
							</router-link>
						</li>

					</ul>
				</div>
			</aside>
			<!-- main-sidebar -->

			<!-- main-content -->
			<div :class="appClass">

				<!-- main-header -->
				<div class="main-header sticky side-header nav nav-item" v-if="isSignin">
					<div class="container-fluid ps-sm-0 p-2">
						<div class="main-header-left ">		
							<div class="app-sidebar__toggle" data-bs-toggle="sidebar">
								<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left"></i></a>
								<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
							</div>
							<div class="text-muted text-capitalize" style="padding-top: 9px">
								<h5>{{ profile.department }}</h5>
							</div>
						</div>
						<div class="main-header-right">
							<ul class="nav nav-item  navbar-nav-right ms-auto">
								<!-- <li class="nav-item full-screen fullscreen-button">
									<a class="new nav-link full-screen-link" href="#" title="Full screen"><svg
											xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24"
											fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
											stroke-linejoin="round">
											<path
												d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3">
											</path>
										</svg>
									</a>
								</li> -->

								<li class="dropdown main-profile-menu nav nav-item nav-link p-0">
									
										<a class="profile-user d-flex" href="">
											<div class="d-flex align-items-center">
												<span class="d-none d-sm-flex text-muted text-capitalize me-2">{{ profile.name }} {{ profile.surname }}</span>
											</div>
											<img alt="" v-if="profile.photo" :src="'assets/img/profile/'+ profile.photo">
											<img alt="" v-if="!profile.photo && profile.gender == 'Male'" src="assets/img/male.png">
											<img alt="" v-if="!profile.photo && profile.gender != 'Male'" src="assets/img/female.png">
										</a>

									
									
									<div class="dropdown-menu">
										<div class="main-header-profile bg-primary p-3">
											<div class="d-flex wd-100p">
												<div v-if="profile.photo" class="main-img-user"><img alt="" :src="'assets/img/profile/'+ profile.photo"></div>
												<div v-if="!profile.photo && profile.gender == 'Male'" class="main-img-user"><img alt="" src="assets/img/male.png"></div>
												<div v-if="!profile.photo && profile.gender != 'Male'" class="main-img-user"><img alt="" src="assets/img/female.png"></div>											
												<div class="ms-3 my-auto">
													<div class="d-flex">
														<h6 class="text-capitalize text-white">{{ profile.name }}</h6>
														<h6 class="text-capitalize text-white d-sm-none ms-2">{{ profile.surname }}</h6>
													</div>
													<span class="text-capitalize"> Username: {{ profile.username }}</span>
												</div>
											</div>
										</div>
										<a class="dropdown-item disabled" href="#"><i class="bx bx-user-circle"></i>Profile</a>
										<a class="dropdown-item disabled" href="#"><i class="bx bx-cog"></i> Edit Profile</a>
										<a class="dropdown-item disabled" href="#"><i class="bx bxs-inbox"></i>Inbox</a>
										<a class="dropdown-item disabled" href="#"><i class="bx bx-envelope"></i>Messages</a>
										<a class="dropdown-item disabled" href="#"><i class="bx bx-slider-alt"></i> Account
											Settings</a>
										<a class="dropdown-item cur-pointer" @click="signOut()"><i class="bx bx-log-out"></i> Sign out</a>
									</div>
								</li>
							</ul>
						</div>
					</div>
				</div>

				<div class="container-fluid" style="padding: 10px 10px 0px 10px">
                    <router-view></router-view>
				</div>
				<!-- <div class="container-fluid p-sm-2 p-0">
                    <router-view></router-view>
				</div> -->

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

			homeAct: '',
			empAct: '',
			infoAct: '',
			settAct: '',
			alAct: '',
			leaveAct: '',
			transAct: '',
			lookupAct: '',
			permissAct: '',

			fuelAct: '',
			fuelConsAct: '',
			fuelReportAct: '',
			fuelLookup_act: '',

			rosAct: '',
			rosPreviewAct: '',
			rosManageAct: '',
			rosCodeAct: '',

			carRent_act: '',
			carRentDetail_act: '',
			carRentReport_act: '',
			carRentCode_act: '',

			rosExp: '',
			fuelExp: '',
			infoExp: '',
			carRent_exp: '',
			settExp: '',

			profile: [],
			permiss: []
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

		homeClick(){
			this.clearAct();
			this.homeAct = 'active';
		},

		empClick(){
			this.clearAct();
			this.empAct = 'active';
		},
		
		alClick(){
			this.clearAct();
			this.infoAct = 'active';
			this.alAct = 'active';
		},

		leaveClick(){
			this.clearAct();
			this.infoAct = 'active';
			this.leaveAct = 'active';
		},

		transClick(){
			this.clearAct();
			this.infoAct = 'active';
			this.transAct = 'active';
		},

		lookupClick(){
			this.clearAct();
			this.settAct = 'active';
			this.lookupAct = 'active';
		},

		permissClick(){
			this.clearAct();
			this.settAct = 'active';
			this.permissAct = 'active';
		},

		fuelConsClick(){
			this.clearAct();
			this.fuelAct = 'active';
			this.fuelConsAct = 'active';
		},

		fuelReportClick(){
			this.clearAct();
			this.fuelAct = 'active';
			this.fuelReportAct = 'active';
		},

		fuelLookup(){
			this.clearAct();
			this.fuelAct = 'active';
			this.fuelLookup_act = 'active';
		},

		rosPreviewClick(){
			this.clearAct();
			this.rosAct = 'active';
			this.rosPreviewAct = 'active';
		},

		rosManageClick(){
			this.clearAct();
			this.rosAct = 'active';
			this.rosMangeAct = 'active';
		},

		rosCodeClick(){
			this.clearAct();
			this.rosAct = 'active';
			this.rosCodeAct = 'active';
		},

		carRentDetail(){
			this.clearAct();
			this.carRent_act = 'active';
			this.carRentDetail_act = 'active';
		},

		carRentReport(){
			this.clearAct();
			this.carRent_act = 'active';
			this.carRentReport_act = 'active';
		},

		carRentCode(){
			this.clearAct();
			this.carRent_act = 'active';
			this.carRentCode_act = 'active';
		},

		rosClick(){
			if (this.rosExp){
				this.rosExp = '';
			} else {
				this.settExp = '';
				this.infoExp = '';
				this.fuelExp = '';
				this.carRent_exp = '';
				this.rosExp = 'is-expanded';
			}
		},

		fuelClick(){
			if (this.fuelExp){
				this.fuelExp = '';
			} else {
				this.settExp = '';
				this.infoExp = '';
				this.rosExp = '';
				this.carRent_exp = '';
				this.fuelExp = 'is-expanded';
			}
		},

		infoClick(){
			if (this.infoExp){
				this.infoExp = '';
			} else {
				this.settExp = '';
				this.fuelExp = '';
				this.rosExp = '';
				this.carRent_exp = '';
				this.infoExp = 'is-expanded';
			}
		},

		carRent(){
			if (this.carRent_exp){
				this.carRent_exp = '';
			} else {
				this.settExp = '';
				this.fuelExp = '';
				this.rosExp = '';
				this.infoExp = '';
				this.carRent_exp = 'is-expanded';
			}
		},

		settClick(){
			if (this.settExp){
				this.settExp = '';
			} else {
				this.infoExp = '';
				this.fuelExp = '';
				this.rosExp = '';
				this.carRent_exp = '';
				this.settExp = 'is-expanded';
			}
		},

		macro(){
			this.clearAct();
			this.macro_act = 'active';
		},

		clearAct(){
			this.homeAct ='';
			this.empAct = '';
			this.alAct = '';
			this.leaveAct = '';
			this.transAct = '';
			this.lookupAct = '';
			this.permissAct = '';
			this.infoAct = '';
			this.settAct = '';
			this.fuelAct = '';
			this.fuelConsAct = '';
			this.fuelReportAct = '';
			this.fuelLookup_act = '';
			this.rosAct = '';
			this.rosPreviewAct = '';
			this.rosManageAct = '';
			this.rosCodeAct = '';
			this.carRent_act = '';
			this.carRentDetail_act = '';
			this.carRentReport_act = '';
			this.carRentCode_act = '';
			this.macro_act = '';

			this.fuelExp = '';
			this.infoExp = '';
			this.settExp = '';
			this.rosExp = '';
			this.carRent_exp = '';
		},

		async getProfile(){
			const response = await axios.get('api/profile')
			this.profile = response.data;
		},

		async getPermiss(){
			const response = await axios.get('api/permiss')
			this.permiss = response.data;
		},

    },

    created(){

        // console.log("ສະຖານະ Login: "+window.Laravel.isLoggedin_laravel);
		// console.log(window.Laravel.user);

        if(window.Laravel.isLoggedin_laravel){
            this.isSignin = true;
            this.appClass = "main-content app-content";
			this.homeAct = 'active';
			this.getProfile();
			this.getPermiss();
        } else {
			this.isSignin = false;
            this.appClass = '';
        }
		
  }
};
</script>

<style src="@vueform/multiselect/themes/default.css">


</style>

