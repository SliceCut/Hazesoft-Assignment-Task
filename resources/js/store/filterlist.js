import { defineStore } from 'pinia'

import {client, setClientToken} from "../services/client"

export const useFilterListStore = defineStore('filterlist',
    {
        state: () => ({
            filterCompanyList: [],
            filterDepartmentList: []
        }),
        actions: {
            getFilterCompanyList(payload) {
                return new Promise((resolve, reject) => {
                    client
                        .get("list/company", payload)
                        .then(response => {
                            this.$state.filterCompanyList = response.data;
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
            getFilterDepartmentList(payload) {
                return new Promise((resolve, reject) => {
                    client
                        .get("list/department", payload)
                        .then(response => {
                            this.$state.filterDepartmentList = response.data;
                            resolve(response);
                        })
                        .catch(errors => {
                            reject(errors);
                        });
                });
            },
        },
        getters: {
            filterCompanyList(state){
                return state.filterCompanyList;
            },
        }
    },
)