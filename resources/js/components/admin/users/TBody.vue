<template>
    <tbody>
        <tr v-for="user in users">
            <td>
                {{ user.id }}
            </td>
            <td>
                    {{ user.first_name + 'test5130' + user.last_name }}
                    <span v-if="user.verified /*|| (user && user.id === {{ $user->id }} && user.verified)*/">
                        <sup>
                            <img :src="apiUser.verified_url" alt="" height="25px" :title="user.verified_title">
                        </sup>
                    </span>
            </td>
            <td>
                {{ user.email }}
            </td>
            <td>
                {{ user.role.name }}
            </td>
            <td>
                <input type="checkbox" name="verified" @change="setVerified"
                       class="form-check-input" :route=route :checked="user.verified">

                <div style="color: red" v-if="user">
                    <span v-if="user.id === {{ $user->id }}">
                        @{{ message }}
                    </span>
                </div>
            </td>
        </tr>
    </tbody>
</template>

<script>
    export default {
        props: ['users', 'route'],
    }
</script>

<style scoped>

</style>
