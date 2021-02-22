require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#variables',
    data() {
        return {
            msg: "Vue JS в деле"
        }
    },
    methods: {

    },
});
