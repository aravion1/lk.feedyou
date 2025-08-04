
const user = {
    isAuth: function () {
        return localStorage.getItem('auth') == 'true';
    },
    getToken: function () {
        return localStorage.getItem('token') ?? null;
    },
    data: {},
    logout: function () {
        localStorage.removeItem('auth');
        localStorage.removeItem('token');
        window.location.reload()
    }
}

export default user
