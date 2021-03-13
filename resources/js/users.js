window.Vue = require('vue');

import Api from './api';
import IconVerified from "./components/admin/IconVerified";

const app = new Vue({
    el: '#verified',
    components: {
        'icon-verified' : IconVerified
    },
    data() {
        return {
            message: null,
            user: null,
            // userId: null,
            // userVerified: null,
            // userVerifiedUrl: null,
            // userVerifiedTitle: null,
        }
    },
    methods: {
        setVerified: function (event) {
            let element = event.currentTarget;

            let route = element.getAttribute('route');

            Api.put(route)
                .then(response => {
                    this.message = response.data.message;
                    this.user = response.data.user;
                    // this.userVerifiedUrl = response.data.user.verified_url;
                    // this.userVerifiedTitle = response.data.user.verified_title;
                    // this.userId = response.data.user.id;
                    // this.userVerified = response.data.user.verified;
                })
                .catch(error => console.log(error));
        }
    },
});
