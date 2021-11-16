import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from "./routes";
import auth from "../store/modules/auth";

Vue.use(VueRouter)


const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

router.beforeEach((to, from, next) => {

    if (auth.state.authenticated) {
        if (to.matched.some(route => route.meta.guard === 'auth') && !auth.state.phoneValidated) next({name: 'verify-user'})
        if (to.matched.some(route => route.meta.guard === 'verify') && auth.state.phoneValidated) next({name: 'app'})
        if (to.matched.some(route => route.meta.guard === 'guest') && auth.state.phoneValidated) next({name: 'app'})
        else next();
    } else if (!auth.state.authenticated) {
        if (to.matched.some(route => route.meta.guard === 'auth')) next({name: 'login'})
        else
            next()
    } else if (!auth.state.authenticated && to.matched.some(route => route.meta.guard === 'verify')) {
        // todo:: fix issue
    } else {
        next({name: 'home'});
    }
})

export default router
