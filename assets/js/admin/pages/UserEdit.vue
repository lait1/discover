<template>
    <v-card>
      <v-card-title>
        <span class="text-h5">Создание нового пользователя</span>
      </v-card-title>

      <v-card-text>
        <v-text-field
            v-model="user.email"
            label="Email"
        >
        </v-text-field>
        <v-text-field
            v-model="user.password"
            label="Password"
        >
        </v-text-field>

        <v-text-field
            v-model="user.telegram"
            label="Telegram"
        >
        </v-text-field>
      </v-card-text>

      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn
            color="success"
            @click="save"
        >
          Сохранить
        </v-btn>
        <v-btn
            color="blue-darken-1"
            @click="close"
        >
          Отмена
        </v-btn>
      </v-card-actions>
    </v-card>
</template>

<script>
export default {
  name: "UserEdit",
  data: () => ({
    loading: false,
    user:{
      email: '',
      password: '',
      roles: [],
      telegram: '',
    },
    roles: [
        'ROLE_USER',
        'ROLE_ADMIN',
        'ROLE_GUIDE'
    ]
  }),
  methods: {
    save(){

    },
    close(){
      this.$router.push({path: `/admin/users`});
    }
  }
}
</script>

<style scoped>

</style>