<template>
    <div>
        <!-- <div v-for="error in errors" :key="error.index" class="alert alert-danger" role="alert">
            {{error.errorMessage}}
        </div> -->
        <div v-if="errors != ''" class="alert alert-danger" role="alert">
            {{errors[0].errorMessage}}<br>
        </div>
        <div v-if="errors != ''" class="alert alert-danger" role="alert">
            {{errors[1].errorMessage}}<br>
        </div>
        <div v-if="errors != ''" class="alert alert-danger" role="alert">
            {{errors[2].errorMessage}}<br>
        </div>
        <!-- begin form -->        
        <form class="m-form m-form--fit m-form--label-align-right">
			<div class="m-portlet">	
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon m--hide">
                                <i class="la la-gear"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                Product Create
                            </h3>
                        </div>
                    </div>                  
                </div>
                <div class="m-portlet__body">
                    <div class="row form-group m-form__group mb-2">
                        <div class="m-portlet__nav-item mr-2" @click="changeNavbar('general')">
                            <a href="#" class="m-portlet__nav-link btn btn-primary m-btn m-btn--pill m-btn--air">
                                General
                            </a>
                        </div>
                        <div class="m-portlet__nav-item mr-2" @click="changeNavbar('data')">
                            <a href="#" class="m-portlet__nav-link btn btn-primary m-btn m-btn--pill m-btn--air">
                                Data
                            </a>
                        </div>
                        <div class="m-portlet__nav-item mr-2" @click="changeNavbar('images')">
                            <a href="#" class="m-portlet__nav-link btn btn-primary m-btn m-btn--pill m-btn--air">
                                Images
                            </a>
                        </div>
                    </div>
                    <div class="form-group m-form__group" v-if="nav_bar.images==true">
                        <label><span class="text-danger">*</span>Thumbnail</label>
                        <div class="col-md-3" v-if="show_image">
                            <img :src="show_image" class="img-rounded img-thumbnail" height="120" width="120">
                        </div>
                        <div class="col-md-6">
                            <input type="file" ref="file" v-on:change="onImageChange">
                        </div>
                    </div>
                    <div v-if="nav_bar.images==true" class="form-group m-form__group" id="my-strictly-unique-vue-upload-multiple-image">
                        <label>Images</label>
                        <vue-upload-multiple-image
                        @upload-success="uploadImageSuccess"
                        @before-remove="beforeRemove"
                        @edit-image="editImage"
                        :data-images="images"
                        idUpload="myIdUpload"
                        editUpload="myIdEdit"
                        dragText="Drag your photo"
                        browseText="Upload photos"
                        :maxImage="5"
                        ></vue-upload-multiple-image>
                    </div>

                    <div class="container" style="max-width:800px">
                        <ul v-if="nav_bar.general==true" class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#" data-target="#m_tabs_1_1">English</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#m_tabs_1_2">Myanmar</a>
                            </li>
                        </ul>
                        <div v-if="nav_bar.general==true" class="tab-content">
                            <div class="tab-pane active" id="m_tabs_1_1" role="tabpanel">
                                <div class="form-group m-form__group col-md-12">
                                    <label><span class="text-danger">*</span>Product Name</label>
                                    <input v-model="english.name" type="text" class="form-control t" placeholder="Enter Product Name" required>
                                </div>
                                <div class="form-group m-form__group col-md-12">
                                    <label for="comment"><span class="text-danger">*</span>Short Description</label>
                                    <textarea v-model="english.short_description" class="form-control" rows="3" id="comment"></textarea>
                                </div>
                                <div class="form-group m-form__group col-md-12">
                                    <label for="comment"><span class="text-danger">*</span>Description</label>
                                    <textarea v-model="english.description" class="form-control" rows="5" id="comment"></textarea>
                                </div>
                                <!--english addition fields -->
                                <div class="form-row form-group m-form__group mb-negative" v-for="(addition,index) in english.additions" :key="index">
                                    <div class="form-group col-4">
                                        <!-- <label>Label</label> -->
                                        <input v-model="addition.key" type="text" class="form-control" placeholder="Label" required>
                                    </div>
                                    <div class="form-group col">
                                        <!-- <label>Value</label> -->
                                        <input v-model="addition.value" type="text" class="form-control" placeholder="Value" required>
                                    </div>
                                    <div class="form-group col-1">
                                        <button @click="delete_addition(index)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div v-if="nav_bar.general==true" class="tab-pane" id="m_tabs_1_2" role="tabpanel">
                                <div class="form-group m-form__group col-md-12">
                                    <label><span class="text-danger">*</span>Product Name</label>
                                    <input v-model="myanmar.name" type="text" class="form-control" placeholder="Enter Product Name" required>
                                </div>
                                <div class="form-group m-form__group col-md-12">
                                    <label for="comment"><span class="text-danger">*</span>Short Description</label>
                                    <textarea v-model="myanmar.short_description" class="form-control" rows="3" id="comment"></textarea>
                                </div>
                                <div class="form-group m-form__group col-md-12">
                                    <label for="comment"><span class="text-danger">*</span>Description</label>
                                    <textarea v-model="myanmar.description" class="form-control" rows="5" id="comment"></textarea>
                                </div>
                                <!--myanmar addition fields -->
                                <div class="form-row m-form__group mb-negative" v-for="(addition,index) in myanmar.additions" :key="index">
                                    <div class="form-group col-4">
                                        <!-- <label>Label</label> -->
                                        <input v-model="addition.key" type="text" class="form-control" placeholder="Label" required>
                                    </div>
                                    <div class="form-group col">
                                        <!-- <label>Value</label> -->
                                        <input v-model="addition.value" type="text" class="form-control" placeholder="Value" required>
                                    </div>
                                    <div class="form-group col-1">
                                        <button @click="delete_addition(index)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>


                            </div>              
                        </div>
                        <div v-if="nav_bar.general==true" class="form-group m-form__group">
                            <button @click="add_addition" type="button" class="btn btn-primary">Add Attribues</button>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div v-if="nav_bar.data==true" class="col-md-6">
                        <label><span class="text-danger">*</span>Categories</label>
                        <treeselect 
                            v-model="category_array" 
                            :multiple="true" 
                            :options="categories" 
                            :normalizer="normalizer" 
                            :flat="true"
                            :required="true"
                        />
                        </div>

                        <div v-if="nav_bar.data==true" class="col-md-6">
                            <label><span class="text-danger">*</span>Code Number</label>
                            <input v-model="code_number" type="text" class="form-control" placeholder="Enter Code Number" required>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div v-if="nav_bar.data==true" class="col-md-6">
                            <label><span class="text-danger">*</span>Price</label>
                            <input v-model="price" type="number" class="form-control" placeholder="Enter Price" required>
                        </div>
                        <div v-if="nav_bar.data==true" class="col-md-6">
                            <label><span class="text-danger">*</span>Quantity</label>
                            <input v-model="quantity" type="number" class="form-control" placeholder="Enter Quantity" required>
                        </div>
                    </div>
                    
                    <div class="form-group m-form__group row">
                        <div v-if="nav_bar.data==true" class="col-md-6">
                            <label><span class="text-danger">*</span>Minimum Order</label>
                            <input v-model="minimum_order" type="number" class="form-control" placeholder="Enter Minimum Order" required>
                        </div>
                        <div v-if="nav_bar.data==true" class="col-md-6">
                            <label><span class="text-danger">*</span>Maximum Order</label>
                            <input v-model="maximum_order" type="number" class="form-control" placeholder="Enter Maximum Order" required>
                        </div>
                    </div>
                    <div v-if="nav_bar.data==true" class="m-form__group form-check ml-4">
                        <input v-model="recommend" type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Recommend</label>
                    </div>               
                </div>
                <div class="m-portlet__foot m-portlet__foot--fit">
                    <div class="m-form__actions">					
                        <VueLoadingButton 
                        @click.native="create"
                        class="btn btn-success"
                        :loading="isLoading"
                        ><small>Create</small>
                        </VueLoadingButton>
                        <button @click="cancel()" type="button" class="btn btn-danger">Cancel</button>
                    </div>
                </div>
			</div>
        </form>
    </div>
