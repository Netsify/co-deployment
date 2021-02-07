/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

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
Vue.component('example-component', require('./components/CompatibilityParams'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import route from './route';

import CompatibilityParams from './components/CompatibilityParams';

import App from './components/App';

// route('articles.delete_file', 5, 1);

// import CKEditor from 'public/ckeditor/ckeditor';
/*
import '/public/ckeditor/ckeditor';
CKEditor.replace('content');
*/

const app = new Vue({
    el: '#app',
    data() {
        return {
            type_id: 0,
            type_name: '',
            current_locale: ''
        }
    },
    components: {
        'c-params': CompatibilityParams
    },
    methods: {
        getType: function (event) {
            var select = event == undefined ? document.getElementById('type') : event.target;
            this.type_name = select.options[select.selectedIndex].text;
            this.type_id = select.value;
        },

        getDescriptions() {
            switch (this.current_locale) {
                case 'EN': var prefix = '/en'; break;
                default: var prefix = ''; break;
            }

            var uri = prefix + route('facilities.compatibility_params');
            axios.get(uri).then(response => console.log(response.data.data))
        }

    },
    mounted() {
        this.current_locale = document.getElementById('lang').innerText;
        this.getType();

        this.getDescriptions();
    }
});
