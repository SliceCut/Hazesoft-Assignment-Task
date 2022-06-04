<template>
    <app-layout>
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
                    <h2 class="title">New Department</h2>
                </div>
                <div class="card-body">
                    <DepartmentForm
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
                    </DepartmentForm>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import { defineComponent, ref ,inject } from "@vue/runtime-core";
import AppLayout from "@/layouts/AppLayout.vue"
import DepartmentForm from "./DepartmentForm.vue"
import router from '@/router'
import LoadingButton from "@/components/LoadingButton.vue"
import {useFilterListStore} from "@/store/filterlist"
import {useDepartmentStore} from "@/store/department"

export default defineComponent({
    setup() {
        const formRef = ref(null)
        const btnLoading = ref(false)
        const filterListStore = useFilterListStore();
        const departmentStore = useDepartmentStore();
        const toast = inject('toast')
        return {formRef, btnLoading, toast, departmentStore, filterListStore}
    },
    components:{
        AppLayout,
        LoadingButton,
        DepartmentForm
    },
    mounted() {
        this.filterListStore.getFilterCompanyList();
    },  
    methods: {
        submit() {
            this.btnLoading = true
            this.departmentStore.createNewDepartment(this.formRef.form)
            .then(response => {

                this.toast.show(response.data.message,{
                    type: 'success',
                    position: 'top-right'
                    // all of other options may go here
                })

                router.push({name: 'department.index'});
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