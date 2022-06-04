<template>
    <app-layout>
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
                    <h2 class="title">New Employee</h2>
                </div>
                <div class="card-body">
                    <EmployeeForm
                        :ref="el => formRef = el"
                    >
                        <template v-slot:footer>
                            <loading-button
                                class="btn btn-primary btn-sm"
                                :loading="btnLoading"
                                title="Submit"
                                @load="submit()"
                            ></loading-button>
                        </template>
                    </EmployeeForm>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import { defineComponent, ref ,inject } from "@vue/runtime-core";
import AppLayout from "@/layouts/AppLayout.vue"
import EmployeeForm from "./EmployeeForm.vue"
import router from '@/router'
import LoadingButton from "@/components/LoadingButton.vue"
import {useEmployeeStore} from "@/store/employee"
import {useFilterListStore} from "@/store/filterlist"

export default defineComponent({
    setup() {
        const formRef = ref(null)
        const btnLoading = ref(false)
        const employeeStore = useEmployeeStore();
        const filterListStore = useFilterListStore();
        const toast = inject('toast')
        return {formRef, btnLoading, toast,filterListStore, employeeStore}
    },
    components:{
        AppLayout,
        LoadingButton,
        EmployeeForm
    },
    mounted() {
        this.filterListStore.getFilterCompanyList();
    },  
    methods: {
        submit() {
            this.btnLoading = true
            this.employeeStore.createNewEmployee(this.formRef.form)
            .then(response => {

                this.toast.show(response.data.message,{
                    type: 'success',
                    position: 'top-right'
                    // all of other options may go here
                })

                router.push({name: 'employee.index'});
            })
            .catch(error => {
                if(error.response.status === 422) {
                    this.formRef.setErrors(error.response.data.errors);
                }
            })
            .finally(() => (this.btnLoading = false))
        }
    }
})
</script>