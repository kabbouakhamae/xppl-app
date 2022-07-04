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
            <div class="mt-5">
                <table>
                    <thead>
                        <tr>

                            <th class="w-20">ID</th>
                            <th><span>User ID</span></th>
                            <th><span>Files</span></th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="tr-hover" v-for="list in fileData" :key="list.id">

                            <td> {{ list.id }} </td>
                            <td> {{ list.userid}} </td>
                            <td> {{ list.files}} </td>

                            <td>
                                <a class="ms-4" href="{{ `url(/download/${list.id})` }}">Download</a>
                            </td>

                            <!-- <td>
                                <a href="#" class="btn btn-sm btn-primary" v-if="btnPrev" @click="onPrev(list.user_id)">
                                    <i class="fe fe-search"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-info btn-b" v-if="btnEdit" @click="onEdit(list.user_id)">
                                    <i class="las la-pen"></i>
                                </a>
                                <a href="#" class="btn btn-sm btn-danger" v-if="btnDel" @click="onDel(list.user_id)">
                                    <i class="fe fe-trash-2"></i>
                                </a>
                            </td> -->
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-5">
                <input type="file" @change="imageChange" name="image" ref="files" multiple/>
            </div>

            <div class="m-auto">
                <p v-for="(image,index) in images" :key="index">{{ image.name }}</p>
            </div>

            <div>
                <button @click="uploadImages">Upload</button>
            </div>

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
        };
    },

    mounted() {
        
    },

    methods: {

        imageChange(){
            for (let i = 0; i < this.$refs.files.files.length; i++){
                this.images.push(this.$refs.files.files[i]);
                console.log(this.images);
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

        download(id){
                this.$axios.post(`/api/test/download/${id}`)
                .then((response)=>{

                        // this.prevData = response.data;

                }).catch((error)=>{
                    console.log(error);
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

      
        
    },

    created(){
        this.getFile();
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





</style>