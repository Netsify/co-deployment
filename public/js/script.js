new Vue({
    el: '#app',
    data: {
        msg: "hello world motherfucker",
        status: true,
        type: '',
        type_id: 0
    },
    methods: {
        getType: function (event) {
            var select = event.target;
            this.type = select.options[select.selectedIndex].text;
            this.type_id = select.value;
        }
    }
});
