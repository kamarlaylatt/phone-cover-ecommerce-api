<template>
	<div class="container">
		<div v-for="error in errors" :key="error.index" class="alert alert-danger" role="alert">
			{{error.errorMessage}}
		</div>
		<!--begin::Form-->
        <form class="m-form m-form--fit m-form--label-align-right">
		<div class="m-portlet__body">
			<div class="form-group m-form__group">
				<label>Parent</label>
				<v-tree-select 
				:data="categories" 
				value-field-name="id" 
				v-model="form.category"
				text-field-name="name"
				>						
				</v-tree-select>
			</div>
			
			<div class="form-group m-form__group">
				<label>Image</label>
				<div class="col-md-3" v-if="form.image">
					<img :src="form.image" class="img-responsive" height="120" width="120">
				</div>
				<div class="col-md-6">
					<input type="file" v-on:change="onImageChange">
				</div>
			</div>
		</div>
		<div class="m-portlet">			
			<div class="m-portlet__body">
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" data-toggle="tab" href="#" data-target="#m_tabs_1_1">English</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" data-toggle="tab" href="#m_tabs_1_3">Myanmar</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="m_tabs_1_1" role="tabpanel">
						<div class="form-group m-form__group">
							<label>Sub Category</label>
							<input v-model="form.name" type="text" class="form-control" placeholder="Enter Sub Category">
						</div>
						<div class="form-group m-form__group">
							<label for="comment">Description:</label>
							<textarea v-model="form.description" class="form-control" rows="5" id="comment"></textarea>
						</div>
					</div>
					<div class="tab-pane" id="m_tabs_1_2" role="tabpanel">
						It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more
						recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
					</div>
					<div class="tab-pane" id="m_tabs_1_3" role="tabpanel">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
						specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged
					</div>
					<div class="tab-pane" id="m_tabs_1_4" role="tabpanel">
						Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type
						specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
						industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and
					</div>
				</div>
			</div>
		</div>	
            
		<div class="m-portlet__foot m-portlet__foot--fit">
			<div class="m-form__actions">
				<button type="button" @click="create" class="btn btn-danger">Create</button>
					<button type="button" @click="cancel" class="btn btn-outline-danger">Cancel</button>
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
					name: '',
					category: '',
					description: '',
					image: '',
				},

				image:'',

				errors: '',
				hasImage: false,
			};
		},

		components: {
			ImageUploader
		},

		mounted()
		{
			this.form.category = this.categories[0].id;
		},

		methods:{
			onImageChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                this.createImage(files[0]);					
			},

			createImage(file) {
                let reader = new FileReader();
                let vm = this;
                reader.onload = (e) => {
                    vm.form.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
			
			create()
			{				
				axios.post('/admin/categories/store', this.form)
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