<template>
  <v-container class="grey lighten-5">
    <v-row
        class='justify-center'
        no-gutters
    >
      <v-col cols="6" >
        <v-card>
          <v-card-title>
            <span class="text-h5">{{ title }}</span>
          </v-card-title>

          <v-card-text>
            <v-text-field
                v-model="user.email"
                label="Email"
            >
            </v-text-field>
            <v-text-field
                v-model="user.password"
                type="password"
                label="Password"
            >
            </v-text-field>

            <v-text-field
                v-model="user.telegramToken"
                label="Telegram"
            >
            </v-text-field>
            <v-select
                v-model="user.role"
                :items="roles"
                chips
                label="Roles"
                multiple
                outlined
            ></v-select>
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
      </v-col>
    </v-row>
  </v-container>

</template>

<script>
import axiosInstance from "../requestService";

export default {
  name: "UserEdit",
  data: () => ({
    loading: false,
    editMode: false,
    user:{
      email: '',
      password: '',
      role: [],
      telegramToken: '',
    },
    roles: [
        'ROLE_USER',
        'ROLE_ADMIN',
        'ROLE_GUIDE'
    ]
  }),
  computed: {
    title() {
      if (this.editMode) {
        return 'Редактирование пользователя'
      }
      return 'Создание нового пользователя'
    },
  },
  mounted() {
    if (this.$route.params.id) {
      this.getUserInfo()
      this.editMode = true
    }
  },
  methods: {
    getUserInfo(){
      axiosInstance.get(`/api/user/get-user-info/${this.$route.params.id}`)
          .then((response) => {
            this.user = response.data
          })
          .catch((response) => {
            console.error(response)
          })
    },
    save(){
      if (this.editMode){
        axiosInstance.post(`/api/user/edit`, this.user)
            .then((response) => {
              this.$router.push({path: `/admin/users`});
            })
            .catch((response) => {
              alert("Ошибка создания юзера");
            })
      }else{
        axiosInstance.post(`/api/user/create`, this.user)
            .then((response) => {
              this.$router.push({path: `/admin/users`});
            })
            .catch((response) => {
              alert("Ошибка создания юзера");
            })
      }

    },
    close(){
      this.$router.push({path: `/admin/users`});
    }
  }
}
</script>

<style scoped>

</style>