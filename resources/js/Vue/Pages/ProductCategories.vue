<template>
    <Header :active="'produсt_categories'"></Header>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light">
            <button class="btn btn-outline-success" ref="open_modal_button" type="button" data-bs-toggle="modal" data-bs-target="#create_product_category_modal">Добавить категорию
            </button>
        </nav>
        <form class="form-inline d-flex flex-row">
            <input v-model="search" class="form-control mr-sm-2" type="search" placeholder="Поиск" aria-label="Search">
            <input type="btn" v-on:click="filter" class="btn btn-outline-info" value="Поиск">
        </form>
    </div>

    <div class="container bg-light">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Описание</th>
                <th>Действие</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, key) in filtered_items">
                <td>{{ item.id }}</td>
                <td>{{ item.title }}</td>
                <td>{{ item.description.length > 10 ? item.description.slice(0, 10) + '...' : item.description }}</td>
                <td class="d-flex justify-content-around">
                    <a v-on:click="openEditModal(key)" type="button" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path
                                d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"></path>
                        </svg>
                    </a>
                    <button v-on:click="deleteCategory(key)" type="button" class="btn ml-2 btn-outline-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                             class="bi bi-trash" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"></path>
                            <path
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"></path>
                        </svg>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Сама модалка -->
    <div class="modal fade" id="create_product_category_modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Добавить категорию</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Заголовок</label>
                            <input class="form-control" v-model="edit_category.title" placeholder="Молочные...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Описание категории</label>
                            <textarea class="form-control" v-model="edit_category.description"
                                      placeholder="Молочные..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" ref="close_modal_button" class="btn btn-secondary" v-on:click="closeModal"
                            data-bs-dismiss="modal">Закрыть
                    </button>
                    <button type="button" class="btn btn-success" v-on:click="save">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Header from "./Components/Header.vue";
import api from "../../request.js";

export default {
    components: {Header},
    data: function () {
        return {
            edit_category: {
                id: null,
                title: null,
                description: null
            },
            filtered_items: [],
            search: '',
            items: []
        }
    },
    methods: {
        closeModal: function () {
            this.edit_category = {
                id: null,
                title: null,
                description: null
            }
            this.$refs.close_modal_button.click();
        },
        save: function () {
            let self = this;
            api.post('/product_categories/save', self.edit_category).then(function (response) {
                self.closeModal();
                self.getAllItems();
            }).catch(function (err) {
                alert(err)
            })
        },
        getAllItems: function () {
            let self = this;
            api.get('/product_categories/list').then(function (res) {
                self.items = self.filtered_items = res.data.data;
            }).catch(function (err) {
                alert(err);
            })
        },
        deleteCategory: function (key) {
            let self = this;
            api.delete('/product_categories/' + self.items[key].id).then(function () {
                self.getAllItems()
            }).catch(function (err) {
                alert(err)
            })
        },
        openEditModal(key) {
            this.$refs.open_modal_button.click();
            Object.assign(this.edit_category, this.items[key])
        },
        filter: function () {
            let self = this;
            if (this.search.length < 1) {
                this.filtered_items = this.items
                return
            }
            this.filtered_items = self.items.filter((item) => item.title.toLowerCase().includes(self.search.toLowerCase()) || item.description.toLowerCase().includes(self.search.toLowerCase()))
        }
    },
    mounted() {
        this.getAllItems();
    },
}
</script>
