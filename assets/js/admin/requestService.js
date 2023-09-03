import axios from 'axios';
import router from "./router";
import AuthService from "./auth.service";

const axiosInstance = axios.create({
    baseURL: 'http://localhost:8080',
});


axiosInstance.interceptors.request.use(
    (config) => {
        const token = localStorage.getItem('token');
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
        return config;
    },
    (error) => {
        return Promise.reject(error);
    }
);

axiosInstance.interceptors.response.use(
    (response) => {
        return response;
    },
    (error) => {
        console.log(error.response)
        if (error.response.data.code === 401) {
            AuthService.logout()
            router.push('/admin/login');
        }
        return Promise.reject(error);
    }
);

export default axiosInstance;
