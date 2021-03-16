<template>
    <div v-if="computedUserVue.verified">
        <sup>
            <img :src="computedUserVue.v_url" alt="" height="25px" :title="computedUserVue.v_title">
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
        computed: {
            computedUserVue: function() {
                return this.userVue = this.userVue.id === this.userapi.id ? this.userapi : this.userVue;
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
