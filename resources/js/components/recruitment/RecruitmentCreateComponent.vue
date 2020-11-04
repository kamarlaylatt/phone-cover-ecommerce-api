<template>
	<div class="container" style="max-width:800px">
		<div v-for="error in errors" :key="error.index" class="alert alert-danger" role="alert">
			{{error.errorMessage}}
		</div>
		<!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right">
			<div class="m-portlet">	
				<div class="m-portlet__head">
					<div class="m-portlet__head-caption">
						<div class="m-portlet__head-title">
							<span class="m-portlet__head-icon m--hide">
								<i class="la la-gear"></i>
							</span>
							<h3 class="m-portlet__head-text">
								Recruitment Create
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="form-group m-form__group">
						<label>Image</label>
						<div class="col-md-3" v-if="image">
							<img :src="image" class="img-rounded img-thumbnail" height="120" width="120">
						</div>
						<div class="col-md-6">
							<input type="file" ref="file" v-on:change="onImageChange">
						</div>
					</div>
                    <div class="form-group m-form__group">
                        <label>Sort Index</label>
                        <input v-model="form.sort_index" type="number" class="form-control" placeholder="Enter Sort Index" required>
                    </div>
                    
					<div class="form-group m-form__group">
						<ul class="nav nav-tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#" data-target="#m_tabs_1_1">English</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#m_tabs_1_2">Myanmar</a>
							</li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="m_tabs_1_1" role="tabpanel">
								<div class="form-group m-form__group">
									<label>Title</label>
									<input v-model="form.english.title" type="text" class="form-control" placeholder="Enter Title" required>
								</div>
								<div class="form-group m-form__group">
									<label for="comment">Description:</label>
                                    <!-- <br><small>Use Shitf+Enter for Line Breaking</small> -->
                                    <vue-editor useCustomImageHandler class="quill-editor" @image-added="handleImageAdded" :editorOptions="editorSettings" v-model="form.english.description" />					
                                    <!-- <ckeditor class="form-control" :editor="editor" v-model="form.english.description" :config="editorConfig"></ckeditor> -->
									<!-- <textarea v-model="form.english.description" class="form-control" rows="5" id="comment"></textarea> -->
								</div>
							</div>
							<div class="tab-pane" id="m_tabs_1_2" role="tabpanel">
								<div class="form-group m-form__group">
									<label>Title</label>
									<input v-model="form.myanmar.title" type="text" class="form-control" placeholder="Enter Title" required>
								</div>
								<div class="form-group m-form__group">
									<label for="comment">Description:</label>
                                    <vue-editor class="quill-editor" :editorOptions="editorSettings" v-model="form.myanmar.description" />					
                                    <!-- <ckeditor class="form-control" :editor="editor" v-model="form.myanmar.description" :config="editorConfig"></ckeditor> -->
									<!-- <textarea v-model="form.myanmar.description" class="form-control" rows="5" id="comment"></textarea> -->
								</div>
							</div>
						</div>
					</div>
				</div>		
				
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions text-center">
						<VueLoadingButton 
                        @click.native="create"
                        class="btn btn-success"
                        :loading="isLoading"
                        ><small>Create</small>
                        </VueLoadingButton>
						<button type="button" @click="cancel" class="btn btn-danger">Cancel</button>
					</div>
				</div>
			</div>
        </form>

        <!--end::Form-->
	</div>
</template>

<script>
import ImageUploader from 'vue-image-upload-resize'
import VueLoadingButton from 'vue-loading-button';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { VueEditor,Quill } from "vue2-editor";
import ImageResize from "quill-image-resize-vue";
import VideoResize from 'quill-video-resize-module';
Quill.register("modules/imageResize", ImageResize);
Quill.register("modules/videoResize", VideoResize);

export default {
	props: ['base_url'],
    data(){
        return{
            editorSettings: {
                modules: {
                // imageDrop: true,
                imageResize: {},
                videoResize: {}
                }
            },
            form: {
                id: '',
                image: '',
                sort_index: '',
                english: {
                    title: '',
                    description: '',
                    language_id: 1,
                },
                myanmar: {
                    title: '',					
                    description: '',
                    language_id: 2,
                },										
            },

            editor: ClassicEditor,
            editorConfig: {
                toolbar: {
                    items: [
                        'bold',
                        'italic',
                        'link',
                        'undo',
                        'redo',
                        'copy',
                        'Strike',
                    ]
                }
            },

            image: this.base_url+'/images/default.png',

            errors: '',
            hasImage: false,
            isLoading: false,
        };
    },

    components: {
			ImageUploader,VueLoadingButton,VueEditor
	},

    methods:{
        onImageChange(e) {
            this.form.image = this.$refs.file.files[0];

            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return;
            this.createImage(files[0]);					
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },

        create()
        {
            this.isLoading = true;
            
            let formData = new FormData();
            let config = {
                                headers: {
                                    'Content-Type': 'multipart/form-data'
                                }
                            };
            formData.append('image', this.form.image);
            formData.append('sort_index', this.form.sort_index);
            formData.append('english_title', this.form.english.title);
            formData.append('english_description', this.form.english.description);
            formData.append('myanmar_title', this.form.myanmar.title);
            formData.append('myanmar_description', this.form.myanmar.description);

            axios.post('/admin/recruitments', formData, config)
            .then(response=> {
                if(response.data.validation == true)
                {
                    setTimeout(()=>{

                    },2000)
                    // var currentUrl = window.location.pathname;
                    // window.location.href = currentUrl;
                    window.location.href = this.base_url+'/admin/recruitments';
                }
                else{
                    window.scrollTo(0,0);
                    this.errors = response.data.errors;	
                    console.log(this.errors)
                    setTimeout(()=>{
                        this.errors = '';
                    },2000)
                    this.isLoading = false;					
                }
                
            });
            
        },

        cancel()
        {
            window.location.href = this.base_url+'/admin/recruitments';
        },

        handleImageAdded(file, Editor, cursorLocation, resetUploader) 
        {
            // An example of using FormData
            // NOTE: Your key could be different such as:
            // formData.append('file', file)

            var formData = new FormData();
            formData.append("image", file);

            axios({
                url: this.base_url+"/admin/image-upload",
                method: "POST",
                data: formData
            })
            .then(response => {
            let url = result.data.data.img_url; // Get url from response
            Editor.insertEmbed(cursorLocation, "image", url);
            resetUploader();
            })
            .catch(err => {
            console.log(err);
            });
        }
    }
}
</script>

<style>
  .ck-editor__editable {
    min-height: 300px;
   }

   .quill-editor iframe {
        pointer-events: none;
    }
</style>