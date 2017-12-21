<template>
    <div class="container">
        <div class="row">
            <form-alert
                    :alertSuccess="alertSuccess"
                    :isShowAlert="isShowAlert">
                {{alertMessage}}
            </form-alert>
        </div>
        <div class="row">
            <form @submit.prevent="editUser">
                <div class="form-group" :class="{ 'has-error': form.errors.has('name') }">
                    <label for="user-name">Username</label>
                    <input type="text" v-model="form.name" name="username" id="user-name"
                           class="form-control">
                    <form-errors v-if="hasError" :errors="errors">
                        {{ errors.name[0] }}
                    </form-errors>
                </div>
                <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
                    <label for="user-email">User E`mail</label>
                    <input type="text" v-model="form.email" name="email" id="user-email"
                           class="form-control">
                    <form-errors v-if="hasError" :errors="errors">
                        {{ errors.email[0] }}
                    </form-errors>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</template>

<script>
    import Form from 'vform';
    import axios from 'axios';
    import FormErrors from '../Site/FormErrors.vue';
    import FormAlert from '../Site/FormAlert.vue';

    module.exports = {
        data: function () {
            return {
                isShowAlert: false,
                alertMessage: null,
                alertSuccess: false,
                errors: [],
                hasError: false,
                form: new Form({
                    email: null,
                    name: null
                }),
                user_id: this.$route.params.id
            };
        },
        methods: {
            getDataUser: function (id) {
                axios.get('/users/get/' + id).then(response => {
                    this.form.name = response.data.name;
                    this.form.email = response.data.email;
                });
            },
            editUser: function () {
                let userId = this.user_id;
                this.form.post('/users/update/' + userId).then(response => {
                    this.showAlert(response.data.msg, response.data.success, true);
                }).catch(errors => {
                    this.hasError = true;
                    this.errors = errors.response.data;
                });
            },
            showAlert: function (msg, type, isShow) {
                this.isShowAlert = isShow;
                this.alertMessage = msg;
                this.alertSuccess = type;
            }
        },
        created () {
            this.getDataUser(this.user_id);
        },
        watch: {
            user_id: 'getDataUser'
        },
        components: {
            FormErrors,
            FormAlert
        }
    }
</script>