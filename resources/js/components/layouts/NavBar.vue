<template>
    <div class="shadow-md bg-white ">
        <div class="max-w-screen-lg mx-auto flex justify-between">
            <div class=" p-4 ">
                <router-link class="font-semibold tracking-wider	text-indigo-500 text-lg " :to="{name : 'home'}">
                    VIN CHECKER
                </router-link>
            </div>

            <div v-if="authenticated" class="relative "  ref="dropMenu">
                <div @click="drop=!drop"  class=" flex items-center cursor-pointer p-4  font-semibold tracking-wider text-lg">
                    {{user.name}}
                </div>

                <div v-if="drop" @click="drop=!drop" class="absolute bg-white border z-10 shadow-md flex w-auto flex-col ">
                    <router-link class="p-4 flex items-center" :to="{ name: 'account' }">
                        Account
                    </router-link>

                    <div @click.prevent="signOut" class="p-4 flex  items-center cursor-pointer">
                        Logout
                    </div>
                </div>
            </div>

            <div v-else class="flex">
                <router-link  v-if="!authenticated" class="p-4 tracking-widest flex items-center  text-gray-600"
                    active-class="font-semibold text-gray-800"
                    :to="{ name: 'login' }">
                        Login
                </router-link>
                <router-link class="p-4 tracking-widest flex items-center  text-gray-600"
                    active-class="font-semibold text-gray-800"
                    :to="{ name: 'register' }">
                        Register
                </router-link>
            </div>
        </div>
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
    },
    created: function() {
        if(this.authenticated) {
            let self = this ;
            window.addEventListener('click', function(e){
                if (! self.$refs.dropMenu.contains(e.target) ){
                    self.drop = false
                }
            })
        }
    },

    data() {
        return {
            drop : false ,
        }
    },
}
</script>
