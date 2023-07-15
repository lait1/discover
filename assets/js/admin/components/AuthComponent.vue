<template>
  <div>
    <input v-model="username" type="text" placeholder="Username">
    <input v-model="password" type="password" placeholder="Password">
    <button @click="login">Login</button>
    <button @click="logout">Logout</button>
  </div>
</template>

<script>
import AuthService from "../auth.service";

export default {
  data() {
    return {
      username: '',
      password: ''
    };
  },
  methods: {
    login() {
      const credentials = {
        username: this.username,
        password: this.password
      };

      AuthService.login(credentials)
          .then(token => {
            // Аутентификация прошла успешно
            console.log('Logged in with token:', token);
          })
          .catch(error => {
            // Обработка ошибок аутентификации
            console.error(error);
          });
    },
    logout() {
      AuthService.logout();
      console.log('Logged out');
    }
  }
};
</script>
