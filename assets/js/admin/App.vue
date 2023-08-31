<template>

  <LayoutComponent
      v-if="this.isAuth"
      @logout="logout"
  >
  </LayoutComponent>
  <AuthComponent
      v-else
      @login="login"
  />

</template>

<script>

import AuthService from "./auth.service";
import AuthComponent from "./components/AuthComponent";
import LayoutComponent from "./components/LayoutComponent";

export default {
  components: {
    AuthComponent, LayoutComponent
  },
  data() {
    return {
      isAuth: false
    };
  },
  mounted() {
    this.isAuth = AuthService.isAuthenticated()
  },
  methods: {
    login(credentials) {
      AuthService.login(credentials)
          .then(token => {
            this.isAuth = true
            this.$router.push({path: '/admin/tours'});
          })
          .catch(error => {
            console.error(error);
          });
    },
    logout() {
      AuthService.logout();
      console.log('Logged out');
      this.isAuth = false
      this.$router.push({path: '/admin/login'});
    }
  }
};
</script>
