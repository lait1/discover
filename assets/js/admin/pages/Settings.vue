<template>
  <v-container>
    <v-row
        class='justify-center'
        no-gutters
    >
      <v-col cols="6">
        <v-card-title>
          <span class="text-h5">Соцсети</span>
        </v-card-title>
        <v-text-field
            v-model="settings.twitter"
            label="Twitter"
            maxlength="50"
            counter
            outlined
            required
        ></v-text-field>
        <v-text-field
            v-model="settings.youtube"
            label="Youtube"
            maxlength="100"
            counter
            outlined
            required
        ></v-text-field>
        <v-text-field
            v-model="settings.telegram"
            label="Telegram"
            maxlength="50"
            counter
            outlined
            required
        ></v-text-field>
        <v-text-field
            v-model="settings.whatsapp"
            label="Whatsapp"
            maxlength="50"
            counter
            outlined
            required
        ></v-text-field>
        <v-text-field
            v-model="settings.instagram"
            label="Instagram"
            maxlength="50"
            counter
            outlined
            required
        ></v-text-field>

        <v-card-title>
          <span class="text-h5">Другое</span>
        </v-card-title>
        <v-text-field
            v-model="settings.email"
            label="Email"
            maxlength="50"
            outlined
            counter
            required
        ></v-text-field>
        <v-btn
            class="mr-4"
            color="success"
            @click="updateInfo"
        >
          Сохранить
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
import axiosInstance from "../requestService";

export default {
  name: "Settings",
  data: function () {
    return {
      settings: {
        twitter: '',
        youtube: '',
        telegram: '',
        whatsapp: '',
        instagram: '',
        email: '',
      },
    }
  },
  mounted() {
    this.getInfo()
  },
  methods: {
    getInfo(){
      axiosInstance.get(`/api/setting/get-settings`)
          .then((response) => {
            response.data.forEach(item => {
              const name = item.name;
              const value = item.value;

              if (this.settings.hasOwnProperty(name)) {
                this.settings[name] = value;
              }
            });
          })
          .catch((response) => {
            console.error(response)
            alert("Ошибка загрузки категорий");
          })
    },
    updateInfo(){
      axiosInstance.post(`/api/setting/update`, this.settings)
          .then((response) => {
            if (response.data.message === 'success'){
              alert("Данные успешно обновлены");
            }
          })
          .catch((response) => {
            console.error(response)
            alert("Save tour failed");
          })
    }

  }
}
</script>

<style scoped>

</style>