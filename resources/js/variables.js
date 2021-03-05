window.Vue = require('vue');

import Api from './api';

const app = new Vue({
    el: '#variables',
    data() {
        return {
            load: false,
            variables: []
        }
    },
    methods: {
        getVars(event) {
            this.load = true;
            let id = event.target.value;
            Api.get('/variables/list', {
                params: {
                    group: id
                }
            }).then(response => {
                this.variables = response.data.variables;
                this.load = false;
            }).catch(error => console.error(error));
        }
    },
});