</template>

<script>
import VueLoadingButton from 'vue-loading-button';
import VueUploadMultipleImage from 'vue-upload-multiple-image'
import Treeselect from '@riophae/vue-treeselect'
import '@riophae/vue-treeselect/dist/vue-treeselect.css'
export default {
    props: ['categories'],
    
    data(){
        return{

            image: '',
            images: [],
            category_array: null,
            code_number: '',
            price: '',
            quantity: '',
            minimum_order: '',
            maximum_order: '',
            recommend: false,
            english: {
                name: '',
                short_description: '',
                description: '',
                additions: [],                
            },
            myanmar: {
                name: '',
                short_description: '',
                description: '',
                additions: [],
            },

            nav_bar: {
                data: false,
                general: true,
                images: false,
            },


            errors: '',
            disabled_status: false,
            show_image: '/images/default.png',

             normalizer(node) {
              return {
                id: node.id,
                label: node.name,
                children: node.children,
                isDisabled: node.isDisabled,
              }
            },

            isLoading: false,
            
        };
    },

    components: {
        VueUploadMultipleImage,Treeselect,VueLoadingButton,
      },

    mounted()
    {

    },

    methods:{

        //create button click
        create(){
            this.isLoading = true;
            let formData = new FormData();
                let config = {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            };

            if(this.recommend == false)
            {
                this.recommend = 0;
            }
            else
            {
                this.recommend = 1;
            }

            formData.append('image', this.image);
            formData.append('images', JSON.stringify(this.images));
            formData.append('category_array', JSON.stringify(this.category_array));
            formData.append('code_number', this.code_number);
            formData.append('price', this.price);
            formData.append('quantity', this.quantity);
            formData.append('minimum_order', this.minimum_order);
            formData.append('maximum_order', this.maximum_order);
            formData.append('recommend', this.recommend);
            formData.append('english_name', this.english.name);
            formData.append('english_short_description', this.english.description);
            formData.append('english_description', this.english.description);
            formData.append('english_additions', JSON.stringify(this.english.additions));
            formData.append('myanmar_name', this.myanmar.name);
            formData.append('myanmar_short_description', this.myanmar.description);
            formData.append('myanmar_description', this.myanmar.description);
            formData.append('myanmar_additions', JSON.stringify(this.myanmar.additions));

            axios.post('/admin/products/store', formData, config)
            .then(response=> {
                if(response.data.validation == true)
                {
                    setTimeout(()=>{

                    },2000)
                    var currentUrl = window.location.pathname;
                    // window.location.href = currentUrl;
                    window.location.href = '/admin/products';
                }
                else{
                    window.scrollTo(0,0);
                    this.errors = response.data.errors;     
                    setTimeout(()=>{
                        this.errors = '';
                    },2000)
                    this.isLoading = false;               
                }
                
            });
        },

        cancel()
        {
            window.location.href = '/admin/products';

        },

        //extra field functions
        add_addition(){
            var eng_obj= {key: '',value: ''};
            var myan_obj= {key: '',value: ''};

            this.english.additions.push(eng_obj);
            this.myanmar.additions.push(myan_obj);
        },

        delete_addition(index){
            this.english.additions.splice(index,1);
            this.myanmar.additions.splice(index,1);
        },

        //single photo upload functions
        onImageChange(e) {
                this.image = this.$refs.file.files[0];

                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);                 
            },

            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.show_image = e.target.result;
                };
                reader.readAsDataURL(file);
            },

        //multiple photo upload functions
        uploadImageSuccess(formData, index, fileList) {
          console.log('data', formData, index, fileList)

          this.images = fileList;
          // Upload image api
          // axios.post('http://your-url-upload', formData).then(response => {
          //   console.log(response)
          // })
        },
        beforeRemove (index, done, fileList) {
          console.log('index', index, fileList)
          var r = confirm("remove image")
          if (r == true) {
            done()
          } else {
          }
        },
        editImage (formData, index, fileList) {
          console.log('edit data', formData, index, fileList)
        },

        changeNavbar(data)
        {
            if(data == 'general')
            {
                this.nav_bar.general = true;
                this.nav_bar.data = false;
                this.nav_bar.images = false;

            }

            if(data == 'data')
            {
                this.nav_bar.general = false;
                this.nav_bar.data = true;
                this.nav_bar.images = false;

            }

            if(data == 'images')
            {
                this.nav_bar.general = false;
                this.nav_bar.data = false;
                this.nav_bar.images = true;

            }
        }
    },
}
</script>

<style type="text/css">
    .mb-negative {
        margin-bottom: -20px !important;
    }
</style>