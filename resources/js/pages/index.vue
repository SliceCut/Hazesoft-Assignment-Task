<template>
    <app-layout>
        <div class="section-header">
            <h2 class="section-header__title">Company List</h2>
            <div class="btn-groups">
                <!-- <router-link 
                    :to="{name: 'company.create'}"
                    class="btn btn-primary btn-sm"
                >
                    Add New Company
                </router-link> -->
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Id</td>
                        <td>Name</td>
                        <td>Location</td>
                        <td>Contact Number</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(company, key) in companys" :key="'company_list_' + key">
                        <td>{{company.id}}</td>
                        <td>
                            <router-link
                                :to="{name: 'company.show', params: {id: company.id}}"
                                class="text-primary"
                            >
                                {{company.name}}
                            </router-link>
                        </td>
                        <td>{{company.location}}</td>
                        <td>{{company.contact_number}}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <pagination
            v-model="page"
            :records="total"
            :per-page="perPage"
            @paginate="paginateTable"
        />
    </app-layout>
</template>
<script>
import { defineComponent, ref } from "@vue/runtime-core";
import AppLayout from "@/layouts/AppLayout.vue"
import Pagination from 'v-pagination-3';
export default defineComponent({
    setup() {
        const page = ref(1);
        const total = ref(1);
        const perPage = ref(20);
        const companys = ref([])
        return {page, total, perPage, companys}
    },
    components: {AppLayout, Pagination},
    mounted() {
        this.loadTable();
    },
    methods: {
        paginateTable(page) {
            this.page = page;
            this.loadTable();
        },
        loadTable() {
            
        }
    }
})
</script>
