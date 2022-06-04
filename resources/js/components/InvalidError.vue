<template>
    <div v-if="errors && errors[name]">
        <span 
            v-for="message in errors[name]"
            class="d-block text-danger"
            :key="'error_' + message">
            {{message}}
        </span>
    </div>
</template>
<script>

export default{
    props: {
        errors: {},
        name: {
            type: String,
            required: true
        }
    }
}
</script>
