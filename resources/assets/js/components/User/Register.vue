<template>
    <div class="container">
        <div class="row">

        </div>
    </div>
</template>

<script>
    import Form from 'vform';
    import FormErrors from '../Site/FormErrors.vue';

    module.exports = {
        data: function () {
            return {
                form: new Form({
                    email: null,
                    name: null,
                    password: null
                }),
                errors: [],
                isError: false
            };
        },
        methods: {

        },
        components: {
            FormErrors
        }
    };
</script>