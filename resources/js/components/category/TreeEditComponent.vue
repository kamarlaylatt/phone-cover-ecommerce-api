<template>
	<div class="container">
		<div v-for="error in errors" class="alert alert-danger" role="alert">
		  {{error.errorMessage}}
		</div>
		<el-form :model="ruleForm" status-icon  label-width="120px" class="demo-ruleForm">
		  <el-form-item label="Category" prop="checkPass">
		    <v-tree-select 
				:data="categories" 
				value-field-name="id" 
				v-model="form.category"
				text-field-name="name"
				>
					
				</v-tree-select>
		  </el-form-item>
		  <el-form-item label="Sub Category">
		    <el-input type="text" v-model="form.name"></el-input>
		  </el-form-item>
		  <el-form-item label="Description">
		    <el-input type="text" v-model="form.description"></el-input>
		  </el-form-item>
		  <el-form-item label="Image">
		    <el-input type="text" v-model="form.image"></el-input>
		  </el-form-item>
		  <el-form-item>
		    <el-button @click="create">Create</el-button>
		    <el-button @click="cancel">Cancel</el-button>
		  </el-form-item>
		</el-form>
	</div>
</template>

<script>
	export default {
		props: ['categories'],
		data(){
			return{
				form: {
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
						history.back();	
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
				history.back();
			}
		},
	}
</script>

<style type="text/css">

</style>