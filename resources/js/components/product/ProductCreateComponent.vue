<template>
    <div class="container">
        <form class="m-form m-form--fit m-form--label-align-right">
			<div class="m-portlet__body">
                <div class="form-group m-form__group">
					<label>Image</label>
					<div class="col-md-3" v-if="image">
						<img :src="image" class="img-responsive" height="120" width="120">
					</div>
					<div class="col-md-6">
						<input type="file" ref="file">
					</div>
				</div>
                <div class="form-group m-form__group">
                    <label>Price</label>
                    <input v-model="price" type="number" class="form-control" placeholder="Enter Sub Category" required>
                </div>
                <div class="form-group m-form__group">
                    <label>Quantity</label>
                    <input v-model="quantity" type="number" class="form-control" placeholder="Enter Sub Category" required>
                </div>
                <div class="form-group m-form__group">
                    <label>Minimum Order</label>
                    <input v-model="minimum_order" type="number" class="form-control" placeholder="Enter Sub Category" required>
                </div>
                <div class="form-group m-form__group">
                    <label>Maximum Order</label>
                    <input v-model="maximum_order" type="number" class="form-control" placeholder="Enter Sub Category" required>
                </div>
                <div class="m-form__group form-check ml-4">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Recommand</label>
                </div>
			</div>

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
                        <label>Name</label>
                        <input v-model="english.name" type="text" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group m-form__group">
                        <label for="comment">Description</label>
                        <textarea v-model="english.description" class="form-control" rows="5" id="comment"></textarea>
                    </div>
                    <!--english addition fields -->
                    <div class="form-row form-group m-form__group mb-negative" v-for="(addition,index) in english.additions" :key="addition">
                        <div class="form-group col-4">
                            <!-- <label>Label</label> -->
                            <input v-model="addition.key" type="text" class="form-control" placeholder="Label" >
                        </div>
                        <div class="form-group col">
                            <!-- <label>Value</label> -->
                            <input v-model="addition.value" type="text" class="form-control" placeholder="Value" >
                        </div>
                        <div class="form-group col-1">
                            <button @click="delete_addition(index)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="m_tabs_1_2" role="tabpanel">
                    <div class="form-group m-form__group">
                        <label>Name</label>
                        <input v-model="myanmar.name" type="text" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group m-form__group">
                        <label for="comment">Description</label>
                        <textarea v-model="myanmar.description" class="form-control" rows="5" id="comment"></textarea>
                    </div>
                    <!--myanmar addition fields -->
                    <div class="form-row m-form__group mb-negative" v-for="(addition,index) in myanmar.additions" :key="addition">
                        <div class="form-group col-4">
                            <!-- <label>Label</label> -->
                            <input v-model="addition.key" type="text" class="form-control" placeholder="Label" >
                        </div>
                        <div class="form-group col">
                            <!-- <label>Value</label> -->
                            <input v-model="addition.value" type="text" class="form-control" placeholder="Value" >
                        </div>
                        <div class="form-group col-1">
                            <button @click="delete_addition(index)" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </div>
                    </div>


                </div>              
            </div>
            <div class="form-group m-form__group">
                <button @click="add_addition" type="button" class="btn btn-danger">Add Extra</button>
            </div>

            <div class="m-portlet__foot m-portlet__foot--fit">
				<div class="m-form__actions">
					<button v-if="disabled_status==false" @click="create" class="btn btn-danger">Create</button>
					<button v-if="disabled_status==true" disabled @click="create" class="btn btn-danger">Create</button>
					<button type="button" class="btn btn-outline-danger">Cancel</button>
				</div>
			</div>
        </form>
    </div>
</template>

<script>
export default {
    // props: [],
    
    data(){
        return{

            image: 'https://www.capitalkaratesc.com/wp-content/uploads/2017/04/default-image.jpg',
            price: '',
            quantity: '',
            minimum_order: '',
            maximum_order: '',
            recommand: '',

            english: {
                name: '',
                additions: [],                
            },

            myanmar: {
                name: '',
                additions: [],
            },

            disabled_status: false,

        };
    },

    mounted()
    {

    },

    methods:{
        create(){

        },

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
    },
}
</script>

<style type="text/css">
    .mb-negative {
        margin-bottom: -20px !important;
    }
</style>