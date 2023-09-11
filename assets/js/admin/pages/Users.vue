<template>
  <v-data-table
      :headers="headers"
      :items="users"
      sort-by="name"
      class="elevation-1 order__list"
      :loading="loading"
      loading-text="Loading... Please wait"
  >
    <template v-slot:top>
      <v-toolbar
          flat
      >
        <v-toolbar-title>Список пользователей</v-toolbar-title>
        <v-divider
            class="mx-4"
            inset
            vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-btn
            color="primary"
            dark
            class="mb-2"
            @click="addUser"
        >
          Добавить
        </v-btn>
      </v-toolbar>
    </template>
    <template v-slot:item.role="{ item }">
      <v-chip
          v-for="roleName in item.role"
          class="ma-2"
          color="primary"
          small
      >
        {{ roleName }}
      </v-chip>
    </template>
    <template v-slot:item.actions="{ item }">
      <v-icon
          small
          class="mr-2"
          @click="editUser(item)"
      >
        mdi-pencil
      </v-icon>
    </template>
  </v-data-table>
</template>

<script>
import axiosInstance from "../requestService";

export default {
  name: "Users",
  data: () => ({
    loading: false,
    dialogCreate: false,
    users: [],
    headers: [
      { text: 'Email', value: 'email', align: 'start' },
      { text: 'Роль', value: 'role' },
      { text: 'Telegram', value: 'telegramToken' },
      { text: 'Actions', value: 'actions', sortable: false },
    ]
  }),
  mounted() {
    this.getUsers()
  },
  methods:{
    getUsers(){
      this.loading = true
      axiosInstance.get(`/api/user/get-users`)
          .then((response) => {
            this.users = response.data
          })
          .catch((response) => {
            alert("Ошибка загрузки списка пользователей");
          })
          .finally(() => {
            this.loading = false
          })
    },
    addUser(){
      this.$router.push({path: `/admin/user/form`});
    },
    editUser(item){
      this.$router.push({path: `/admin/user/${item.id}/edit`});
    }
  }
}
</script>

<style scoped>

</style>