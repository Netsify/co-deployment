<template>
    <div v-if="userVue.verified || (userVue.id === this.userapi.id)">
        <sup>
            <img :src="userVue.v_url" alt="" height="25px" :title="userVue.v_title">
        </sup>
    </div>
</template>

<script>
    export default {
        props: ['user', 'url', 'title', 'userapi'],
        data() {
            return {
                userVue: {},
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
