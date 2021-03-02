/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// Vue.component('example-component', require('./components/CompatibilityParams'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
// import CompatibilityParams from './components/CompatibilityParams';

// import App from './components/App';

// import CKEditor from 'public/ckeditor/ckeditor';
/*
import '/public/ckeditor/ckeditor';
CKEditor.replace('content');
*/

/*const app = new Vue({
    el: '#app',
    data() {
        return {
            // type_id: 0,
            // type_name: '',
        }
    },
    components: {
        'app': App
    },
    methods: {
        /!*getType: function (event) {
            let select = event.target;
            this.type_name = select.options[select.selectedIndex].text;
            this.type_id = select.value;
        },*!/

        updateStatus: function (event) {
            let status = event.target;
            // console.log(status.value);

            let el = document.getElementById('status-data');
            let route = el.dataset.route;
            let proposal = el.dataset.proposal;
            // console.log(proposal);

            axios.put(route,{
                params: {
                    proposal: proposal,
                    status: 1234,
                },
                // _method: 'patch',
            }).then(response => {
                // console.log(proposal);
                // console.log(status.value);
                console.log(response.data);
            }).catch(function (error) {
                console.log(error);
            });
        },
    },
    mounted() {
        // let el = document.getElementById('status-data');
        // let route = JSON.parse(el.dataset.route);
        // this.route = route;
        // console.log(route);
    },
});

// export default {
//     props: ['route'],
// }*/
