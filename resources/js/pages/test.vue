<template>
    <div class="card mt-4">
        <div class="card-body">
            


            <!-- Button trigger modal -->
            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                Launch static backdrop modal
            </button> -->
            <button type="button" class="btn btn-primary" @click="BtPay">
                Launch static backdrop modal
            </button>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <!-- <h5 class="modal-title" id="staticBackdropLabel">Sign In</h5> -->
                            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                            <h6 class="modal-title">Basic Modal</h6>
                            <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>

                        </div>

                        <div class="modal-body">
                            
                            <div class="form-group">
                                <label class="mb-0">Work Hours</label>
                                <input type="text" class="form-control" placeholder="name" v-model="insertData.name">
                            </div>
                            <div class="form-group">
                                <label class="mb-0">Work Hours</label>
                                <input type="text" class="form-control" placeholder="surame" v-model="insertData.surname">
                            </div>
                            <div class="form-group">
                                <label class="mb-0">Work Hours</label>
                                <input type="text" class="form-control" placeholder="name lao" v-model="insertData.nameLao">
                            </div>
                            <div class="form-group">
                                <label class="mb-0">Work Hours</label>
                                <input type="text" class="form-control" placeholder="surname lao" v-model="insertData.surnameLao">
                            </div>




                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" @click="insertName()">Insert Data</button>
                        </div>
                    </div>
                </div>
            </div>




            <!-- <div class="col-md-3">
                <img :src="imagePreview" alt="">
                <input type="file" @change="onSeclected" class="mt-2" >
            </div> -->

            <div style="height: 200px; width: 100%;">
                <img class="cur-pointer" style="width: 160px; height: 200px; border: solid 1px #cccc;" title="Choose an Image" :src="imagePreview" alt="" @click="chooseImage">
                <!-- <img class="cur-pointer" style="width: 160px; height: 200px; border: solid 1px #cccc;" title="Choose an Image" src="assets/img/no2.jpg" @click="chooseImage"> -->
                <input class="d-none" ref="fileInput" type="file" @change="onSeclected">
            </div> 


            <button class="mt-5" @click="addFile()">Add File</button>


            {{ addData }}
            <div class="table-responsive mt-5">
                <table class="table-hover mb-0 text-md-nowrap bd-gray-100 bd-1">
                    <thead>
                        <tr>

                            <th class="w-20 bd-1 bd-gray-100">ID</th>
                            <th class="bd-1 bd-gray-100">User ID</th>
                            <th class="bd-1 bd-gray-100">File</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13px">
                        <tr class="bd-1 bd-gray-100" v-for="list in fileData" :key="list.id">

                            <td> {{ list.id }} </td>
                            <td class="bd-1 bd-gray-100 py-1 px-3"> {{ list.userid}} </td>
                            <td class="bd-1 bd-gray-100 py-1 px-3"> {{ list.files}} </td>

                            <!-- <td>
                                <a class="ms-4" href="#" @click="download(list.files)">Download</a>
                            </td> -->

                            <td>
                                <a href="#" @click="download(list.files)"> <i class="fe fe-download ms-4"></i></a>
                                <a href="#" @click="deleteFile(list.files)"> <i class="fe fe-trash-2 ms-4"></i></a>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                <input type="file" @change="imageChange" name="image" ref="files" multiple/>
            </div>

            <!-- <div class="m-auto">
                <p v-for="(image,index) in images" :key="index">{{ image.name }}</p>
            </div> -->

            <div>
                <button @click="uploadImages">Upload</button>
            </div>



                <!-- <div class="table-responsive mg-t-25">
                    <table class="table main-table-reference table-hover text-nowrap mg-b-0 mg-t-10">
                        <thead>
                            <tr>
                                <th class="wd-30p" style="letter-spacing: 0px">Class</th>
                                <th class="wd-70p" style="letter-spacing: 0px">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 4px 10px">1</td>
                                <td style="padding: 4px 10px">Add border in all sides of an element using default color and width.</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Add border to top side of element.</td>
                            </tr>
                            
                        </tbody>
                    </table>
                </div> -->

            <!-- <i class="fa fa-minus-circle cursor-pointer text-warning"></i>
            <i class="fa fa-plus-circle cursor-pointer text-info"></i> |  
            <i class="fa fa-times-circle cursor-pointer text-danger"></i>
            <i class="fa fa-edit cursor-pointer text-warning mb-5"></i>

            <div class=" pos-relative">
                <button class="btn btn-icon btn-sm btn-i">
                    
                    <i class="fa fa-plus-circle cur-pointer text-primary"></i></button>
            </div> -->

            <!-- <td class="text-center">
                <span class="label text-danger d-flex">
                    <div class="dot-label bg-danger me-1"></div> banned
                </span>
            </td>
                

            <div class="main-header-message ">
                <span class=" pulse-danger"></span>
            </div> -->


            <div>
                <button class="btn btn-icon btn-sm btn-i wd-30 ht-30" data-bs-toggle="dropdown">
                    <i class="mdi mdi-dots-vertical"></i>
                </button>
                
                <div  class="dropdown-menu tx-13">
                    <div class="dropdown-item cur-pointer dddd">
                        <i class="fe fe-search me-2 dddd"></i><span class="dddd">Preview</span>
                    </div>
                    <div class="dropdown-item cur-pointer">
                        <i class="fe fe-edit me-2"></i><span>Edit</span>
                    </div>
                    <div class="dropdown-item cur-pointer">
                        <i class="fe fe-trash-2 me-2"></i><span>Delete</span>
                    </div>
		        </div>
            </div>




            <!-- <div class="dropdown">
                <button class="btn btn-primary" data-bs-toggle="dropdown"  type="button">
                    
                    <i class="fa fa-ellipsis-h ms-1   "></i>
                
                </button>

                <div  class="dropdown-menu tx-13">
                    <a class="dropdown-item" href="#">Preview</a>
                    <a class="dropdown-item" href="#">Edit</a>
                    <a class="dropdown-item" href="#">Delete</a>
                </div>

            </div> -->
	
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
            </div>

            <!-- Default switch -->
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="customSwitches1" v-model="test1" @change='$emit("input", $event.target.checked)'>
                <label class="custom-control-label" for="customSwitches1">Toggle this switch element</label>
            </div>

            <!-- <div class='form-check form-switch'>
                <input class='form-check-input' type='checkbox' id='flexSwitchCheckDefault' v-model="test1" @change='$emit("input", $event.target.checked)'>
                <label class='form-check-label' for='flexSwitchCheckDefault'>Default switch checkbox input</label>
            </div> -->

            {{ test1 }}

                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        Toggle Switches
                    </div>
                    <p class="mg-b-20">It is Very Easy to Customize and it uses in your website apllication.</p>

                    <div class="main-toggle-group-demo">
                        <div class="main-toggle on">
                            <span></span>
                        </div>
                        <div class="main-toggle main-toggle-secondary">
                            <span></span>
                        </div>
                        <div class="custom-control custom-switch">
                            <span></span>
                        </div>
                        <div class="main-toggle main-toggle-dark">
                            <span></span>
                        </div>
                    </div>
                    <div class="main-toggle-group-demo mg-t-10">
                        <div class="main-toggle on">
                            <span></span>
                        </div>
                        <div class="main-toggle main-toggle-secondary on">
                            <span></span>
                        </div>
                        <div class="main-toggle main-toggle-success on">
                            <span></span>
                        </div>
                        <div class="main-toggle main-toggle-dark on">
                            <span></span>
                        </div>
                    </div>
                </div>

            
            <div class="card-footer d-sm-flex">
                <div class="mt-2 mb-2">
                    <a href="#" class="me-3" data-bs-toggle="tooltip" title="" data-bs-original-title="Attach"><i class="bx bx-paperclip text-muted tx-22"></i></a>
                    <a href="javascript:void(0)" class="me-3" data-bs-toggle="tooltip" title="" data-bs-original-title="Link"><i class="bx bx-link text-muted tx-22"></i></a>
                    <a href="javascript:void(0)" class="me-3" data-bs-toggle="tooltip" title="" data-bs-original-title="Photos"><i class="bx bx-image text-muted tx-22"></i></a>
                    <a href="javascript:void(0)" class="me-3" data-bs-toggle="tooltip" title="" data-bs-original-title="Delete"><i class="bx bx-trash text-muted tx-22"></i></a>
                </div>
            </div>



            <a href="#"><i class="bx bxs-download tx-18" data-bs-toggle="tooltip" title="" data-bs-original-title="Downloads"></i></a>


            <div class="main-profile-social-list">
                <div class="media">
                    <div class="media-icon bg-primary-transparent text-primary">
                        <i class="icon ion-logo-github"></i>
                    </div>
                    <div class="media-body">
                        <span>Github</span> <a href="">github.com/spruko</a>
                    </div>
                </div>
                <div class="media">
                    <div class="media-icon bg-success-transparent text-success">
                        <i class="icon ion-logo-twitter"></i>
                    </div>
                    <div class="media-body">
                        <span>Twitter</span> <a href="">twitter.com/spruko.me</a>
                    </div>
                </div>

                <div class="media">
                    <div class="media-icon bg-info-transparent text-info">
                        <i class="icon ion-logo-linkedin"></i>
                    </div>
                    <div class="media-body">
                        <span>Linkedin</span> <a href="">linkedin.com/in/spruko</a>
                    </div>
                </div>

                <div class="media">
                    <div class="media-icon bg-danger-transparent text-danger">
                        <i class="icon ion-md-link"></i>
                    </div>
                    <div class="media-body">
                        <span>My Portfolio</span> <a href="">spruko.com/</a>
                    </div>
                </div>
            </div>


        <!-- <div class="main-content-left main-content-left-mail card-body">
            <a class="btn btn-primary btn-compose" href="" id="btnCompose">Compose</a>
            <div class="main-mail-menu">
                <nav class="nav main-nav-column mg-b-20">
                    <a class="nav-link" href=""><i class="bx bxs-inbox"></i> Inbox <span>18</span></a>
                    <a class="nav-link" href=""><i class="bx bx-star"></i> Starred <span>8</span></a>
                    <a class="nav-link" href=""><i class="bx bx-alarm-snooze"></i> Snoozed <span>6</span></a>
                    <a class="nav-link" href=""><i class="bx bx-bookmarks"></i> Important <span>15</span></a>
                    <a class="nav-link" href=""><i class="bx bx-send"></i> Sent Mail <span>24</span></a>
                    <a class="nav-link" href=""><i class="bx bx-edit"></i> Drafts <span>2</span></a>
                    <a class="nav-link" href=""><i class="bx bx-message-error"></i> Spam <span>32</span></a>
                    <a class="nav-link" href=""><i class="bx bx-message-square-detail"></i> Chats <span>14</span></a>
                    <a class="nav-link" href=""><i class="bx bx-folder-open"></i> All Mail <span>652</span></a>
                    <a class="nav-link" href=""><i class="bx bx-book-content"></i> Contacts <span>547</span></a>
                    <a class="nav-link" href=""><i class="bx bx-trash"></i> Trash <span>365</span></a>
                </nav>
                <label class="main-content-label main-content-label-sm">Settings</label>
                <nav class="nav main-nav-column">
                    <a class="nav-link active" href="#">Email Settings</a>
                    <a class="nav-link" href="#">Account Information</a>
                </nav>
            </div>
            </div> -->

            <!-- <button class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span class="sr-only">Loading...</span>
            </button>
            <button class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
            </button> -->


        </div>
        





    </div>
