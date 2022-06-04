require('./bootstrap')

import { createApp } from 'vue'
import App from "./App"
import router from './router/index.js'
import piniaPersist from 'pinia-plugin-persist'
import { createPinia } from 'pinia'
import { createToaster } from "@meforma/vue-toaster";
import {useAuthStore} from "./store/auth"

const pinia = createPinia()
pinia.use(piniaPersist)

const app = createApp(App)
const authStore = useAuthStore(pinia);

if(authStore.auth) {
    console.log("the token111 is ", authStore.auth);
    authStore.getAuthDetail()
    .then(response => {
        initVueApp();
    });
} else {
    initVueApp();
}

function initVueApp(){
    app.use(router)
        .use(pinia)
        .provide('toast', createToaster({ /* options */ }))
        .mount('#app')
}