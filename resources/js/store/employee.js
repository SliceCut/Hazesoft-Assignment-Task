import { defineStore } from 'pinia'

import {client, setClientToken} from "../services/client"

export const useEmployeeStore = defineStore('employee',
    {
        state: () => ({
            employeeList: [],
            employee: null
        }),
        actions: {
            findEmployeeById(id, payload) {
                return new Promise((resolve, reject) => {
                    client
                        .get("/employees/" + id, payload)
                        .then(response => {
                            this.$state.employee = response.data.data;
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            getEmployeeList(payload) {
                return new Promise((resolve, reject) => {
                    client
                        .get("/employees", payload)
                        .then(response => {
                            this.$state.employeeList = response.data.data;
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            createNewEmployee(payload) {
                return new Promise((resolve, reject) => {
                    client
                        .post("/employees", payload)
                        .then(response => {
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            updateEmployee(id, payload) {
                return new Promise((resolve, reject) => {
                    client
                        .patch("/employees/" + id, payload)
                        .then(response => {
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            deleteEmployee(id) {
                return new Promise((resolve, reject) => {
                    client
                        .delete("/employees/" + id)
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
            employeeList(state){
                return state.employeeList;
            },
            employee(state) {
                return state.employee;
            },
        }
    },
)