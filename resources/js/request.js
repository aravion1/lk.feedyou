import config from "./config.js";
import user from "./user.js";


const api = {
    host: config.API_HOST,
    post: function(url, data) {
        const config = {}
        if (user.isAuth() && user.getToken() != null) {
            let user_token = user.getToken()
            config.headers = {
                Authorization: `Bearer ${user_token}`
            }
        }
        return axios.post(this.host + url, data, config)
    },
    get: function (url) {
        const config = {}
        if (user.isAuth() && user.getToken() != null) {
            let user_token = user.getToken()
            config.headers = {
                Authorization: `Bearer ${user_token}`
            }
        }
        return axios.get(this.host + url, config);
    },
    delete: function (url) {
        const config = {}
        if (user.isAuth() && user.getToken() != null) {
            let user_token = user.getToken()
            config.headers = {
                Authorization: `Bearer ${user_token}`
            }
        }
        return axios.delete(this.host + url, config);
    }
}

export default api;
