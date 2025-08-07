import { createRouter, createWebHistory } from 'vue-router';
import Login from "../Vue/Pages/Login.vue";
import user from "../user.js";
import Dashboard from "../Vue/Pages/Dashboard.vue";
import Products from "../Vue/Pages/Products.vue";
import EditProductForm from "../Vue/Pages/EditProductForm.vue";
const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login,
    },
    {
        name: 'dashboard',
        path: '/',
        component: Dashboard
    },
    {
        name: 'products',
        path: '/products',
        component: Products
    },
    {
        name: 'edit_products',
        path: '/products/edit',
        component: EditProductForm
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach((to, from) => {
    if (user.isAuth() && to.name == 'login') {
        return {name: 'dashboard'}
    }

    if (!user.isAuth() && to.name != 'login') {
        return {name: 'login'}
    }
    return true;
})
export default router;
