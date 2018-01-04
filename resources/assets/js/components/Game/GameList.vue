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
                    <option value="500">500</option>
                    <option value="1000">1000</option>
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
                        <div @click="orderGames(column_name)" class="column-header">
                            {{ column_name }}
                            <span class="arrow" :class="gridOrders[column_name] > 0 ? 'asc' : 'dsc'"></span>
                        </div>
                        <input type="text" class="form-control" style="width: 60%" v-model="filters[column_name]" v-on:keyup="filterGames" title="search"/>
                    </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in dataTable" class="row-table">
                    <td v-for="value in columnsTable" class="item-table">
                        {{item[value]}}
                    </td>
                    <td class="row-controls item-table">
                        <button @click="deleteGame(item['ID'])" class="btn btn-sm btn-danger" title="Delete Game">
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
        data () {
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
                filters: [],
                orders: []
            };
        },
        methods: {
            deleteGame (id) {
                if (confirm('Do you really want to delete this game?')) {
                    axios.post('/game/delete/' + id).then(response => {
                        this.alert.isShowAlert = true;
                        this.alert.alertMessage = response.data.msg;
                        this.alert.alertSuccess = response.data.success;
                        this.getDataTable();
                    });
                }
            },
            getDataTable () {
                let vm = this;
                axios.post('/game/get', {
                    currentPage: vm.currentPage,
                    perPage: vm.perPage,
                    filters: vm.gridFilters,
                    orders: vm.gridOrders
                }).then(response => {
                    vm.dataTable = response.data.data;
                    vm.countPages = response.data.page_count;
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
            filterGames () {
                this.currentPage = 1;
                this.getDataTable();
            },
            orderGames (column_name) {
                this.orders[column_name] = this.orders[column_name] * -1;
                this.getDataTable();
            }
        },
        created () {
            let vm = this;
            axios.post('/game/get', {
                currentPage: vm.currentPage,
                perPage: vm.perPage,
                filters: vm.gridFilters,
                orders: vm.gridOrders
            }).then(response => {
                vm.dataTable = response.data.data;
                vm.countPages = response.data.page_count;
                vm.columnsTable = response.data.columns;
            });
        },
        computed: {
            gridFilters () {
                let filters = {};
                let vm = this;
                this.columnsTable.forEach(function (key) {
                    filters[key] = vm.filters[key];
                });
                return filters;
            },
            gridOrders () {
                let orders = {};
                let vm = this;
                this.columnsTable.forEach(function (key) {
                    orders[key] = vm.orders[key];
                });
                return orders;
            }
        },
        watch: {
            columnsTable (val) {
                let sortOrders = {};
                val.forEach(function (key) {
                    sortOrders[key] = 1
                });

                this.orders = sortOrders;
            }
        },
        components: {
            FormAlert
        }
    }
</script>