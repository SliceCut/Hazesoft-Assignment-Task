import { defineStore } from 'pinia'

import {client, setClientToken} from "../services/client"

export const useDepartmentStore = defineStore('department',
    {
        state: () => ({
            departmentList: [],
            departmentEmployeeList: [],
            comapny: null
        }),
        actions: {
            findDepartmentById(id, payload) {
                return new Promise((resolve, reject) => {
                    client
                        .get("/departments/" + id, payload)
                        .then(response => {
                            this.$state.department = response.data.data;
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            getDepartmentList(payload) {
                return new Promise((resolve, reject) => {
                    client
                        .get("/departments", payload)
                        .then(response => {
                            this.$state.departmentList = response.data.data;
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            getDepartmentEmployeeList(id, payload) {
                return new Promise((resolve, reject) => {
                    client
                        .get("/departments/" + id + "/employees", payload)
                        .then(response => {
                            this.$state.departmentEmployeeList = response.data.data;
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            createNewDepartment(payload) {
                return new Promise((resolve, reject) => {
                    client
                        .post("/departments", payload)
                        .then(response => {
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            updateDepartment(id, payload) {
                return new Promise((resolve, reject) => {
                    client
                        .patch("/departments/" + id, payload)
                        .then(response => {
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            deleteDepartment(id) {
                return new Promise((resolve, reject) => {
                    client
                        .delete("/departments/" + id)
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
            departmentList(state){
                return state.departmentList;
            },
            departmentEmployeeList(state) {
                return state.departmentEmployeeList;
            },
            company(state) {
                return state.comapny;
            },
        }
    },
)