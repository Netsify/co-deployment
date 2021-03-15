<template>
    <sup>
        <img :src="user.verified_url" alt="" height="25px" :title="user.verified_title">
    </sup>
</template>

<script>
    export default {
        props: ['user', 'primary', 'url', 'title'],
        mounted() {
            this.user = this.primary;
            this.user.verified_url = this.url;
            this.user.verified_title = this.title;
        }
    }
</script>

<style scoped>

</style>
