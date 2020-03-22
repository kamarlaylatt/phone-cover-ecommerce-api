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
								Category Create
							</h3>
						</div>
					</div>
				</div>
				<div class="m-portlet__body">
					<div class="form-group m-form__group">
						<label>Parent Category</label>
						<v-tree-select 
						:data="categories" 
						value-field-name="id" 
						v-model="form.parent"
						text-field-name="name"
						>						
						</v-tree-select>
					</div>
					
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
									<label>Category</label>
									<input v-model="form.english.name" type="text" class="form-control" placeholder="Enter Sub Category" required>
								</div>
								<div class="form-group m-form__group">
									<label for="comment">Description:</label>
									<textarea v-model="form.english.description" class="form-control" rows="5" id="comment"></textarea>
								</div>
							</div>
							<div class="tab-pane" id="m_tabs_1_2" role="tabpanel">
								<div class="form-group m-form__group">
									<label>Category</label>
									<input v-model="form.myanmar.name" type="text" class="form-control" placeholder="Enter Sub Category" required>
								</div>
								<div class="form-group m-form__group">
									<label for="comment">Description:</label>
									<textarea v-model="form.myanmar.description" class="form-control" rows="5" id="comment"></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>		
				
				<div class="m-portlet__foot m-portlet__foot--fit">
					<div class="m-form__actions text-center">
						<button v-if="disabled_status==false" type="button" @click="create" class="btn btn-success">Create</button>
						<button v-if="disabled_status==true" type="button" disabled @click="create" class="btn btn-success">Create</button>
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
	export default {
		props: ['categories'],
		data(){
			return{
				form: {
					id: '',
					parent: 1,
					image: '',
					english: {
						name: '',
						description: '',
						language_id: 1,
					},
					myanmar: {
						name: '',					
						description: '',
						language_id: 2,
					},										
				},

				image:'/images/default.png',

				errors: '',
				hasImage: false,
				disabled_status: false,
			};
		},

		components: {
			ImageUploader
		},

		mounted()
		{
			this.form.parent = this.categories[0].id;
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
				this.disabled_status = true;
				
				let formData = new FormData();
				let config = {
									headers: {
										'Content-Type': 'multipart/form-data'
									}
								};
				formData.append('image', this.form.image);
				formData.append('parent', this.form.parent);
				formData.append('english_name', this.form.english.name);
				formData.append('english_description', this.form.english.description);
				formData.append('english_language_id', this.form.english.language_id);
				formData.append('myanmar_name', this.form.myanmar.name);
				formData.append('myanmar_description', this.form.myanmar.description);
				formData.append('myanmar_language_id', this.form.myanmar.language_id);

				axios.post('/admin/categories/store', formData, config)
				.then(response=> {
					if(response.data.validation == true)
					{
						setTimeout(()=>{

						},2000)
						var currentUrl = window.location.pathname;
						// window.location.href = currentUrl;
						window.location.href = '/admin/categories';
					}
					else{
						window.scrollTo(0,0);
						this.errors = response.data.errors;		
						setTimeout(()=>{
							this.errors = '';
						},2000)
						this.disabled_status = false;				
					}
					
				});
				
			},

			setImage(output)
			{
				this.hasImage = true;
      			this.form.image = output.info.name;
			},


			cancel()
			{
				window.location.href = '/admin/categories';
			}
		},
	}
</script>

<style type="text/css">

</style>