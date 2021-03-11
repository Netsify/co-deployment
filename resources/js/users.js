window.Vue = require('vue');

import Api from './api';

const app = new Vue({
    el: '#verified',
    methods: {
        setVerified: function (event) {
            let element = event.currentTarget;

            let route = element.getAttribute('route');

            Api.put(route);/*,{
                //
            }).then(response => {
                //
            }).catch(function (error) {
                //
            });*/
        }
    },
});
