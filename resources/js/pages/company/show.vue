<template>
    <page-not-found v-if="pageNotFound"/>
    <app-layout v-if="!pageNotFound && company">
        <div class="section-header">
            <h2 class="section-header__title">Company</h2>
            <div class="btn-groups">
                <router-link 
                    :to="{name: 'company.index'}"
                    class="btn btn-secondary btn-sm"
                >
                    View All Company
                </router-link>
            </div>
        </div>
        <div class="setion-body">
            <div class="card">
                <div class="card-header">
                    <h2 class="title">Company Detail</h2>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-4">Name</label>
                        <div class="col-md-8">
                            <span>{{company.name}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Email</label>
                        <div class="col-md-8">
                            <span>{{company.email}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Location</label>
                        <div class="col-md-8">
                            <span>{{company.location}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Contact Number</label>
                        <div class="col-md-8">
                            <span>{{company.contact_number}}</span>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Employee List
                        </div>
                        <div class="card-body">  
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <td>Id</td>
                                            <td>Name</td>
                                            <td>Email</td>
                                            <td>Contact Number</td>
                                            <td>Designation</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(employee, key) in companyEmployeeList" :key="'department_list_' + key">
                                            <td>{{employee.enroll_id}}</td>
                                            <td>
                                                <router-link
                                                    :to="{name: 'employee.show', params: {id: employee.id}}"
                                                    class="text-primary"
                                                >
                                                    {{employee.name}}
                                                </router-link>
                                            </td>
                                            <td>{{employee.email}}</td>
                                            <td>{{employee.contact}}</td>
                                            <td>{{employee.designation}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <pagination
                                v-model="page"
                                :records="total"
                                :per-page="perPage"
                                @paginate="paginateTable"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import { defineComponent, ref, computed } from "@vue/runtime-core";
import AppLayout from "@/layouts/AppLayout.vue"
import {useCompanyStore} from "@/store/company"
import Pagination from 'v-pagination-3';
import LoadingButton from "@/components/LoadingButton.vue"
import PageNotFound from "@/pages/errors/PageNotFound.vue"

export default defineComponent({
    setup() {
        const companyStore = useCompanyStore();
        const pageNotFound = false;
        const loading = ref(false)
        const page = ref(1);
        const total = ref(1);
        const perPage = ref(20);
        const company = computed(() => companyStore.$state.company)
        const companyEmployeeList = computed(() => companyStore.$state.companyEmployeeList)
        return {
            loading,
            pageNotFound,
            page,
            total,
            perPage,
            companyStore,
            company,
            companyEmployeeList
        }
    },
    components:{
        AppLayout,
        Pagination,
        PageNotFound,
        LoadingButton,
    },
    mounted() {

        Promise.all([
            this.companyStore.findCompanyById(this.$route.params.id),
            this.fetchEmployeesOfCompany()
        ])
        .then(response => {
            this.loading = false;
        })
        .catch(error => {
            if(error.response.status === 404) {
                this.pageNotFound = true;
                this.loading = false;
            }
        })
    },  
    methods: {
        paginateTable(page) {
            this.page = page;
            this.fetchEmployeesOfCompany();
        },
        fetchEmployeesOfCompany() {
            let payload = {
                params: {
                    perPage : this.perPage,
                    page: this.page
                }
            }
            this.companyStore.getCompanyEmployeeList(this.$route.params.id, payload)
            .then(response => {
                this.total = response.data.total || 0;
            })
        }
    }
})
</script>