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
						<li class="side-item side-item-category">{{ dept }}</li>
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

                        <li class="slide" @click="employee_click">
							<router-link class="side-menu__item " :class="employee_act"  to="/test">
								<span class="side-menu__label"><i class="far fa-calendar text-center wd-20"></i><span class="mx-2">Roster</span></span>
							</router-link>
						</li>

						

                        <li class="slide" :class="infoExp" @click="infoClick()">
							<a class="side-menu__item" :class="infoAct" href="#">
								<span class="side-menu__label"><i class="fa fa-info text-center wd-20"></i><span class="mx-2">Other Info</span></span>
								<i class="angle fe fe-chevron-down"></i>
							</a>
							<ul class="slide-menu">
								<li><router-link class="slide-item" :class="alAct" @click="alClick()" to="/annualLeave">Annual Leave</router-link></li>
								<li><router-link class="slide-item" :class="leaveAct" @click="leaveClick()" to="/leaveInfo">Leave Info</router-link></li>
								<li><router-link class="slide-item" :class="transAct" @click="transClick()" to="/transport">Daily Transport</router-link></li>			
							</ul>
						</li>

						<!-- Fuel -->
                        <!-- <div v-if="fuel">
							<li class="side-item side-item-category mt-4">Fuel</li>
							<li class="slide" :class="consump_exp" @click="consump_click">
								<a class="side-menu__item" :class="consump_act" href="#">
									<span class="side-menu__label"><i class="fas fa-tachometer-alt text-center wd-20"></i><span class="mx-2">Fuel Consumption</span></span>
									<i class="angle fe fe-chevron-down"></i>
								</a>
								<ul class="slide-menu">
									<li><a class="slide-item" @click="consumpsub_click" href="#">Register</a></li>
									<li><a class="slide-item" @click="consumpsub_click" href="#">Draggablecards</a></li>
									<li><a class="slide-item" @click="consumpsub_click" href="#">Range-slider</a></li>
									<li><a class="slide-item" @click="consumpsub_click" href="#">Calendar</a></li>
								</ul>
							</li>
						</div> -->

						<!-- SHE -->
						<div v-if="sheShow">
							<!-- <li class="side-item side-item-category mt-4">Safety Dept.</li> -->

							<li class="slide">
								<a class="side-menu__item" href="#">
									<span class="side-menu__label"><i class="fa fa-fire-extinguisher text-center wd-20"></i><span class="mx-2">SHE</span></span>
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
						
						<!-- Setting -->
						<li class="slide" :class="settExp" @click="settClick()">
							<a class="side-menu__item" :class="settAct" href="#">
								<span class="side-menu__label"><i class="fa fa-cog text-center wd-20"></i><span class="mx-2">Setting</span></span>
								<i class="angle fe fe-chevron-down"></i>
							</a>
							<ul class="slide-menu">
								<li><a class="slide-item" :class="lookupAct" @click="lookupClick()" href="#">Lookup</a></li>
								<li v-if="permissShow"><router-link class="slide-item" :class="permissAct" @click="permissClick()" to="/permiss">Permission</router-link></li>
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

							<div class=" pt-2 mx-3 text-muted text-capitalize">
								<h5>{{ dept }}</h5>
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

								<li class="dropdown main-profile-menu nav nav-item nav-link p-0">
									<a class="profile-user d-flex pt-2" href="">
										<p class="pt-2 me-2 text-muted text-capitalize">{{ fullname }}</p>
										<img alt="" v-if="photo" :src="'assets/img/profile/'+ photo">
										<img alt="" v-if="!photo && gender == 'Male'" src="assets/img/male.png">
										<img alt="" v-if="!photo && gender != 'Male'" src="assets/img/female.png">
									</a>
									
									<div class="dropdown-menu">
										<div class="main-header-profile bg-primary p-3">
											<div class="d-flex wd-100p">
												<div v-if="photo" class="main-img-user"><img alt="" :src="'assets/img/profile/'+ photo"></div>
												<div v-if="!photo && gender == 'Male'" class="main-img-user"><img alt="" src="assets/img/male.png"></div>
												<div v-if="!photo && gender != 'Male'" class="main-img-user"><img alt="" src="assets/img/female.png"></div>											
												<div class="ms-3 my-auto">
													<h6 class="text-capitalize text-white">{{ username }}</h6>
													<span class="text-capitalize"> User Type: {{ usertype }}</span>
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
            isSignin: false
            ,appClass: ''
			,name: ''
			,fullname: ''
			,gender: ''
			,photo: ''
			,usertype: ''
			,username: ''
			,dept: ''
			,fuel: true
			,safety: true

			,homeAct: ''
			,empAct: ''
			,infoAct: ''
			,settAct: ''
			,alAct: ''
			,leaveAct: ''
			,transAct: ''
			,lookupAct: ''
			,permissAct: ''

			,settExp: ''
			,infoExp: ''

			,sheShow: ''
			,miniShow: ''
			,permissShow: ''
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

		infoClick(){
			if (this.infoExp){
				this.infoExp = '';
			} else {
				this.settExp = '';
				this.infoExp = 'is-expanded';
			}
		},

		settClick(){
			if (this.settExp){
				this.settExp = '';
			} else {
				this.infoExp = '';
				this.settExp ='is-expanded';
			}
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

			this.infoExp = '';
			this.settExp = '';
		},
		// getProfile(){
		// 	this.$axios.post('api/profile'
		// 		).then((response) =>{
		// 			this.fullname = response.data.fullname;
		// 			this.name = response.data.name;
		// 			this.gender = response.data.gender;
		// 			this.usertype = response.data.usertype;
		// 			this.username = response.data.username;
		// 			this.photo = response.data.photo;
		// 			this.dept = response.data.dept;
		// 		}).catch((error)=>{
		// 			console.log(error);
		// 		})
		// },

		async getProfile(){
			const res = await axios.post('api/profile')


				this.fullname = res.data[0].fullname;
				this.name = res.data[0].name;
				this.gender = res.data[0].gender;
				this.username = res.data[0].username;
				this.photo = res.data[0].photo;
				this.dept = res.data[0].department;
				this.sheShow = Boolean(res.data[0].she);
				this.miniShow = Boolean(res.data[0].mini);
				this.permissShow = Boolean(res.data[0].permiss);





				// if (this.usertype == 'full'){
				// 	this.dept = 'All Department';
				// 	this.fuel = true;
				// 	this.safety = true;
				// } else {
				// 	if (this.dept == 'Risk'){
				// 		this.safety = true;
				// 		this.fuel = false;
				// 	} else if (this.dept == 'Mining'){
				// 		this.fuel = true;
				// 	}
				// }

				console.log("Profile-->", res.data);

		}
    },

    created(){

        // console.log("ສະຖານະ Login: "+window.Laravel.isLoggedin_laravel);
		// console.log(window.Laravel.user);

        if(window.Laravel.isLoggedin_laravel){
            this.isSignin = true;
            this.appClass = "main-content app-content";
			this.homeAct = 'active';
			this.getProfile();
        } else {
			this.isSignin = false;
            this.appClass = '';
        }
		
  }
};
</script>

<style src="@vueform/multiselect/themes/default.css">


</style>

