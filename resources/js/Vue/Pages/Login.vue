<template>
    <div class="auth-form">
        <div v-if="error_mesage.length != 0" class="alert alert-primary" role="alert">
            {{error_mesage}}
        </div>
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Логин</label>
                <input type="text" v-model="form.login" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Пароль</label>
                <input type="password" v-model="form.password" class="form-control" id="exampleInputPassword1">
            </div>
            <input type="btn" value="Войти" v-on:click="auth" class="btn btn-primary">
        </form>
    </div>
</template>

<script>
import api from "../../request.js";
import user from "../../user.js";
export default  {
    data: function () {
        return {
            form: {
                login: '',
                password: ''
            },
            error_mesage: ''
        }
    },
    methods: {
        auth: function () {
            let self = this;
            api.post('/user/auth', this.form).then(function (response) {
                localStorage.setItem('auth', true);
                localStorage.setItem('token', response.data.token)
            }).catch(function (e) {
                self.error_mesage = e.error
            }).finally(function () {
                if (user.isAuth()) {
                    window.location.reload()
                }
            })
        }
    }
}
</script>
