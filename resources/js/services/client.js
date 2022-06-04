// axios.defaults.baseURL ='http://student.localhost:8000/' + "api/";

const BASE_URL = "/api/v1/"
//window.location.origin

import router from "@/router";
import axios from "axios";
import {useAuthStore} from "../store/auth"
import { createToaster } from "@meforma/vue-toaster";

// axios.defaults.baseURL =process.env.MIX_APP_URL + "api/";
axios.defaults.baseURL = BASE_URL;

const token = localStorage.token;
axios.defaults.headers.common["Accept"] = "application/json";
axios.defaults.headers.common["Content-Type"] =
    "application/json";
axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
// window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.Laravel.csrfToken;
// axios.defaults.withCredentials = true

if (token) {
    axios.defaults.headers.common["Authorization"] =
        "Bearer " + token;
}

axios.interceptors.response.use(
    (response) => {
        // console.log("the login route is ", router.resolve({name: 'login'}).href);
        // console.log("the current route is ", router.currentRoute.fullPath);
        return response
    },
    (error) => {
        let loginRoute = router.resolve({name: 'login'}).href

        console.log("the login route is", loginRoute);
        console.log("the current route is", );

        if (error.response.status === 401 && window.location.pathname !== loginRoute) {

            useAuthStore().setLogout();

            window.location.href = loginRoute
        }

        if(error.response.status === 500) {
            createToaster().show(error.response.data.message,{
                type: 'error',
                position: 'top-right'
                // all of other options may go here
            });
        }

        return Promise.reject(error)
    }
)

const client = axios

const setClientToken = () => {
    axios.defaults.headers.common["Authorization"] =
            "Bearer " + localStorage.token;
}

export {client, setClientToken}