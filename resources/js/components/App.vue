<template>
<div>
<div>
    <nav-bar></nav-bar>
</div>
<div >
    <router-view  id="layer"  v-slot="{ Component }">
        <transition name="fade" mode="out-in" >
            <component :is="Component" />
        </transition>
    </router-view>
</div>
</div>
</template>

<script>
import NavBar from './layouts/NavBar.vue'
import {mapGetters} from "vuex";

export default {
    computed: {
        ...mapGetters({
            authenticated: 'auth/authenticated',
            user: 'auth/user',
            phoneValidated: 'auth/phoneValidated',
        }) ,
        id () {
            if(this.user){
                return this.user.id
            }
            return null
        },
        phoneValidated () {
            if(this.user){
                return this.phoneValidated
            }
            return false
        }
    },
    components : {
        NavBar
    }
}
</script>
<style>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}

</style>
