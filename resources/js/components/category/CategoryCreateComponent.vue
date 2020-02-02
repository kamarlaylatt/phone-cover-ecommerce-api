<template>
	<div class="container">
		<div v-for="error in errors" :key="error" class="alert alert-danger" role="alert">
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
					<label>Sub Category</label>
					<input v-model="form.name" type="text" class="form-control" placeholder="Enter Sub Category">
				</div>
				<div class="form-group m-form__group">
                    <label for="comment">Description:</label>
                    <textarea v-model="form.description" class="form-control" rows="5" id="comment"></textarea>
                </div>
				<div class="form-group m-form__group">
					<label>Image</label>
					<input v-model="form.image" type="text" class="form-control" placeholder="Enter Image">
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

				errors: '',
			};
		},

		mounted()
		{
			this.form.category = this.categories[0].id;
		},

		methods:{
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
						this.errors = response.data.errors;		
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