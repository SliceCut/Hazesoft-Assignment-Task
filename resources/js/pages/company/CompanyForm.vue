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
                <label class="col-md-4">Location</label>
                <div class="col-md-8">
                    <input
                        type="text"
                        class="form-control"
                        name="location"
                        v-model="form.location"
                    >
                    <InvalidError
                        :errors="form.errors"
                        name="location"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Contact Number</label>
                <div class="col-md-8">
                    <input
                        type="text"
                        class="form-control"
                        name="contact_number"
                        v-model="form.contact_number"
                    >
                    <InvalidError
                        :errors="form.errors"
                        name="contact_number"
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
import { defineComponent, ref } from "@vue/runtime-core"
import InvalidError from "@/components/InvalidError.vue"

export default defineComponent({
    components: {InvalidError},
    setup() {
        const form = ref({
            name: "",
            email: "",
            location: "",
            contact_number: "",
            errors: null
        })

        return {form}
    },
    methods: {
        setErrors(errors) {
            this.form.errors = errors;
        },
        initData({name, email, location , contact_number}) {
            this.form.name = name;
            this.form.email = email;
            this.form.location = location;
            this.form.contact_number = contact_number;
        }
    }
})
</script>