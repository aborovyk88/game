<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        <form @submit.prevent="login" class="form-horizontal" role="form" method="post">

                            <div class="form-group" :class="{ 'has-error': form.errors.has('email') }">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" v-model="form.email" class="form-control" name="email">
                                    <form-errors v-if="isError" :errors="errors">
                                        {{ errors.email[0] }}
                                    </form-errors>
                                </div>
                            </div>

                            <div class="form-group" :class="{ 'has-error': form.errors.has('password') }">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" v-model="form.password" class="form-control" name="password">
                                    <form-errors v-if="isError" :errors="errors">
                                        {{ errors.password[0] }}
                                    </form-errors>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" v-model="form.remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="/password/reset">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
                    password: null,
                    remember: false
                }),
                errors: [],
                isError: false
            };
        },
        methods: {
            login() {
                this.form.post('/login').then(response => {
                    this.isError = false;
                    this.errors = [];
                    window.location = '/';
                }).catch(errors => {
                    this.isError = true;
                    this.errors = errors.response.data;
                });
            }
        },
        components: {
            FormErrors
        }
    }
</script>