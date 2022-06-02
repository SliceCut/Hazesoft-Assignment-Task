<template>
    <page-not-found v-if="pageNotFound"/>
    <app-layout v-if="!pageNotFound && user">
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
                    <h2 class="title">User Detail: {{user.id}}</h2>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-4">Name</label>
                        <div class="col-md-8">
                            <span>{{user.name}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Email</label>
                        <div class="col-md-8">
                            <span>{{user.email}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Address</label>
                        <div class="col-md-8">
                            <span>{{user.address}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Gender</label>
                        <div class="col-md-8">
                            <span>{{user.gender}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Phone</label>
                        <div class="col-md-8">
                            <span>{{user.phone}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Date of Birth</label>
                        <div class="col-md-8">
                            <span>{{user.date_of_birth}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Contact Preferrred</label>
                        <div class="col-md-8">
                            <span class="badge bg-primary">{{user.contact_mode}}</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-4">Educations</label>
                        <div class="col-md-8">
                            <div 
                                v-for="(education, key) in user.educations"
                                class="card mb-3"
                                :key="'user_education_list_'+ key"
                            >
                                <div class="card-body">
                                    <div class="d-blokc">Institute: {{education.institute}}</div>
                                    <div class="d-blokc">Degree: {{education.degree}}</div>
                                    <div class="d-blokc">Degree: {{education.address}}</div>
                                    <div class="d-blokc">Start Date: {{education.start_date}}</div>
                                    <div class="d-blokc">End Date: {{education.end_date ? education.end_date : '-'}}</div>
                                    <div class="d-blokc">Description: {{education.Description}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<script>
import { defineComponent, ref } from "@vue/runtime-core";
import AppLayout from "@/layouts/AppLayout.vue"
import {findUserById} from "@/services/user.js"
import LoadingButton from "@/components/LoadingButton.vue"
import PageNotFound from "@/pages/errors/PageNotFound.vue"

export default defineComponent({
    setup() {
        const pageNotFound = false;
        const loading = ref(false)
        const user = ref(null)
        return {loading, pageNotFound, user}
    },
    components:{
        AppLayout,
        PageNotFound,
        LoadingButton,
    },
    mounted() {
        findUserById(this.$route.params.id)
        .then(response => {
            this.user = response.data.data;
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
