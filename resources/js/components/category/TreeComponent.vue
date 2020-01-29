<template>
<div>
  <!--begin::Portlet-->
  <div class="m-portlet m-portlet--danger m-portlet--head-solid-bg m-portlet--rounded">
    <div class="m-portlet__head">
      <div class="m-portlet__head-caption">
        <div class="m-portlet__head-title">
          <span class="m-portlet__head-icon">
            <i class="la la-thumb-tack"></i>
          </span>
          <h3 class="m-portlet__head-text">
            {{node.name}}
          </h3>
        </div>
      </div>
      <div class="m-portlet__head-tools">
        <ul class="m-portlet__nav">
          <li class="m-portlet__nav-item">
            <a href="#" class="m-portlet__nav-link btn btn-secondary m-btn m-btn--air m-btn--icon m-btn--icon-only m-btn--pill">
              <i class="la la-tint"></i>
            </a>
          </li>
          <li class="m-portlet__nav-item">
            <a href="#" class="m-portlet__nav-link btn btn-secondary m-btn m-btn--air m-btn--icon m-btn--icon-only m-btn--pill">
              <i class="la la-tags"></i>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="m-portlet__body">
      {{node.description}}
    </div>f
  </div>
  <div> 
    <el-tree         
      :data="categories"
      highlight-current
      check-strictly 
      node-key="id" 
      :props="defaultProps" 
       @node-click="handleNodeClick"
    >
    </el-tree>
  </div>
</div>
</template>

<script>
  export default {
    props: ['categories'],
    data() {
      return {
        node: '',
        data: '',
        defaultProps: {
          id: 'id',
          label: 'name',
          parent: 'parent',
          children: 'children',
          description: 'description',
          image: 'image',

        }
      };
    },

    mounted() {
      this.node = this.categories[0];
    },

    methods: {
      handleNodeClick(data) {
        this.node = data;
      },

      // handleNodeClick() {
      //   this.node = this.$refs.tree.getCheckedKeys();

      //   // const newChild = {label: 'testtest', children: [] };
      //   // if (!data.children) {
      //   //   this.$set(data, 'children', []);
      //   // }
      //   // data.children.push(newChild);
      // }
    }
  };
</script>

<style>
  span.el-tree-node__label {
    font-size: 17px;
  }
  span.el-tree-node__expand-icon.el-icon-caret-right  {
    font-size: 20px;
  }
</style>