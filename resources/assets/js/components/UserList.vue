<template>
    <div class="container">
        <div class="row">
            <button class="btn btn-success" data-toggle="modal" @click="showModalCreate">Create user</button>
        </div>
        <div class="row">
            <div :class="alertSuccess ? 'alert alert-success' : 'alert alert-danger'" v-if="isShowAlert" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{alertMessage}}
            </div>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                <tr>
                    <th v-for="column_name in gridColumns">
                        {{ column_name }}
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in gridData">
                    <td v-for="value in gridColumns">
                        {{item[value]}}
                    </td>
                    <td>
                        <button @click="updateUserModal(item['ID'])" class="btn btn-sm btn-primary" title="Edit User">=></button>
                        <button @click="deleteUser(item['ID'])" class="btn btn-sm btn-danger" title="Delete User">-</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-4">
                <button class="btn btn-primary" @click="prevPage">Prev</button>
            </div>
            <div class="col-md-4">
                <p>Page: {{currentPage + 1}}</p>
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary" @click="nextPage">Next</button>
            </div>
        </div>

        <div class="row">
            <div class="container">
                <div class="modal fade" id="user-create-modal">
                    <div class="modal-dialog" role="document">
                        <form>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ modalTitle }}</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="user-email">User E`mail</label>
                                        <input type="text" v-model.lazy="user_email" name="email" id="user-email"
                                               class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="user-name">Username</label>
                                        <input type="text" v-model.lazy="user_name" name="username" id="user-name"
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" @click.prevent="addUser" v-if="isNew">Create</button>
                                    <button type="submit" class="btn btn-primary" @click.prevent="editUser" v-else>Update</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
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
    import axios from 'axios';

    module.exports = {
        props: ['current_columns', 'current_data', 'current_page_count'],

        data: function () {
            return {
                dataTable: JSON.parse(this.current_data),
                countPages: this.current_page_count,
                isShowAlert: false,
                alertMessage: null,
                alertSuccess: false,
                user_email: null,
                user_name: null,
                user_id: null,
                isNew: true,
                modalTitle: 'Create User',
                perPage: 10,
                currentPage: 0,
            };
        },
        methods: {
            addUser: function () {
                axios.post('/users/create', {
                    User: {
                        name: this.user_name,
                        email: this.user_email
                    }
                }).then(response => {
                    $('#user-create-modal').modal('hide');
                    this.showAlert(response);
                });
            },
            editUser: function () {
                axios.post('/users/update', {
                    User: {
                        name: this.user_name,
                        email: this.user_email
                    },
                    id: this.user_id
                }).then(response => {
                    $('#user-create-modal').modal('hide');
                    this.showAlert(response);
                });
            },
            deleteUser: function (id) {
                if (confirm('Do you really want to delete this user?')) {
                    axios.post('/users/delete', {
                        id: id
                    }).then(response => {
                        this.showAlert(response);
                    });
                }
            },
            getDataTable: function () {
                let vm = this;
                axios.post('/users/get', {
                    currentPage: vm.currentPage,
                    perPage: vm.perPage
                }).then(response => {
                    vm.dataTable = response.data.data;
                    vm.countPages = response.data.page_count;
                });
            },
            getDataUser: function (id) {
                let vm = this;
                axios.get('/users/get/' + id).then(response => {
                    vm.user_name = response.data.name;
                    vm.user_email = response.data.email;
                    vm.user_id = response.data.id;
                });
            },
            updateUserModal: function (id) {
                this.getDataUser(id);
                this.isNew = false;
                this.modalTitle = 'Update User';
                $('#user-create-modal').modal('show');
            },
            showModalCreate: function () {
                this.isNew = true;
                this.modalTitle = 'Create User';
                this.user_email = null;
                this.user_name = null;
                $('#user-create-modal').modal('show');
            },
            showAlert: function (response) {
                this.isShowAlert = true;
                this.alertMessage = response.data.msg;
                this.alertSuccess = response.data.success;
                this.user_email = null;
                this.user_name = null;
                this.getDataTable();
            },
            nextPage: function () {
                if (this.currentPage < this.countPages) {
                    this.currentPage++;
                    this.getDataTable();
                }
            },
            prevPage: function () {
                if (this.currentPage > 0) {
                    this.currentPage--;
                    this.getDataTable();
                }
            }
        },
        computed: {
            gridColumns: function () {
                return JSON.parse(this.current_columns);
            },
            gridData: function () {
                return this.dataTable;
            }
        }
    }
</script>