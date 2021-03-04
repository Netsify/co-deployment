window.Vue = require('vue');

import axios from 'axios';

const app = new Vue({
    el: '#variables',
    data() {
        return {
            id: 'test'
        }
    },
    methods: {
        getVars(event) {
            let id = event.target.value;
            console.log(id);
        }
    },
});
