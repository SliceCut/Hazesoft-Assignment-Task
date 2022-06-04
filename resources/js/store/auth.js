import axios from 'axios';
import { defineStore } from 'pinia'
import { computed } from 'vue';

import {client, setClientToken} from "../services/client"

export const useAuthStore = defineStore('auth',
    {
        state: () => ({
            token: localStorage.getItem("token") || null,
            user: localStorage.getItem("user") ? JSON.parse(localStorage.getItem("user") || "") : null
        }),
        actions: {
            loginUser(payload) {
                let self = this;
                return new Promise((resolve, reject) => {
                    client
                        .post("/login", payload)
                        .then(response => {

                            this.setAuthUserAndToken(response.data);

                            resolve(response);
                        })
                        .catch(errors => {
                            console.log(errors);
                            reject(errors);
                        });
                });
            },
            getAuthDetail() {
                return new Promise((resolve, reject) => {
                    client
                        .get("/auth/user")
                        .then(response => {

                            const {user} = response.data;
                            this.setAuthUserData(user);

                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            logoutUser() {
                return new Promise((resolve, reject) => {
                    axios
                        .post("auth/logout")
                        .then(response => {
                            if(response.data.code === 200) {
                                this.setLogout();
                            } else {
                                throw new Error("Something wrong while logging out");
                            }
                            resolve(response);
                        }).catch(errors => reject(errors));
                });
            },
            setAuthUserAndToken({token, user}) {
                localStorage.setItem("token",token);
                localStorage.setItem("user", JSON.stringify(user));
                this.$state.token = token;
                this.$state.user = user;

                setClientToken();
            },
            setAuthUserData(user) {
                localStorage.setItem("user", JSON.stringify(user));
                this.$state.user = user;

            },
            setLogout() {
                localStorage.removeItem("token");
                localStorage.removeItem("user");
                this.$state.token = "";
                this.$state.user = "";
            }

        },
        getters: {
            // token(state){
            //     return state.token;
            // },
            __token(state){
                console.log("the state is ", state.token);
                return state.token;
            },
            auth(state) {
                if (!state.user)
                    return null;

                return {
                    user: state.user,
                };
            },
        }
    },
)