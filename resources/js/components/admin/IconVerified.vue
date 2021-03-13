<template>
    <sup>
        <img :src="user.verified_url" alt="" height="25px" :title="user.verified_title">
    </sup>
</template>

<script>
    export default {
        props: ['user'],
    }
</script>

<style scoped>

</style>
