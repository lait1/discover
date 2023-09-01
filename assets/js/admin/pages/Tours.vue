<template>
  <v-app id="inspire">
    <v-data-table
        :headers="headers"
        :items="tours"
        sort-by="name"
        class="elevation-1"
        :loading="loading"
        loading-text="Loading... Please wait"
    >
      <template v-slot:top>
        <v-toolbar
            flat
        >
          <v-toolbar-title>Доступные туры</v-toolbar-title>
          <v-divider
              class="mx-4"
              inset
              vertical
          ></v-divider>
          <v-spacer></v-spacer>

          <v-dialog
              v-model="dialogCreate"
              max-width="500px"
          >
            <template v-slot:activator="{ props }">
              <v-btn
                  color="primary"
                  dark
                  class="mb-2"
                  @click="addTour"
              >
                Добавить тур
              </v-btn>
            </template>
            <v-card>
              <v-card-title>
                <span class="text-h5">Создание</span>
              </v-card-title>

              <v-card-text>
                <v-text-field
                    v-model="tour.name"
                    label="Название тура"
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
          </v-dialog>

          <v-dialog v-model="dialogDelete" max-width="500px">
            <v-card>
              <v-card-title class="text-h5">Are you sure you want to delete this item?</v-card-title>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
                <v-btn color="blue darken-1" text @click="deleteItemConfirm">OK</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
      </template>
      <template v-slot:item.categories="{ item }">
        <v-chip
            v-for="category in item.categories"
            class="ma-2"
            color="primary"
            small
        >
          {{ category.name }}
        </v-chip>
      </template>
      <template v-slot:item.public="{ item }">
        <v-simple-checkbox
            v-model="item.public"
            disabled
        ></v-simple-checkbox>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-icon
            small
            class="mr-2"
            @click="editItem(item)"
        >
          mdi-pencil
        </v-icon>
        <v-icon
            small
            @click="deleteItem(item)"
        >
          mdi-delete
        </v-icon>
      </template>
    </v-data-table>
  </v-app>
</template>

<script>
import axiosInstance from "../requestService";

export default {
  name: "Tours",
  data: () => ({
    loading: false,
    dialogCreate: false,
    dialogDelete: false,
    tour:{
      name: ''
    },
    editedIndex: -1,
    tours: [],
    headers: [   {
      text: 'Название',
      align: 'start',
      sortable: false,
      value: 'name',
    },
      { text: 'Цена', value: 'price' },
      { text: 'Продолжительность', value: 'longTime' },
      { text: 'Категории', value: 'categories' },
      { text: 'Открыт', value: 'public' },
      { text: 'Actions', value: 'actions', sortable: false },]
  }),
  mounted() {
    this.getTours()
  },
  methods: {
    getTours() {
      this.loading = true
      axiosInstance.get(`/api/tour/get-tour-list/`)
          .then((response) => {
            this.tours = response.data
          })
          .catch((response) => {
            alert("Ошибка загрузки туров");
          })
          .finally(() => {
            this.loading = false
          })
    },
    addTour(){
      this.dialogCreate = true
    },
    editItem (item) {
      this.$router.push({path: `/admin/tour/${item.id}/edit`});
    },
    deleteItem (item) {
      this.editedIndex = this.tours.indexOf(item)
      // this.editedItem = Object.assign({}, item)
      this.dialogDelete = true
    },

    deleteItemConfirm () {
      this.tours.splice(this.editedIndex, 1)
      this.closeDelete()
    },

    closeDelete() {
      this.dialogDelete = false
    },

    close () {
      this.dialogCreate = false
    },

    save () {
      axiosInstance.post(`/api/tour/create-tour`, this.tour)
          .then((response) => {
            if (response.data.message === 'success'){
              this.$router.push({path: `/admin/tour/${response.data.tourId}/edit`});
            }
          })
          .catch((response) => {
            console.log(response)
            alert("Ошибка создания тура");
          })
          .finally(() => {
            this.loading = false
          })
    },
  }
}
</script>

<style scoped>

</style>