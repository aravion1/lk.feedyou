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
            <div class="mb-3">
                <label for="formFile" class="form-label">Добавить изображение</label>
                <input v-model="form.img_list" class="form-control" type="file" id="formFile">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</template>
<script>
import Header from "./Components/Header.vue";
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
                img_list: null
            },
            old_form: {

            }
        }
    }
}
</script>
