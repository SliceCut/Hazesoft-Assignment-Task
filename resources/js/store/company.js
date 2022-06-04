import { defineStore } from 'pinia'

import {client, setClientToken} from "../services/client"

export const useCompanyStore = defineStore('company',
    {
        state: () => ({
            companyList: [],
            companyEmployeeList: [],
            comapny: null
        }),
        actions: {
            findCompanyById(id, payload) {
                return new Promise((resolve, reject) => {
                    client
                        .get("/companies/" + id, payload)
                        .then(response => {
                            this.$state.company = response.data.data;
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            getCompanyList(payload) {
                return new Promise((resolve, reject) => {
                    client
                        .get("/companies", payload)
                        .then(response => {
                            this.$state.companyList = response.data.data;
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            getCompanyEmployeeList(id,payload) {
                return new Promise((resolve, reject) => {
                    client
                        .get("/companies/" + id + "/employees", payload)
                        .then(response => {
                            this.$state.companyEmployeeList = response.data.data;
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            createNewCompany(payload) {
                return new Promise((resolve, reject) => {
                    client
                        .post("/companies", payload)
                        .then(response => {
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            updateCompany(id, payload) {
                return new Promise((resolve, reject) => {
                    client
                        .patch("/companies/" + id, payload)
                        .then(response => {
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            deleteCompany(id) {
                return new Promise((resolve, reject) => {
                    client
                        .delete("/companies/" + id)
                        .then(response => {
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
        },
        getters: {
            companyList(state){
                return state.companyList;
            },
            company(state) {
                return state.comapny;
            },
        }
    },
)