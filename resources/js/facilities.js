// require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#div-facilities',
    data() {
        return {
            type_id: 0,
            type_name: '',
        }
    },
    methods: {
        getType: function (event = null) {
            let select = event ? event.target: document.getElementById('type');
            this.type_name = select.options[select.selectedIndex].text;
            this.type_id = select.value;
        },
/*        foo: function () {
            alert(111);
        }*/
    },
    created() {
        // let select = document.getElementById('type');
        // this.type_name = select.options[select.selectedIndex].text;
        // this.type_id = select.value;
        this.getType();

    }
});