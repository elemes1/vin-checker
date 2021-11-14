import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from './components/home/Home.vue'
import Login from './components/auth/Login.vue'
import VerifyUser from './components/auth/VerifyUser.vue'
import CheckVIN from './components/vin/CheckVIN.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    } ,
    {
        path: '/verify-me',
        name: 'VerifyUser',
        component: VerifyUser
    },
    {
        path: '/check-vin',
        name: 'CheckVIN',
        component: CheckVIN
    }
]

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})

export default router
