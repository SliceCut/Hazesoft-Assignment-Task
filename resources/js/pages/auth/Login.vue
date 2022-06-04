<template>
    <div class="row my-5">
        <div class="card col-md-6 mx-auto px-0">
            <div class="card-header">
                <h2>Login</h2>
            </div>
            <div class="card-body">
                <form @submit.prevent="submit">
                    <span
                        v-if="errorMessage"
                        role="alert"
                        class="invalid-feedback d-block"
                    >
                        <strong>{{errorMessage}}</strong>
                    </span>
                    <div class="form-group">
                        <label>Email</label>
                        <input
                            class="form-control"
                            type="email"
                            v-model="form.email"
                            required
                        >
                        <invalid-error
                            :errors="errors"
                            :name="email" 
                        />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input
                            type="password"
                            class="form-control"
                            v-model="form.password"
                            required
                        >
                        <invalid-error
                            :errors="errors"
                            :name="password" 
                        />
                    </div>
                    <div class="form-group">
                        <loading-button
                            :loading="loading"
                            title="Login"
                            type="submit"
                            class="btn btn-primary"
                        />
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent, ref } from "@vue/runtime-core";
import LoadingButton from "@/components/LoadingButton"
import InvalidError from "@/components/InvalidError"
import {useAuthStore} from "@/store/auth"

export default defineComponent({
    components: {LoadingButton, InvalidError},
    setup() {
        const form = ref({
            email: "",
            passsword: "",
            errors: null
        })
        const loading = ref(false)
        const errorMessage = ref("") 
        return {form, loading, errorMessage}
    },
    methods: {
        submit() {
            this.loading = true;
            this.errorMessage = "";
            useAuthStore().loginUser(this.form)
                .then(response => {
                    this.$router.push({name: 'company.index'});
                })
                .catch(error => {
                    console.log("error");

                    if (error.response.status === 422){
                        this.form.errors = error.response.data.errors;
                    } else {
                        this.errorMessage = error.response.data.message;
                    }
                })
                .finally(()=> {
                    this.loading = false;
                });
        }
    }
})
</script>
