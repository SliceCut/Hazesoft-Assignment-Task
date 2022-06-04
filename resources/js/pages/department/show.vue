<template>
    <page-not-found v-if="pageNotFound"/>
    <app-layout v-if="!pageNotFound && department">
        <div class="section-header">
            <h2 class="section-header__title">Department</h2>
            <div class="btn-groups">
                <router-link 
                    :to="{name: 'department.index'}"
                    class="btn btn-secondary btn-sm"
                >
                    View All Department
                </router-link>
            </div>
        </div>
        <div class="setion-body">
            <div class="card">
                <div class="card-header">
                    <h2 class="title">Department Detail</h2>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-4">Name</label>
                        <div class="col-md-8">
                            <span>{{department.name}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Email</label>
                        <div class="col-md-8">
                            <span>{{department.company ? department.company.name : '-'}}</span>
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
                                            <td>Designation Number</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(employee, key) in departmentEmployees" :key="'department_list_' + key">
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
import {useDepartmentStore} from "@/store/department"
import Pagination from 'v-pagination-3';
import LoadingButton from "@/components/LoadingButton.vue"
import PageNotFound from "@/pages/errors/PageNotFound.vue"

export default defineComponent({
    setup() {
        const departmentStore = useDepartmentStore();
        const pageNotFound = false;
        const loading = ref(false)
        const page = ref(1);
        const total = ref(1);
        const perPage = ref(20);
        const department = computed(() => departmentStore.$state.department)
        const departmentEmployees = computed(() => departmentStore.$state.departmentEmployeeList)
        return {
            loading,
            pageNotFound,
            page,
            total,
            perPage,
            departmentStore,
            department,
            departmentEmployees
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
            this.departmentStore.findDepartmentById(this.$route.params.id),
            this.fetchEmployeesOfDepartment()
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
            this.fetchEmployeesOfDepartment();
        },
        fetchEmployeesOfDepartment() {
            let payload = {
                params: {
                    perPage : this.perPage,
                    page: this.page
                }
            }
            this.departmentStore.getDepartmentEmployeeList(this.$route.params.id, payload)
            .then(response => {
                this.total = response.data.total || 0;
            })
        }
    }
})
</script>