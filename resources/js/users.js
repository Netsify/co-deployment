import TBody from "./components/admin/users/TBody";

window.Vue = require('vue');

import Api from './api';
import IconVerified from "./components/admin/users/IconVerified";

Vue.component('TBody', {
    data() {
        return {
            userApi: this.userApi,
        }
    },
})

const app = new Vue({
    el: '#verified',
    components: {
        'icon-verified' : IconVerified,
        't-body' : TBody
    },
    data() {
        return {
            message: null,
            userApi: {},
        }
    },
    methods: {
        setVerified: function (event) {
            let element = event.currentTarget;

            let route = element.getAttribute('route');

            Api.put(route)
                .then(response => {
                    this.message = response.data.message;
                    this.userApi = response.data.user;
                })
                .catch(error => console.log(error));
        }
    },
});
