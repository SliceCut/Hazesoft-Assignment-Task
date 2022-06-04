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
                <label class="col-md-4">Company</label>
                <div class="col-md-8">
                    <select
                        class="form-control"
                        name="company_id"
                        v-model="form.company_id"
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
            <div class="form-group mt-5">
                <slot name="footer"></slot>
            </div>
        </div>
    </div>
</template>
<script>
import { defineComponent, ref , computed} from "@vue/runtime-core"
import InvalidError from "@/components/InvalidError.vue"
import {useFilterListStore} from "@/store/filterlist"

export default defineComponent({
    components: {InvalidError},
    setup() {
        const filterListStore = useFilterListStore();
        const form = ref({
            name: "",
            company_id: "",
            errors: null
        })

        const companies = computed(() => filterListStore.$state.filterCompanyList)

        return {form, companies}
    },
    methods: {
        setErrors(errors) {
            this.form.errors = errors;
        },
        initData({name, company_id}) {
            this.form.name = name;
            this.form.company_id = company_id;
        }
    }
})
</script>