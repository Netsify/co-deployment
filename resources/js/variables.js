require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#variables',
    data() {
        return {
            modalVisibility: false
        }
    },
    methods: {

    },
});
