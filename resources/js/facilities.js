// require('./bootstrap');

window.Vue = require('vue');
import Api from './api';
import CParamDescription from './components/facilities/CParamDescription';
import CParamSlider from './components/facilities/CParamSlider';

const app = new Vue({
    el: '#div-facilities',
    components: {
        'c-param-description' : CParamDescription,
        'c-param-slider' : CParamSlider,
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
            Api.get('/ref-book/facility_type/' + this.type_id + '/descriptions')
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