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
                    <h2 class="title">Edit Company</h2>
                </div>
                <div class="card-body">
                    <CompanyForm
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
                    </CompanyForm>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import { defineComponent, ref ,inject, computed } from "@vue/runtime-core";
import AppLayout from "@/layouts/AppLayout.vue"
import PageNotFound from "@/pages/errors/PageNotFound.vue"
import CompanyForm from "./CompanyForm.vue"
import router from '@/router'
import LoadingButton from "@/components/LoadingButton.vue"
import {useCompanyStore} from "@/store/company"

export default defineComponent({
    setup() {
        const formRef = ref(null)
        const btnLoading = ref(false)
        const companyStore = useCompanyStore();
        const toast = inject('toast')
        const pageNotFound = false;
        const isLoading = ref(false)
        const company = computed(() => companyStore.$state.company)
        return {formRef, btnLoading, toast, companyStore , pageNotFound, isLoading, company}
    },
    components:{
        AppLayout,
        LoadingButton,
        PageNotFound,
        CompanyForm
    },
    mounted() {
        this.companyStore.findCompanyById(this.$route.params.id)
        .then(response => {
            this.formRef.initData(this.company);
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
            this.companyStore.updateCompany(this.$route.params.id, this.formRef.form)
            .then(response => {

                this.toast.show(response.data.message,{
                    type: 'success',
                    position: 'top-right'
                    // all of other options may go here
                })

                router.push({name: 'company.index'});
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