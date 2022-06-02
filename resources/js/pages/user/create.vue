<template>
    <app-layout>
        <div class="section-header">
            <h2 class="section-header__title">User</h2>
            <div class="btn-groups">
                <router-link 
                    :to="{name: 'home'}"
                    class="btn btn-secondary btn-sm"
                >
                    View All Users
                </router-link>
            </div>
        </div>
        <div class="setion-body">
            <div class="card">
                <div class="card-header">
                    <h2 class="title">New User</h2>
                </div>
                <div class="card-body">
                    <user-form
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
                    </user-form>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import { defineComponent, ref } from "@vue/runtime-core";
import AppLayout from "@/layouts/AppLayout.vue"
import UserForm from "./UserForm.vue"
import router from '@/router'
import {getUserFilterData, createUser} from "@/services/user.js"
import LoadingButton from "@/components/LoadingButton.vue"

export default defineComponent({
    setup() {
        const formRef = ref(null)
        const btnLoading = ref(false)
        return {formRef, btnLoading}
    },
    components:{
        AppLayout,
        LoadingButton,
        UserForm
    },
    mounted() {
        getUserFilterData()
        .then(response => {
            this.formRef.genders = response.data.genders;
            this.formRef.contactModes = response.data.contactModes;
        })
    },  
    methods: {
        submit() {
            this.btnLoading = true
            createUser(this.formRef.form)
            .then(response => {
                alert(response.data.message);

                router.push({name: 'home'});
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
