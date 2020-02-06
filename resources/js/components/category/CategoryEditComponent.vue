
<template>
	<div class="container">
		<div v-for="error in errors" :key="error.index" class="alert alert-danger" role="alert">
			{{error.errorMessage}}
		</div>
		<!--begin::Form-->
		{{form}}
        <form class="m-form m-form--fit m-form--label-align-right">
			<div class="m-portlet__body">
				<div class="form-group m-form__group">
					<label>Parent</label>
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
					<div class="col-md-3">
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
				<div class="m-form__actions">
					<button type="button" @click="update" class="btn btn-danger">Update</button>
						<button type="button" @click="cancel" class="btn btn-outline-danger">Cancel</button>
				</div>
			</div>
        </form>

        <!--end::Form-->
	</div>
</template>
<script>
	export default {
		props: ['categories','category','img_url','category_infos'],
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
				image_change_status: false,
				errors: '',
				obj: '',
			};
		},

		mounted()
		{
			// this.form.category = this.categories[0].id;
			this.edit();
		},

		methods:{
			itemClick(node)
			{
				alert('hello');
				this.obj = node.model.text;
			},
            edit()
            {
                this.form.id = this.category.id;                
				this.form.parent = this.category.parents;

				this.form.english.name = this.category_infos[0].name;
				this.form.english.description =this.category_infos[0].description;
				
				this.form.myanmar.name = this.category_infos[1].name;
				this.form.myanmar.description =this.category_infos[1].description;
				
                this.form.image = this.img_url;
			},
			
			onImageChange(e) {
				this.image_change_status = true;
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

			update()
			{	
				if(this.image_change_status == false)
				{
					this.form.image= '';
				}			
				axios.post('/admin/categories/update', this.form)
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
						this.form.image = this.img_url;
						this.form.name = this.category.name;
                		this.form.category = this.category.parents;	
						setTimeout(()=>{
							this.errors = '';
						},2000)				
					}
					
				});
				
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