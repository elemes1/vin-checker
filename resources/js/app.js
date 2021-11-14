import App from "./components/App";

require("./bootstrap");

import store from "./store";
import Vue from "vue";
import axios from 'axios'
import router from "./router";

axios.defaults.withCredentials = true

store.dispatch('auth/me').then(() => {
    new Vue({
        router,
        store,
        render: h => h(App)
    }).$mount('#app')
})
