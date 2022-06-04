<template>
    <PageNotFound v-if="pageNotFound"></PageNotFound>
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
                    <h2 class="title">Edit Employee</h2>
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
import { computed, defineComponent, ref ,inject } from "@vue/runtime-core";
import AppLayout from "@/layouts/AppLayout.vue"
import PageNotFound from "@/pages/errors/PageNotFound.vue"
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
        const pageNotFound = ref(false)
        const loading = ref(true)
        const employee =computed(() => employeeStore.$state.employee)
        return {
            formRef,
            btnLoading,
            pageNotFound,
            loading,
            toast,
            filterListStore,
            employeeStore,
            employee
        }
    },
    components:{
        AppLayout,
        LoadingButton,
        EmployeeForm,
        PageNotFound
    },
    mounted() {
        Promise.all([
            this.employeeStore.findEmployeeById(this.$route.params.id),
            this.filterListStore.getFilterCompanyList(),
        ])
        .then(response => {
            let data = {
                company_id : this.employee.company_id,
                name : this.employee.name,
                email : this.employee.email,
                enroll_id : this.employee.enroll_id,
                contact : this.employee.contact,
                designation : this.employee.designation,
                departments : this.employee.departments.map(item => item.id),
            }
            this.formRef.initData(data);
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
        submit() {
            this.btnLoading = true
            this.employeeStore.updateEmployee(this.$route.params.id, this.formRef.form)
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