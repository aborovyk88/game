<template>
    <div class="container">
        <div class="row">
            <form-alert
                    :alertSuccess="alert.alertSuccess"
                    :isShowAlert="alert.isShowAlert">
                {{alert.alertMessage}}
            </form-alert>
        </div>
        <div class="row">
            <form @submit.prevent="addUser">
                <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
                    <label for="user-email">User E`mail</label>
                    <input type="text" v-model="form.email" name="email" id="user-email"
                           class="form-control">
                    <form-errors v-if="hasError" :errors="errors">
                        {{ errors.email[0] }}
                    </form-errors>
                </div>
                <div class="form-group" :class="{ 'has-error': form.errors.has('name') }">
                    <label for="user-name">Username</label>
                    <input type="text" v-model="form.name" name="username" id="user-name"
                           class="form-control">
                    <form-errors v-if="hasError" :errors="errors">
                        {{ errors.name[0] }}
                    </form-errors>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
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
                alert: {
                    isShowAlert: false,
                    alertMessage: null,
                    alertSuccess: false,
                },
                user_id: null,
                form: new Form({
                    email: null,
                    name: null
                }),
                errors: [],
                hasError: false
            };
        },
        methods: {
            addUser: function () {
                this.form.post('/users/create').then(response => {
                    this.hasError = false;
                    this.errors = [];
                    this.showAlert(response.data.msg, response.data.success, true);
                }).catch(errors => {
                    this.hasError = true;
                    this.errors = errors.response.data;
                });
            },
            showAlert: function (msg, type, isShow) {
                this.alert.isShowAlert = isShow;
                this.alert.alertMessage = msg;
                this.alert.alertSuccess = type;
            }
        },
        components: {
            FormErrors,
            FormAlert
        }
    }
</script>