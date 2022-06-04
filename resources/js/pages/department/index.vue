<template>
    <app-layout>
        <div class="section-header">
            <h2 class="section-header__title">Department List</h2>
            <div class="btn-groups">
                <router-link 
                    :to="{name: 'department.create'}"
                    class="btn btn-primary btn-sm"
                >
                    Add New Department
                </router-link>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Name</td>
                        <td>Company</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(department, key) in departments" :key="'department_list_' + key">
                        <td>{{department.id}}</td>
                        <td>
                            <router-link
                                :to="{name: 'department.show', params: {id: department.id}}"
                                class="text-primary"
                            >
                                {{department.name}}
                            </router-link>
                        </td>
                        <td>{{department.company ? department.company.name : "-"}}</td>
                        <td>
                            <router-link
                                :to="{name: 'department.edit', params: {id: department.id}}"
                                class="btn btn-primary btn-sm mr-2"
                            >
                                Edit
                            </router-link>
                            <button
                                class="btn btn-danger btn-sm"
                                type="button"
                                @click="actionDeleteDepartment(department.id)"
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
import { computed, defineComponent, ref ,inject } from "@vue/runtime-core";
import AppLayout from "@/layouts/AppLayout.vue"
import Pagination from 'v-pagination-3';
import {useDepartmentStore} from "@/store/department"
export default defineComponent({
    setup() {
        const departmentStore = useDepartmentStore();
        const page = ref(1);
        const total = ref(1);
        const perPage = ref(20);
        const departments = computed( () => departmentStore.$state.departmentList)
        const toast = inject('toast')
        return {page, total, perPage, departments, departmentStore, toast}
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
            this.departmentStore.getDepartmentList(payload)
            .then(response => {
                this.total = response.data.total || 0;
            })
        },
        actionDeleteDepartment(id) {
            if(confirm("Are you sure you want to delete Department?")) {
                this.departmentStore.deleteDepartment(id)
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
