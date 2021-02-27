// require('./bootstrap');

window.Vue = require('vue');
import axios from 'axios';

import CParamDescription from './components/facilities/CParamDescription';

const app = new Vue({
    el: '#div-facilities',
    components: {
        'c-param-description' : CParamDescription
    },
    data() {
        return {
            type_id: 0,
            type_name: '',
            descriptions: []
        }
    },
    methods: {
        getType: function (event = null) {
            let select = event ? event.target : document.getElementById('type');
            this.type_name = select.options[select.selectedIndex].text;
            this.type_id = select.value;

            if (this.type_id > 0) {
                console.log('worked');
                this.getDescriptions();
            }
        },
        getDescriptions: function () {
            let lang = document.getElementById('language').innerText.trim().toLowerCase();
            switch (lang) {
                case 'ru': lang = ''; break;
                case 'en': lang = '/en'; break;
            }
            axios.get(lang +'/api/ref-book/facility_type/' + this.type_id + '/descriptions')
                .then(response => {
                    // console.log(response.data.descriptions);
                    this.descriptions = response.data.descriptions;
                    console.log(this.descriptions);
                })
                .catch(error => console.log(error));
        }
    },
    created() {
        this.getType();

    }
});