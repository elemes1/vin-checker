import axios from 'axios'

export default {
    namespaced: true,

    state: {
        authenticated: false,
        user: null,
        phoneValidated: false
    },

    getters: {
        authenticated (state) {
            return state.authenticated
        },

        user (state) {
            return state.user
        },
        phoneValidated (state) {
            return state.phoneValidated
        },
    },

    mutations: {
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },

        SET_USER (state, value) {
            state.user = value
        }   ,
        SET_VALIDATED (state, value) {
            state.phoneValidated = value
        }
    },
    actions: {
        async signIn ({ dispatch }, credentials) {
            await axios.get('/sanctum/csrf-cookie')
            await axios.post('/api/login', credentials)
            return dispatch('me')
        },

        async register ({ dispatch }, data) {
            await axios.post('/api/register', data)
            return dispatch('me')

        },

        async signOut ({ dispatch }) {
            await axios.post('/api/logout')
            return dispatch('me')
        },
        async profile({commit},payload) {
            await axios.patch('/api/profile', payload).then((res) => {
                commit('SET_USER', res.data.user);
            }).catch((err) => {
                throw err.response
            })
        },
        async password({commit},payload) {
            await axios.patch('/api/password', payload).then((res) => {
                commit('SET_USER', res.data.user);
            }).catch((err) => {
                throw err.response
            })
        },

        async verifyResend({dispatch} , payload){
            let res = await axios.post('/api/verify-resend' , payload)
            if (res.status != 200) throw res
            return res
        },


        me ({ commit }) {
            return axios.get('/api/user').then((response) => {
                commit('SET_AUTHENTICATED', true)
                commit('SET_VALIDATED', response.data.phone_validated_at != null)
                commit('SET_USER', response.data)
            }).catch(() => {
                commit('SET_AUTHENTICATED', false)
                commit('SET_USER', null)
            })
        }
    }
}
