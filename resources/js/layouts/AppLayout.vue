<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light bg-dark bg-gradient">
        <div class="container">
            <a class="navbar-brand" href="#">HazeSoft Task</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav w-100">
                    <router-link
                        :to="{name: 'company.index'}"
                        class="nav-link" 
                        aria-current="page"
                    >
                        Company
                    </router-link>
                    <router-link
                        :to="{name: 'department.index'}"
                        class="nav-link" 
                        aria-current="page"
                    >
                        Department
                    </router-link>
                    <router-link
                        :to="{name: 'employee.index'}"
                        class="nav-link" 
                        aria-current="page"
                    >
                        Employee
                    </router-link>
                </div>
                <form class="d-flex">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            {{userName}}
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <li>
                                <a
                                class="dropdown-item"
                                href="javascript:void(0)"
                                @click="actionLogout"
                                >Logout</a>
                            </li>
                        </ul>
                        </div>
                </form>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <slot></slot>
    </div>
</template>
<script>
import { defineComponent } from "@vue/runtime-core";
import {useAuthStore} from "@/store/auth"

export default defineComponent({
    setup() {
        
    },
    computed: {
        userName() {
            return useAuthStore().auth?.user?.name;
        },
        userEmail() {
            return useAuthStore().auth?.user?.name;
        },
    },
    methods: {
        actionLogout() {
            useAuthStore().logoutUser()
                .then(response  => {
                    this.$router.push({name: 'login'});
                });
        },
    }
})
</script>

