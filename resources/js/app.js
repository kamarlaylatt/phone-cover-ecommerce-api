/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import Vue from 'vue';
import VTreeselect from 'vue-treeselect';
import VJstree from 'vue-jstree';
import ImageUploader from 'vue-image-upload-resize'
import VueLazyload from 'vue-lazyload'
import VueUploadMultipleImage from 'vue-upload-multiple-image'
import CKEditor from '@ckeditor/ckeditor5-vue';

Vue.use( CKEditor ); 
Vue.use(VueLazyload);
Vue.use(ImageUploader);
Vue.use(VTreeselect);
Vue.use(VJstree);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('tree-component', require('./components/category/TreeComponent.vue').default);
Vue.component('category_create-component', require('./components/category/CategoryCreateComponent.vue').default);
Vue.component('category_edit-component', require('./components/category/CategoryEditComponent.vue').default);
Vue.component('product_create-component', require('./components/product/ProductCreateComponent.vue').default);
Vue.component('product_edit-component', require('./components/product/ProductEditComponent.vue').default);
Vue.component('recruitment_create-component', require('./components/recruitment/RecruitmentCreateComponent.vue').default);
Vue.component('recruitment_edit-component', require('./components/recruitment/RecruitmentEditComponent.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
