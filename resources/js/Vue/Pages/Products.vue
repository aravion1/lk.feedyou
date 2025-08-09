<template>
    <Header :active="'products'"></Header>

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="/products/edit" class="btn btn-outline-success" type="button">Добавить продукт</a>

            <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarColor01">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <select v-on:change="setPage(1)" v-model="take" class="form-select" aria-label="Default select example">
                            <option value="10">Кол-во продуктов на странцие: 10</option>
                            <option value="25">Кол-во продуктов на странцие: 25</option>
                            <option value="50">Кол-во продуктов на странцие: 50</option>
                            <option value="100">Кол-во продуктов на странцие: 100</option>
                        </select>
                    </li>
                    <li class="nav-item" style="margin-left: 15px; margin-right: 15px">
                        <div class="form-check form-switch align-items-center">
                            <input v-on:change="setPage(1)" v-model="showOnlyNotFillProperties" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault">
                            <label class="form-check-label" for="flexSwitchCheckDefault">Только с не заполнеными свойствами</label>
                        </div>
                    </li>

                </ul>
                <form class="form-inline d-flex flex-row">
                    <input v-model="search" class="form-control mr-sm-2" type="search" placeholder="Поиск" aria-label="Search">
                    <input type="btn" v-on:click="setPage(1)" class="btn btn-outline-info" value="Поиск">
                </form>
            </div>
        </nav>
    </div>

    <div class="container bg-light">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Белки/г</th>
                    <th>Жиры/г</th>
                    <th>Углеводы/г</th>
                    <th>Ккал</th>
                    <th>Мера</th>
                    <th>Изображения</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(product, key) in products">
                    <td>{{product.id}}</td>
                    <td>{{product.name}}</td>
                    <td>{{product.proteins}}</td>
                    <td>{{product.fats}}</td>
                    <td>{{product.carbs}}</td>
                    <td>{{product.ccal}}</td>
                    <td v-if="product.meas_value == 0"> - </td>
                    <td v-else-if="product.meas_value == 1"> г </td>
                    <td v-else> мл </td>
                    <td>
                        <ul v-for="img in product.img" class="list-group">
                            <li v-for="item in img" class="list-group-item d-flex justify-content-evenly">
                                <img :src="item" width="50" height="50">
                                <button v-on:click="deleteImage(item)" type="button" class="btn btn-outline-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"></path><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"></path></svg></button>
                            </li>
                        </ul>
                    </td>
                    <td class="d-flex justify-content-evenly">
                        <a :href="'/products/edit?id=' + product.id" type="button" class="btn btn-success">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"></path>
                            </svg>
                        </a>
                        <button v-on:click="deleteProduct(key)" type="button" class="btn btn-outline-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"></path>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true" v-on:click="setPage(page - 1)">&laquo;</span>
                    </a>
                </li>
                <li class="page-item" v-on:click="setPage(i)" v-for="i in pages" :class="{active: i == page}"><a class="page-link" href="#">{{i}}</a></li>
                <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span v-on:click="setPage(page + 1)" aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import Header from "./Components/Header.vue";
import api from "../../request.js";
export default {
    data: function() {
        return {
            page: 1,
            products: [],
            count: 0,
            pages: [],
            allPageCount: 0,
            take: 10,
            showOnlyNotFillProperties: false,
            search: ''
        }
    },
    components: {Header},
    methods: {
        getProducts: function () {
            let getRow = `take=${this.take}&showOnlyNotFillProperties=`;
            getRow += this.showOnlyNotFillProperties ? 1 : 0;
            if (this.search.length != 0) {
                getRow += `&search=${this.search}`
            }
            let self = this;
            let page = this.page ?? 1;
            api.get(`/products/list/${page}?${getRow}`).then(function (response) {
                let response_data = response.data.data;
                self.products = response_data.list;
                self.count = response_data.count;
                self.allPagesCount = Math.ceil(self.count / self.take);
                self.pages = [];
                let final = self.page + 3;
                if (final > self.allPagesCount) {
                    final = self.allPagesCount - self.page
                }
                let start = self.page - 2;
                if (start < 1) {
                    start = 1
                    final = self.allPagesCount < 6 ? self.allPagesCount + 1 : 6;
                }
                for (let i = start; i < final; i++) {
                    self.pages.push(i)
                }

            })
        },
        setPage: function (page) {
            if (!(page < 0 || page > this.allPagesCount)) {
                page = 1;
            }

            this.setFilter();
            this.page = +page
            localStorage.setItem('product-page', page);
            const url = new URL(window.location.href)
            url.searchParams.set('page', page);
            history.pushState(null, "", url);
            this.getProducts();
        },
        setFilter: function () {
            localStorage.setItem('takeProduct', this.take);
            localStorage.setItem('showOnlyNotFillPropertiesProduct', this.showOnlyNotFillProperties);
            localStorage.setItem('search', this.search)
        },
        deleteProduct: function (key) {
            let deletedProduct = this.products[key];
            let isConfirmed = confirm(`Подтвердите удаление продукта с названием: [${deletedProduct.id}] - ${deletedProduct.name}` );
            if (isConfirmed) {
                let self = this;
                api.delete('/products/' + deletedProduct.id).then(function (response) {
                    self.getProducts();
                }).catch(function () {
                    alert('Произошла ошибка');
                })
            }
        },
        deleteImage: function (path) {
            let self = this;
            api.post('/products/image', {path: path}).then(function () {
                alert('Изображение: ' + path + ' удалено');
                self.getProducts();
            }).catch(function (e) {
                alert('Ошибка:' + e);
            })
        }
    },
    mounted() {
        let params = new URLSearchParams(document.location.search);
        this.page = +localStorage.getItem('product-page') ?? this.page;
        this.page = !params.get('page') !== 0 ? this.page : +params.get('page');

        this.take = localStorage.getItem('takeProduct') ?? 10;
        this.showOnlyNotFillProperties = localStorage.getItem('showOnlyNotFillPropertiesProduct') ?? false;
        this.search = localStorage.getItem('search') ?? '';
        this.getProducts();
    }

}
</script>
