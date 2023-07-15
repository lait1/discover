import axios from 'axios';

const API_URL = 'http://localhost:8080'; // Замените на URL вашего серверного API

class AuthService {
    login(credentials) {
        return axios
            .post(`${API_URL}/api/login_check`, credentials)
            .then(response => {
                // Получение токена из ответа
                const token = response.data.token;

                // Сохранение токена в localStorage или Vuex (в зависимости от ваших предпочтений)
                localStorage.setItem('token', token);

                return token;
            });
    }

    logout() {
        // Удаление токена из localStorage или Vuex
        localStorage.removeItem('token');
    }

    getToken() {
        // Получение токена из localStorage или Vuex
        return localStorage.getItem('token');
    }

    isAuthenticated() {
        // Проверка, авторизован ли пользователь на основе наличия токена
        const token = this.getToken();
        return !!token;
    }
}

export default new AuthService();