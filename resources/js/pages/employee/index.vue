<template>
    <app-layout>
        <div class="section-header">
            <h2 class="section-header__title">Employee List</h2>
            <div class="btn-groups">
                <router-link 
                    :to="{name: 'employee.create'}"
                    class="btn btn-primary btn-sm"
                >
                    Add New Employee
                </router-link>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Enroll Id</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Contact</td>
                        <td>Designation</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(employee, key) in employees" :key="'employee_list_' + key">
                        <td>{{employee.id}}</td>
                        <td>
                            <router-link
                                :to="{name: 'employee.show', params:{id: employee.id}}"
                            >
                                {{employee.name}}
                            </router-link>
                        </td>
                        <td>{{employee.enroll_id}}</td>
                        <td>{{employee.email}}</td>
                        <td>{{employee.contact}}</td>
                        <td>{{employee.designation}}</td>
                        <td>
                            <router-link
                                :to="{name: 'employee.edit', params: {id: employee.id}}"
                                class="btn btn-primary btn-sm mr-2"
                            >
                                Edit
                            </router-link>
                            <button
                                class="btn btn-danger btn-sm"
                                type="button"
                                @click="actionDeleteEmployee(employee.id)"
                            >
                                Delete
                            </button>
                        </td>
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
    </app-layout>
</template>
<script>
import { defineComponent, ref ,inject } from "@vue/runtime-core";
import AppLayout from "@/layouts/AppLayout.vue"
import Pagination from 'v-pagination-3';
import {useEmployeeStore} from "@/store/employee"
export default defineComponent({
    setup() {
        const employeeStore = useEmployeeStore();
        const page = ref(1);
        const total = ref(1);
        const perPage = ref(20);
        const employees = []
        const toast = inject('toast')
        return {page, total, perPage, employees, employeeStore, toast}
    },
    components: {AppLayout, Pagination},
    mounted() {
        this.loadTable();
    },
    methods: {
        paginateTable(page) {
            this.page = page;
            this.loadTable();
        },
        loadTable() {
            let payload = {
                params: {
                    perPage : this.perPage,
                    page: this.page
                }
            }
            this.employeeStore.getEmployeeList(payload)
            .then(response => {
                this.employees = this.employeeStore.$state.employeeList
                this.total = response.data.total || 0;
            })
        },
        actionDeleteEmployee(id) {
            if(confirm("Are you sure you want to delete Employee?")) {
                this.employeeStore.deleteEmployee(id)
                .then(response => {
                    this.toast.show(response.data.message,{
                        type: 'success',
                        position: 'top-right'
                        // all of other options may go here
                    })
                    this.reloadTable();
                })
            }
        },
        reloadTable() {
            this.page =1;
            this.loadTable();
        }
    }
})
</script>
