<template>
    <page-not-found v-if="pageNotFound"/>
    <app-layout v-if="!pageNotFound && employee">
        <div class="section-header">
            <h2 class="section-header__title">Employee</h2>
            <div class="btn-groups">
                <router-link 
                    :to="{name: 'employee.index'}"
                    class="btn btn-secondary btn-sm"
                >
                    View All Employee
                </router-link>
            </div>
        </div>
        <div class="setion-body">
            <div class="card">
                <div class="card-header">
                    <h2 class="title">Employee Detail</h2>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-4">Enroll Id</label>
                        <div class="col-md-8">
                            <span>{{employee.enroll_id}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Name</label>
                        <div class="col-md-8">
                            <span>{{employee.name}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Email</label>
                        <div class="col-md-8">
                            <span>{{employee.email}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Contact Number</label>
                        <div class="col-md-8">
                            <span>{{employee.contact}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Designation</label>
                        <div class="col-md-8">
                            <span>{{employee.designation}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Departments</label>
                        <div class="col-md-8">
                            <span
                                v-for="(department, key) in employee.departments"
                                class="badge bg-primary"
                                :key="'designation_Badge_'+key"
                            >
                                {{department.name}}
                            </span>
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
import {useEmployeeStore} from "@/store/employee"
import LoadingButton from "@/components/LoadingButton.vue"
import PageNotFound from "@/pages/errors/PageNotFound.vue"

export default defineComponent({
    setup() {
        const employeeStore = useEmployeeStore();
        const pageNotFound = false;
        const loading = ref(false)
        const employee = computed(() => employeeStore.$state.employee)
        return {loading, pageNotFound, employeeStore, employee}
    },
    components:{
        AppLayout,
        PageNotFound,
        LoadingButton,
    },
    mounted() {
        this.employeeStore.findEmployeeById(this.$route.params.id)
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
})
</script>