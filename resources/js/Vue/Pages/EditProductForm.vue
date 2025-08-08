<template>
    <Header :active="'products'"></Header>
    <div class="container">
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Название продукта</label>
                <input type="text" v-model="form.name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Протеины/г</label>
                <input type="number" v-model="form.proteins" min="0" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Жиры/г</label>
                <input type="number" v-model="form.fats" min="0" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Углеводы/г</label>
                <input type="number" v-model="form.carbs" min="0" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Ккал</label>
                <input type="number" v-model="form.ccal" min="0" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Мера измерения</label>
                <select v-model="form.meas_value" class="form-select" aria-label="Default select example">
                    <option value="0"> - </option>
                    <option value="1">г</option>
                    <option value="2">мл</option>
                </select>
            </div>
            <div class="mb-3 mw-100">
                <ul v-if="old_form.img" v-for="img in old_form.img" class="list-group">
                    <li v-for="item in img" class="list-group-item d-flex justify-content-evenly">
                        <img :src="item" width="50" height="50">
                        <button v-on:click="deleteImage(item)" type="button" class="btn btn-outline-danger"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"></path><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"></path></svg></button>
                    </li>
                </ul>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Добавить изображение</label>
                <input v-on:change="addFile" class="form-control" type="file" id="formFile">
            </div>
            <input type="btn" v-on:click="update" v-if="isFormUpdate" class="btn btn-primary" value="Обновить">
            <input type="btn" v-on:click="create" v-else class="btn btn-primary" value="Добавить">
        </form>
    </div>
</template>
<script>
import Header from "./Components/Header.vue";
import api from "../../request.js";
export default {
    components: {Header},
    data: function () {
        return {
            form: {
                name: '',
                proteins: '',
                fats: '',
                carbs: '',
                ccal: '',
                meas_value: 0,
                img: null
            },
            old_form: {
                name: '',
                proteins: '',
                fats: '',
                carbs: '',
                ccal: '',
                meas_value: 0,
                img: null
            },
            isFormUpdate: false,
            id: null
        }
    },
    methods: {
        addFile: function (event) {
            this.form.img = event.target.files[0]
        },
        getData: function (id) {
            let self = this;
            api.get(`/products/get-by-id/${id}`).then(function (resp) {
                self.old_form = resp.data.data;
                self.form.name = self.old_form.name
                self.form.proteins = self.old_form.proteins
                self.form.fats = self.old_form.fats
                self.form.carbs = self.old_form.carbs
                self.form.ccal = self.old_form.ccal
                self.form.meas_value = self.old_form.meas_value
            }).catch(function (e) {
                alert(e)
            })
        },
        update: function () {
            const formData = {}
            for (let i in this.form) {
                if (this.form[i] == this.old_form[i]) {
                    continue;
                }
                formData[i] = this.form[i];
            }
            console.log(formData);
            api.post(`/products/${this.id}`, formData).then(function () {
                alert("Обеовлено");
                window.location.href = '/products'
            }).catch(function (e) {
                alert("Ошибка:" + e)
            })
        },
        create: function () {
            api.post(`/products/create`, this.form).then(function () {
                alert("Создано");
                window.location.href = '/products'
            }).catch(function (e) {
                alert("Ошибка:" + e)
            })
        },
        deleteImage: function (path) {
            let self = this;
            api.post('/products/image', {path: path}).then(function () {
                alert('Изображение: ' + path + ' удалено');
                self.getData(self.id)
            }).catch(function (e) {
                alert('Ошибка:' + e);
            })
        }
    },
    mounted() {
        let params = new URLSearchParams(document.location.search)
        let id = params.get('id');
        this.isFormUpdate = id ? true : false;

        if (this.isFormUpdate) {
            this.getData(id)
            this.id = id;
        }
    }
}
</script>
