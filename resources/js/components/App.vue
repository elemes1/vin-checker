<template>
    <div id="app">
        <div id="nav">
            <router-link to="/">Home</router-link> |
            <template v-if="!authenticated">
                <router-link to="/login">Sign in</router-link> |
            </template>
            <template v-else>
                <router-link to="/account">{{ user.name }}</router-link> |
                <a href="#" @click.prevent="signOut">Sign out</a>
            </template>
        </div>
        <router-view/>
    </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
        })
    },

    methods: {
        ...mapActions({
            signOutAction: 'auth/signOut'
        }),

        async signOut () {
            await this.signOutAction()
            this.$router.replace({ name: 'home' })
        }
    }
}
</script>
