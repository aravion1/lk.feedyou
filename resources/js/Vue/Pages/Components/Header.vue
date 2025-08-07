<template>
    <header>
        <div class="container">
            <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"><a href="/"
                                                                                               class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <span class="fs-4">Личный кабинет</span> </a>
                <ul class="nav nav-pills">
                    <li class="nav-item"><a href="/products" class="nav-link" v-bind:class="{active: active == 'products'}" aria-current="page">Продукты</a></li>
                    <li class="nav-item"><a v-on:click="logout" href="#" class="nav-link">Выйти</a></li>
                </ul>
            </header>
        </div>
    </header>
</template>

<script>
export default {
    props: {
        active: ''
    },
    methods: {
        logout: function () {
            localStorage.removeItem('auth');
            localStorage.removeItem('token');
        }
    }
}
</script>
