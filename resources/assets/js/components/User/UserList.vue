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
            <div class="col-md-3">
                <label class="control-label" for="per-page">Per Page Items</label>
                <select v-model="perPage" v-on:change="getDataTable" id="per-page" class="form-control">
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="control-label" for="go-page">Go To Page</label>
                <input type="text" v-model="currentPage" v-on:keyup="goToPage" class="form-control" id="go-page"/>
            </div>
        </div>
        <div class="row">
            <table class="table table-condensed table-hover">
                <thead>
                <tr>
                    <th v-for="column_name in columnsTable">
                        {{ column_name }}
                        <input type="text" class="form-control" style="width: 60%" v-model="filters[column_name]" v-on:keyup="filterUsers"/>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in dataTable">
                    <td v-for="value in columnsTable">
                        {{item[value]}}
                    </td>
                    <td>
                        <router-link :to="{ name: 'updateUser', params: { id: item['ID'] }}" class="btn btn-sm btn-primary" title="Edit User">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                        </router-link>
                        <button @click="deleteUser(item['ID'])" class="btn btn-sm btn-danger" title="Delete User">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="row text-center">
            <nav aria-label="Pager">
                <ul class="pager">
                    <li class="previous">
                        <a @click="prevPage">
                            <span aria-hidden="true" class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                    </li>
                    <li class="next">
                        <a @click="nextPage">
                            <span aria-hidden="true" class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    </li>
                </ul>
                <p>Page: {{currentPage}} in {{countPages}}</p>
            </nav>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import FormAlert from '../Site/FormAlert.vue';

    module.exports = {
        data: function () {
            return {
                dataTable: [],
                countPages: 0,
                columnsTable: [],
                perPage: 10,
                currentPage: 1,
                alert: {
                    isShowAlert: false,
                    alertMessage: null,
                    alertSuccess: false,
                },
                filters: []
            };
        },
        methods: {
            deleteUser (id) {
                if (confirm('Do you really want to delete this user?')) {
                    axios.post('/users/delete/' + id).then(response => {
                        this.showAlert(response.data.msg, response.data.success, true);
                    });
                }
            },
            getDataTable () {
                let vm = this;
                console.log(vm.filters['ID']);
                axios.post('/users/get', {
                    currentPage: vm.currentPage,
                    perPage: vm.perPage,
                    filters: vm.gridFilters
                }).then(response => {
                    vm.dataTable = response.data.data;
                    vm.countPages = response.data.page_count;
                    vm.columnsTable = response.data.columns;
                });
            },
            nextPage () {
                if (this.currentPage < this.countPages) {
                    this.currentPage++;
                    this.getDataTable();
                }
            },
            prevPage () {
                if (this.currentPage > 1) {
                    this.currentPage--;
                    this.getDataTable();
                }
            },
            goToPage () {
                if (this.currentPage < 1) {
                    this.currentPage = 1;
                }

                if (this.currentPage > this.countPages) {
                    this.currentPage = this.countPages;
                }

                this.getDataTable();
            },
            showAlert (msg, type, isShow) {
                this.alert.isShowAlert = isShow;
                this.alert.alertMessage = msg;
                this.alert.alertSuccess = type;
                this.getDataTable();
            },
            filterUsers () {
                this.currentPage = 1;
                this.getDataTable();
            }
        },
        created () {
            this.getDataTable();
        },
        computed: {
            gridFilters: function () {
                let filters = {};
                let vm = this;
                this.columnsTable.forEach(function (key) {
                    filters[key] = vm.filters[key];
                });
                return filters;
            },
        },
        components: {
            FormAlert
        }
    }
</script>