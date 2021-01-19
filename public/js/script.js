new Vue({
    el: '#app',
    data: {
        msg: "hello world motherfucker",
        status: true,
        type: 'Type'
    },
    methods: {
        getType: function (event) {
            var select = event.target;
            this.type = select.options[select.selectedIndex].text;
        }
    }
});