</template>

<script>
export default {
    name: 'XpplAppTest',

    data() {
        return {

            clear_mode: false,
            search: '',
            imageData:'',
            list1Data: [],
            list2Data: [],
            userId:{ id: '117'},

            insertData:{
                name: '',
                surname: '',
                nameLao: '',
                surnameLao: ''
            },

            gender: 'Male',

            imagePreview: window.location.origin + '/assets/img/no2.jpg',
            addData: {
                userid: '1010',
                images: ''
            }
            ,newData: []
            ,fileData: []
            ,images: []
            ,test1: false
            ,test2: ''
            ,btnDisabled: false
            ,test: 'pointer-events: none'
        };
    },

    mounted() {
        
    },

    methods: {
        add(event) {
            this.btnDisabled = true; // mutate data and let vue disable the element
        },

        getValue(){
            this.$axios.get('/api/test/getVal')
            .then(res => {
                this.test1 = res.data[0].value;

                console.log("------>", res.data);
            })

        },

        imageChange(){
            for (let i = 0; i < this.$refs.files.files.length; i++){
                this.images.push(this.$refs.files.files[i]);
                console.log("----->",this.images);
            }
        },

        uploadImages(){
            let formData = new FormData();
            for (let i = 0; i < this.images.length; i++){

                let file = this.images[i];
                formData.append('files[' + i + ']', file);
            }
            this.$axios.post('/api/test/images', formData, {headers:{"Content-Type": "multipart/form-date"}})
                .then(response => {
                    this.getFile();

                }).catch(error =>{
                    console.log(error);
                })
        },


        download(file){

            const url = `/api/test/download/${file}`;
            window.location.href = url;

        },

        deleteFile(file){
            this.$axios.post(`api/test/deleteFile/${file}`)
                .then(response => {
                    this.getFile();
                }).catch (err =>{
                    console.log(err);
                })
        },
        

        getFile(){
            this.$axios.get('api/test/file').then((result)=>{
                this.fileData = result.data;
            })
        },

        // onSeclected(event){
		// 		console.log(event.target.files[0]);

		// 		this.imageProduct = event.target.files[0];
		// 		let reader = new FileReader();
		// 		reader.readAsDataURL(this.imageProduct);
		// 		reader.addEventListener("load", function(){
		// 			this.imagePreview = reader.result;
		// 		}.bind(this), false);
		// },



        // addFile(){
        //     let newformData = new FormData();
        //     newformData.append('file', this.imageProduct);

		// 			this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
		// 					this.$axios.post("/api/lookup/addfile", newformData, {headers:{"Content-Type": "multipart/form-date"}})
		// 					.then((response)=>{

        //                             console.log("Done!");

									
		// 					}).catch((error)=>{
		// 						console.log(error);
		// 					})
		// 			});

        // },

        onSeclected(event){
				console.log(event.target.files[0]);

				this.addData.images = event.target.files[0];
				let reader = new FileReader();
				reader.readAsDataURL(this.addData.images);
				reader.addEventListener("load", function(){
					this.imagePreview = reader.result;
				}.bind(this), false);
		},

        addFile(){
                let newformData = new FormData();
                    newformData.append('userid', this.addData.userid)
                    newformData.append('file', this.addData.images);

					this.$axios.get("/sanctum/csrf-cookie").then((response)=>{
							this.$axios.post("/api/test/addfile", newformData, {headers:{"Content-Type": "multipart/form-date"}})
							.then((response)=>{

                                   this.getFile();

									
							}).catch((error)=>{
								console.log(error);
							})
					});

        },

        insertName(){
            this.$axios.post('api/insertName', this.insertData)
            .then((response)=>{

                if(response.data.success){
                    // alert(response.data.message);
                    $('#staticBackdrop').modal('hide');
                } else {
                    // this.showErr = true;
                    alert(response.data.message);
                }

            }).catch((err)=>{
                alert(err);
            });
        },



        getList1(){
            this.$axios.post('api/listOne', this.userId)
            .then((response)=>{
                    this.list1Data = response.data;
                    this.getList2();
            }).catch((error)=>{
                console.log(error);
            })
        },

        getList2(){
            this.$axios.post('api/listTwo', this.userId)
            .then((response)=>{
                    this.list2Data = response.data;
            }).catch((error)=>{
                console.log(error);
            })
        },






        chooseImage () {
            this.$refs.fileInput.click()
        },
        
        onSelectFile () {
            const input = this.$refs.fileInput
            const files = input.files
            if (files && files[0]) {
                const reader = new FileReader
                reader.onload = e => {
                this.imageData = e.target.result
                }
                reader.readAsDataURL(files[0])
                this.$emit('input', files[0])
            }
        },

        search_change(){
            if(this.search.length >0){
                this.clear_mode = true;
            } else {
                this.clear_mode = false;
            }
        },

        clear_click(){
            this.search = '';
            this.clear_mode = false;
        },

        BtPay(){
			$('#staticBackdrop').modal('show');
            this.insertData.name = '';
            this.insertData.surname = '';
            this.insertData.nameLao = '';
            this.insertData.surnameLao = '';
		},

      
      		async getProfile(){
			const res = await axios.post('api/profile')
                this.test2 = res.data.permission;

				console.log("Profile-->", res.data);

		}
        
    },

    created(){
        this.getFile();
        this.getValue();
        this.getProfile();
        
    
    },
};
</script>

<style>
    .search-box{
        /* position: relative; */
        padding-left: 30px;
    }
    .icon{
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: gray;
    }
    .clear{
        position: absolute;
        z-index: 999;
        top: 13px;
        right: 10px;
        color: gray;
        /* left: 50%;
        transform: translateX(-50%); */

        
    }

    .dddd:hover{
        color: blue;
        /* font-weight: bold; */
    }


</style>