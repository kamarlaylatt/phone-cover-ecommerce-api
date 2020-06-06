<template>
  <div>
    <div><h5>Tree View</h5></div>
    <v-jstree :data="categories"
      multiple 
      text-field-name="name" 
      allow-batch whole-row
      @item-click="itemClick"
      size="large"
      collapse
     >     
     </v-jstree>
   </div>
</template>

<script>
  export default {
    props: ['categories'],
    data() {
      return {
        node: '',
      };
    },

    mounted() {
      this.node = this.categories[0];
    },

    methods: {
      itemClick(node) {
        this.node = node.model.id;
        if(this.node != 0)
        { 
          window.location.href = '/admin/categories/'+this.node+'/show';
        }
      },

    }
  };
</script>

<style>
  .tree-icon {
    font-size: 18px;
  }
</style>