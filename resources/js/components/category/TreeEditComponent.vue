<template>
	<div class="container">
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
		    <el-button @click="resetForm('ruleForm')">Cancel</el-button>
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
					if(response.data.success == true)
					{
						setTimeout(()=>{

						},2000)
						var currentUrl = window.location.pathname;
						window.location.href = currentUrl;	
					}
					
				});
				
			},
		},
	}
</script>

<style type="text/css">

</style>