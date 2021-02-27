<template>
    <div class="col-sm-4 mb-5">{{ descriptions[typeId] }}</div>
</template>

<script>
    export default {
        props: ['typeId', 'descriptions'],
    }
</script>

<style scoped>

</style>