<template>
    <app-layout>
        <div class="section-header">
            <h2 class="section-header__title">Company List</h2>
            <div class="btn-groups">
                <router-link 
                    :to="{name: 'company.create'}"
                    class="btn btn-primary btn-sm"
                >
                    Add New Company
                </router-link>
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
                        <td>
                            <router-link
                                :to="{name: 'company.edit', params: {id: company.id}}"
                                class="btn btn-primary btn-sm mr-2"
                            >
                                Edit
                            </router-link>
                            <button
                                class="btn btn-danger btn-sm"
                                type="button"
                                @click="actionDeleteCompany(company.id)"
                            >
                                Delete
                            </button>
                        </td>
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
import { computed, defineComponent, ref ,inject } from "@vue/runtime-core";
import AppLayout from "@/layouts/AppLayout.vue"
import Pagination from 'v-pagination-3';
import {useCompanyStore} from "@/store/company"
export default defineComponent({
    setup() {
        const companyStore = useCompanyStore();
        const page = ref(1);
        const total = ref(1);
        const perPage = ref(20);
        const companys = computed( () => companyStore.$state.companyList)
        const toast = inject('toast')
        return {page, total, perPage, companys, companyStore, toast}
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
            let payload = {
                params: {
                    perPage : this.perPage,
                    page: this.page
                }
            }
            this.companyStore.getCompanyList(payload)
            .then(response => {
                this.total = response.data.total || 0;
            })
        },
        actionDeleteCompany(id) {
            if(confirm("Are you sure you want to delete company?")) {
                this.companyStore.deleteCompany(id)
                .then(response => {
                    this.toast.show(response.data.message,{
                        type: 'success',
                        position: 'top-right'
                        // all of other options may go here
                    })
                    this.reloadTable();
                })
            }
        },
        reloadTable() {
            this.page =1;
            this.loadTable();
        }
    }
})
</script>
