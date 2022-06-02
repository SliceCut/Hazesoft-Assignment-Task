<template>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <h4>Basic Information</h4>
            <hr>
            <div class="form-group row">
                <label class="col-md-4">Name</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="name" v-model="form.name">
                </div>
                <InvalidError
                    :errors="form.errors"
                    name="name"
                />
            </div>
            <div class="form-group row">
                <label class="col-md-4">Email</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="email" v-model="form.email">
                    <InvalidError
                        :errors="form.errors"
                        name="email"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Gender</label>
                <div class="col-md-8">
                    <select name="gender" class="form-control" v-model="form.gender">
                        <option value="">Select Gender</option>
                        <option 
                            v-for="gender in genders"
                            :key="'gender_'+gender"
                            :value="gender"
                        >
                            {{gender}}
                        </option>
                    </select>
                    <InvalidError
                        :errors="form.errors"
                        name="gender"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Address</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="address" v-model="form.address">
                    <InvalidError
                        :errors="form.errors"
                        name="address"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Date of Birth</label>
                <div class="col-md-8">
                    <input type="date" class="form-control" name="date_of_birth" v-model="form.date_of_birth">
                    <InvalidError
                        :errors="form.errors"
                        name="date_of_birth"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Phone</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="phone" v-model="form.phone">
                    <InvalidError
                        :errors="form.errors"
                        name="phone"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Nationality</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="nationality" v-model="form.nationality">
                    <InvalidError
                        :errors="form.errors"
                        name="nationality"
                    />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4">Contact Perferred</label>
                <div class="col-md-8">
                    <select name="gender" class="form-control" v-model="form.contact_mode">
                        <option value="">----</option>
                        <option 
                            v-for="contactMode in contactModes"
                            :key="'contact_mode_'+contactMode"
                            :value="contactMode"
                        >
                            {{contactMode}}
                        </option>
                    </select>
                    <InvalidError
                        :errors="form.contact_mode"
                        name="email"
                    />
                </div>
            </div>
            <h4>Education</h4>
            <hr>
            <div class="section-education mb-3">
                <div 
                    v-for="(education, index) in form.educations"
                    class="card mb-3"
                    :key="'user_education_list_' + index"
                >
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Institute</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="education.institute"
                                >
                            </div>
                            <div class="col-md-6">
                                <label>Degree</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="education.degree"
                                >
                            </div>
                            <div class="col-md-12">
                                <label>Address</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="education.address"
                                >
                            </div>
                            <div class="col-md-6">
                                <label>Start Date</label>
                                <input 
                                    type="date"
                                    class="form-control"
                                    v-model="education.start_date"
                                >
                            </div>
                            <div class="col-md-6">
                                <label>End Date</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    v-model="education.end_date"
                                >
                            </div>
                            <div class="col-md-12">
                                <label>Description</label>
                                <textarea class="form-control" v-model="education.description"></textarea>
                            </div>
                            <div class="col-md-12 mt-3 text-right">
                                <button
                                    class="btn btn-sm btn-outline-danger" 
                                    @click="removeEducation(index)"
                                >Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="btn btn-default btn-sm" @click="addNewEducation">Add New</button>
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
        const genders = ref([])
        const contactModes = ref([])
        const form = ref({
            name: "",
            email: "",
            address: "",
            gender: "",
            phone: "",
            nationality: "",
            date_of_birth: "",
            contact_mode: "",
            educations: [],
            errors: null
        })

        return {form, genders, contactModes}
    },
    methods: {
        addNewEducation() {
            this.form.educations.push({
                institute: "",
                degree: "",
                start_date: "",
                end_date: "",
                address: "",
                description: "",
            });
        },
        removeEducation(index) {
            this.form.educations.splice(index, 1);
        },
        setErrors(errors) {
            this.form.errors = errors;
        }
    }
})
</script>
