import Home from '../components/pages/home/Home.vue'
import App from '../components/pages/home/App.vue'
import Login from '../components/pages/auth/Login.vue'
import VerifyUser from '../components/pages/auth/VerifyUser.vue'
import CheckVIN from '../components/pages/vin/CheckVIN.vue'
import Account from "../components/pages/auth/Account";
import ForgotPassword from "../components/pages/auth/ForgotPassword";
import ResetPassword from "../components/pages/auth/ResetPassword";
import Register from "../components/pages/auth/Register";
import Settings from "../components/pages/auth/Settings";
import ChangePassword from "../components/pages/auth/ChangePassword";
import SearchResult from "../components/pages/home/SearchResult";


export default [

    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/app',
        name: 'app',
        component: App,
        meta: {
            guard: 'auth'
        }
    },    {
        path: '/result',
        name: 'result',
        component: SearchResult,
        meta: {
            guard: 'auth'
        }
    },

    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            guard: 'guest'
        }
    },
    {
        path: '/verify-me',
        name: 'verify-user',
        component: VerifyUser,
        meta: {
            guard: 'verify'
        }
    },
    {
        path: '/check-vin',
        name: 'check-vin',
        component: CheckVIN,
        meta: {
            guard: 'auth'
        }
    },
    {
        path: '/forgot-password',
        component: ForgotPassword,
        name: 'forgot-password',
        meta : {
            guard : 'guest'
        }
    },
    {
        path: '/reset-password/:token',
        props: route => ({
            token: route.params.token,
            email: route.query.email
        }),
        component: ResetPassword,
        name: 'reset-password',
        meta : {
            guard : 'guest'
        }
    },
    {
        path: '/register',
        component: Register,
        name: 'register',
        meta : {
            guard : 'guest'
        }
    },
    {
        path: '/verify-phone/:id/:hash',
        props: route => ({
            id: route.params.id,
            hash: route.params.hash
        }),
        component: VerifyUser,
        name: 'otp',

    },
    {
        path: '/settings',
        component: Settings,
        redirect: {
            name: 'profile'
        },
        name: 'settings',
        meta: {
            guard: 'auth'
        },
        children: [{
            path: 'account',
            component: Account,
            name: 'account',
            meta: {
                guard: 'auth'
            },

        },
            {
                path: 'password',
                component: ChangePassword,
                name: 'password',
                meta: {
                    guard: 'auth'
                },

            },

        ]
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/home',

    }
]


