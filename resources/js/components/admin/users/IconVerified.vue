<template>
    <sup>
        <img :src="userVue.v_url" alt="" height="25px" :title="userVue.v_title">
    </sup>
</template>

<script>
    export default {
        props: ['userapi', 'user', 'url', 'title'],
        data() {
            return {
                userVue: this.userapi,
            }
        },
        mounted() {
            this.userVue = this.user;
            this.userVue.v_url = this.url;
            this.userVue.v_title = this.title;
        }
    }
</script>

<style scoped>

</style>
