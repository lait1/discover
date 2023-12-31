<template>
  <v-app id="inspire">
    <v-navigation-drawer
        app
        dark
        permanent
    >
      <v-sheet
          color="dark lighten-4"
          class="pa-4"
      >
        <v-avatar
            class="mb-4"
            color="indigo"
            size="64"
        >
          <v-icon dark>
            mdi-account-circle
          </v-icon>
        </v-avatar>

      </v-sheet>

      <v-divider></v-divider>
      <v-list>
        <router-link
            v-for="item in items"
            :key="item.title"
            :to="item.link"
        >
          <v-list-item
              link
          >
            <v-list-item-icon>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-content>
              <v-list-item-title>
                {{ item.title }}
              </v-list-item-title>
            </v-list-item-content>

          </v-list-item>
        </router-link>
      </v-list>
      <template v-slot:append>
        <div class="pa-2">
          <v-btn block @click="logout">
            Logout
          </v-btn>
        </div>
      </template>
    </v-navigation-drawer>

    <v-app-bar app>
      <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
    </v-app-bar>

    <v-main>
      <router-view></router-view>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "LayoutComponent",
  data() {
    return {
      drawer: false,
      items: [
        { title: 'Мой календарь', icon: 'mdi-calendar-account-outline', link: '/admin/profile' },
        { title: 'Туры', icon: 'mdi-view-list', link: '/admin/tours' },
        { title: 'Заказы', icon: 'mdi-cash', link: '/admin/orders' },
        { title: 'Комментарии', icon: 'mdi-view-dashboard', link: '/admin/comments' },
        { title: 'Клиенты', icon: 'mdi-account-group', link: '/admin/clients' },
        { title: 'Users', icon: 'mdi-account-box', link: '/admin/users' },
        { title: 'Setting site', icon: 'mdi-security', link: '/admin/settings' },
      ]
    };
  },
  methods:{
    logout() {
      this.$emit('logout');
    }
  }
}
</script>

<style scoped lang="scss">
.v-application a{
  color: #ffffff;
  text-decoration: none;
}
</style>