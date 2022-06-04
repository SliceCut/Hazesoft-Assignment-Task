<template>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="form-group row">
                <label class="col-md-4">Name</label>
                <div class="col-md-8">
                    <input
                        type="text"
                        class="form-control"
                        name="name"
                        v-model="form.name"
                    >
                    <InvalidError
                        :errors="form.errors"
                        name="name"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Enroll Id</label>
                <div class="col-md-8">
                    <input
                        type="text"
                        class="form-control"
                        name="location"
                        v-model="form.enroll_id"
                    >
                    <InvalidError
                        :errors="form.errors"
                        name="enroll_id"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Email</label>
                <div class="col-md-8">
                    <input
                        type="text"
                        class="form-control"
                        name="email"
                        v-model="form.email"
                    >
                    <InvalidError
                        :errors="form.errors"
                        name="email"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Contact</label>
                <div class="col-md-8">
                    <input
                        type="text"
                        class="form-control"
                        name="Contact"
                        v-model="form.contact"
                    >
                    <InvalidError
                        :errors="form.errors"
                        name="contact"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Designation</label>
                <div class="col-md-8">
                    <input
                        type="text"
                        class="form-control"
                        name="designation"
                        v-model="form.designation"
                    >
                    <InvalidError
                        :errors="form.errors"
                        name="designation"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Company</label>
                <div class="col-md-8">
                    <select
                        class="form-control"
                        name="company_id"
                        v-model="form.company_id"
                        @change="onChangeCompanyId()"
                    >
                        <option value="">Select</option>
                        <option
                            v-for="(company, key) in companies"
                            :value="company.id"
                            :key="'select_company_' + key"
                        >
                            {{company.name}}
                        </option>
                    </select>
                    <InvalidError
                        :errors="form.company_id"
                        name="email"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Designation</label>
                <div class="col-md-8">
                    <select
                        class="form-control"
                        name="departments"
                        v-model="form.departments"
                        multiple
                    >
                        <option value="">Select</option>
                        <option 
                            v-for="(department, key) in departments"
                            :value="department.id"
                            :key="'select_department_' + key"
                        >
                            {{department.name}}
                        </option>
                    </select>
                    <InvalidError
                        :errors="form.errors"
                        name="departments"
                    />
                </div>
            </div>
            <div class="form-group mt-5">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</template>
<script>
import {computed, defineComponent, ref } from "@vue/runtime-core"
import InvalidError from "@/components/InvalidError.vue"
import {useFilterListStore} from "@/store/filterlist"

export default defineComponent({
    components: {InvalidError},
    setup() {
        const filterListStore = useFilterListStore();
        const form = ref({
            name: "",
            email: "",
            enroll_id: "",
            contact : "",
            designation: "",
            company_id: "",
            departments: [],
            errors: null
        })

        const companies = computed(() => filterListStore.$state.filterCompanyList)
        const departments = computed(() => filterListStore.$state.filterDepartmentList)

        return {form, filterListStore, companies, departments}
    },
    methods: {
        onChangeCompanyId() {
            this.form.departments = [];
            this.filterListStore.getFilterDepartmentList({
                params: {
                    company_id: this.form.company_id
                }
            });
        },
        setErrors(errors) {
            this.form.errors = errors;
        },
        initData({name, email, enroll_id , company_id, contact, designation, departments}) {
            this.form.company_id = company_id;
            this.form.name = name;
            this.form.email = email;
            this.form.enroll_id = enroll_id;
            this.form.contact = contact;
            this.form.designation = designation;

            this.onChangeCompanyId();
            this.form.departments = departments;
            
        }
    }
})
</script>