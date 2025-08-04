<template>
    <div class="auth-form">
        <div class="form-title-block">
            <h1>АВТОРИЗАЦИЯ</h1>
        </div>
        <div class="form-body-block">
            <form>
                <div class="input-group">
                    <label>Логин</label>
                    <input type="text" >
                </div>
            </form>
        </div>
        <div class="form-button-block"></div>
    </div>
</template>

<script>
export default  {
    data: function () {
        return {
            form: {
                login: '',
                password: ''
            }
        }
    }
}
</script>
