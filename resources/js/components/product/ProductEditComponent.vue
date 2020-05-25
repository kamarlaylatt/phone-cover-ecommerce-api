<template>
    <div>
        <div v-for="error in errors" :key="error.index" class="alert alert-danger" role="alert">
            {{error.errorMessage}}
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
                                Product Edit
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
                                <div class="form-group m-form__group">
                                    <label>Name</label>
                                    <input v-model="english.name" type="text" class="form-control" placeholder="Enter Name" required>
                                </div>
                                <div class="form-group m-form__group col-md-12">
                                    <label for="comment"><span class="text-danger">*</span>Short Description</label>
                                    <textarea v-model="english.short_description" class="form-control" rows="3" id="comment"></textarea>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="comment">Description</label>
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
                                        <a @click="delete_addition(index)" class="btn btn-danger"><i class="fa fa-trash" style="color:white;"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div v-if="nav_bar.general==true" class="tab-pane" id="m_tabs_1_2" role="tabpanel">
                                <div class="form-group m-form__group">
                                    <label>Name</label>
                                    <input v-model="myanmar.name" type="text" class="form-control" placeholder="Enter Name" required>
                                </div>
                                <div class="form-group m-form__group col-md-12">
                                    <label for="comment"><span class="text-danger">*</span>Short Description</label>
                                    <textarea v-model="myanmar.short_description" class="form-control" rows="3" id="comment"></textarea>
                                </div>
                                <div class="form-group m-form__group">
                                    <label for="comment">Description</label>
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
                                        <a @click="delete_addition(index)" class="btn btn-danger"><i class="fa fa-trash" style="color:white;"></i></a>
                                    </div>
                                </div>


                            </div>              
                        </div>
                        <div v-if="nav_bar.general==true" class="form-group m-form__group">
                            <button @click="add_addition" type="button" class="btn btn-primary">Add Attribues</button>
                        </div>
                    </div>

                    <div class="form-group m-form__group" v-if="nav_bar.images==true">
                        <label>Thumbnail</label>
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

                    <div class="form-group m-form__group row">
                        <div v-if="nav_bar.data==true" class="col-md-6">
                            <label>Categories</label>
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
                            <label>Code Number</label>
                            <input v-model="code_number" type="text" class="form-control" placeholder="Enter Code Number" required>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div v-if="nav_bar.data==true" class="col-md-6">
                            <label>Price</label>
                            <input v-model="price" type="number" class="form-control" placeholder="Enter Price" required>
                        </div>
                        <div v-if="nav_bar.data==true" class="col-md-6">
                            <label>Quantity</label>
                            <input v-model="quantity" type="number" class="form-control" placeholder="Enter Quantity" required>
                        </div>
                    </div>

                    <div class="form-group m-form__group row">
                        <div v-if="nav_bar.data==true" class="col-md-6">
                            <label>Minimum Order</label>
                            <input v-model="minimum_order" type="number" class="form-control" placeholder="Enter Minimum Order" required>
                        </div>
                        <div v-if="nav_bar.data==true" class="col-md-6">
                            <label>Maximum Order</label>
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
                        @click.native="update"
                        class="btn btn-success"
                        :loading="isLoading"
                        ><small>Update</small>
                        </VueLoadingButton>
                        <button @click="reset()" type="button" class="btn btn-primary">Reset</button>
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
    props: ['edit_images','categories','product','product_infos','selected_categories','product_additions','thumbnail_url'],
    
    data(){
        return{

            image: '',
            images: [],
            category_array: [],
            old_category_array: [],
            code_number: '',
            price: '',
            quantity: '',
            minimum_order: '',
            maximum_order: '',
            recommend: false,
            english: {
                id: '',
                name: '',
                short_description: '',
                description: '',
                additions: [],                
            },
            myanmar: {
                id: '',
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

            destroy:{
                images_ids: [],
                addition_ids: [],
            },

            errors: '',
            disabled_status: false,
            show_image: '/images/default.png',
            image_change_status: false,

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
        this.edit();
    },

    methods:{

        edit(){
            this.show_image = this.thumbnail_url;
            this.code_number = this.product.code_number;
            this.price = this.product.price;
            this.quantity = this.product.qty;
            this.minimum_order = this.product.min_order;
            this.maximum_order = this.product.max_order;
            this.recommend = this.product.recommend;
            this.english.id = this.product_infos[0].id;
            this.english.name = this.product_infos[0].name;
            this.english.short_description = this.product_infos[0].short_description;
            this.english.description = this.product_infos[0].description;
            this.myanmar.id = this.product_infos[1].id;
            this.myanmar.name = this.product_infos[1].name;
            this.myanmar.short_description = this.product_infos[1].short_description;
            this.myanmar.description = this.product_infos[1].description;

            for(var i=0; i<this.edit_images.length; i++)
            {
                this.images.push(this.edit_images[i]);
            }

            for(var i=0; i<this.selected_categories.length; i++)
            {
                this.category_array.push(this.selected_categories[i].id);
            }

            this.old_category_array = this.category_array;

            for(var i=0; i<this.product_additions.length; i++)
            {
                var obj= {
                    id: this.product_additions[i].id,
                    key: this.product_additions[i].key,
                    value: this.product_additions[i].value,
                    create_status: 0,
                    update_status: 1,
                };
                if(this.product_additions[i].language_id == 1)
                {
                    this.english.additions.push(obj);
                }
                else if(this.product_additions[i].language_id ==2)
                {
                    this.myanmar.additions.push(obj);
                }
            }
        },

        reset(){
            var currentUrl = window.location.pathname;
            window.location.href = currentUrl;
        },

        cancel(){
            window.location.href = '/admin/products';
            
        },

        //update button click
        update(){
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
            if(this.image_change_status == true)
            {
                formData.append('image', this.image);
            }

            for(var i=0; i<this.images.length; i++)
            {
                this.images[i].sort_no = i+1;
            }

            formData.append('images', JSON.stringify(this.images));
            formData.append('category_array', JSON.stringify(this.category_array));
            formData.append('old_category_array', JSON.stringify(this.old_category_array));
            formData.append('code_number', this.code_number);
            formData.append('price', this.price);
            formData.append('quantity', this.quantity);
            formData.append('minimum_order', this.minimum_order);
            formData.append('maximum_order', this.maximum_order);
            formData.append('recommend', this.recommend);
            formData.append('english_id', this.english.id);
            formData.append('english_name', this.english.name);
            formData.append('english_short_description', this.english.short_description);
            formData.append('english_description', this.english.description);
            formData.append('english_additions', JSON.stringify(this.english.additions));
            formData.append('myanmar_id', this.myanmar.id);
            formData.append('myanmar_name', this.myanmar.name);
            formData.append('myanmar_short_description', this.myanmar.short_description);
            formData.append('myanmar_description', this.myanmar.description);
            formData.append('myanmar_additions', JSON.stringify(this.myanmar.additions));
            formData.append('destroy_additions', JSON.stringify(this.destroy.addition_ids));
            formData.append('destroy_images', JSON.stringify(this.destroy.images_ids));

            axios.post('/admin/products/'+ this.product.id +'/update', formData, config)
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

        //extra field functions
        add_addition(){
            var eng_obj= {key: '',value: '',create_status: 1, update_status: 0};
            var myan_obj= {key: '',value: '',create_status:1, update_status:0};

            this.english.additions.push(eng_obj);
            this.myanmar.additions.push(myan_obj);
        },

        delete_addition(index){
            if(this.english.additions[index].create_status == 0)
            {
                this.destroy.addition_ids.push(this.english.additions[index].id);
                this.destroy.addition_ids.push(this.myanmar.additions[index].id);
            }
            
            this.english.additions.splice(index,1);
            this.myanmar.additions.splice(index,1);
        },

        //single photo upload functions
        onImageChange(e) {
                this.image_change_status = true;
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
        //   console.log('data', formData, index, fileList)

          this.images = fileList;
          this.images[index].update_status = 0;   
          this.images[index].create_status = 1;          
          // Upload image api
          // axios.post('http://your-url-upload', formData).then(response => {
          //   console.log(response)
          // })
        },
        
        beforeRemove (index, done, fileList) {
            
        //   console.log('index', index, fileList)
          var r = confirm("Are you sure to remove image?")
          if (r == true) {
            if(this.images[index].create_status == 0)
            {
                this.destroy.images_ids.push(this.images[index].id);
            }
            done()
          } else {
          }
        },

        editImage (formData, index, fileList) {
            //   console.log('edit data', formData, index, fileList)
            if(this.images[index].create_status == 0)
            {
                this.images[index].update_status = 1;
            }
          
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