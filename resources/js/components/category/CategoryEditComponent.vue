<template>
	<div class="container">
		<div v-for="error in errors" :key="error" class="alert alert-danger" role="alert">
		  {{error.errorMessage}}
		</div>
		<!--begin::Form-->
		{{obj}}
        <form class="m-form m-form--fit m-form--label-align-right">
            <div class="m-portlet__body">
                <div class="form-group m-form__group">                    
                    <label>Parent</label>
                    <v-tree-select 
					:data="categories" 
					value-field-name="id" 
					v-model="form.category"
					text-field-name="name"
					@item-click="itemClick"
					>						
					</v-tree-select>
                </div>
				<div class="form-group m-form__group">
					<label>Sub Category</label>
					<input v-model="form.name" type="text" class="form-control" placeholder="Enter Sub Category">
				</div>
                <div class="form-group m-form__group">
                    <label for="comment">Description:</label>
                    <textarea v-model="form.description" class="form-control" rows="5" id="comment"></textarea>
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
		props: ['categories','category','img_url'],
		data(){
			return{
				form: {
                    id: '',
					name: '',
					category: '',
					description: '',
					image: '',
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
                this.form.name = this.category.name;
                this.form.category = this.category.parents;
                this.form.description =this.category.description;
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