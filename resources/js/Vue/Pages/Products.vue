<template>
    <Header :active="'products'"></Header>
    <div class="container">
        <nav class="navbar navbar-light bg-white mb-2">
            <form class="form-inline">
                <a href="/products/edit" class="btn btn-outline-success" type="button">Добавить продукт</a>
            </form>
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
                    <td>{{product.meas_value}}</td>
                    <td>{{product.img_list.join('<\br>')}}</td>
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
            allPageCount: 0
        }
    },
    components: {Header},
    methods: {
        getProducts: function () {
            let self = this;
            api.get('/products/list/' + this.page).then(function (response) {
                let response_data = response.data.data;
                self.products = response_data.list;
                self.count = response_data.count;
                self.allPagesCount = self.count / 10;
                self.pages = [];
                if (self.page <= 5) {
                    self.pages.push(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
                } else {
                    let final = self.page + 5;
                    if (final > self.allPagesCount) {
                        final = self.allPagesCount - self.page
                    }
                    let start = self.page - 5;
                    for (let i = start; i < final; i++) {
                        self.pages.push(i)
                    }
                }

            })
        },
        setPage: function (page) {
            if (!(page < 0 || page > this.allPagesCount)) {
                this.page = page
                this.getProducts();
            }
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
    },
    mounted() {
        let params = new URLSearchParams(document.location.search);
        this.page = params.get("page") ?? this.page;

        this.getProducts();
    }

}
</script>
