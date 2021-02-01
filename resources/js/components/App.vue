<template>
    <div>
        {{ message}}
        <button @click="checkApi" class="btn btn-primary">Проверить апи</button>
        <kb-articles-form></kb-articles-form>
    </div>
</template>

<script>
    import KBForm from './knowledgebase/KB-form'
    export default {
        name: "app",
        components: {
            'kb-articles-form': KBForm
        },
        data() {
            return {
                message: "ЕЕЕЕ"
            }
        },
        methods: {
            checkApi(){
                axios.get('/api/test').then(data => console.log(data)).catch(error => alert(error));
            }
        }
    }
</script>

<style scoped>

</style>