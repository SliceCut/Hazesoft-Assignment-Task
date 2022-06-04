<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">HazeSoft Task</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
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
            </div>
        </div>
    </nav>
    <div class="container">
        <slot></slot>
    </div>
</template>
<script setup>
</script>
