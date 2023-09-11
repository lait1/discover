<template>
  <v-app >
  <v-sheet width="300" class="ma-auto">
    <v-form fast-fail @submit.prevent>
      <v-text-field
          v-model="userLogin"
          label="Login"
          :rules="userLoginRules"
      ></v-text-field>
        <v-text-field
            v-model="password"
            :append-icon="'mdi-eye'"
            :rules="[passwordRules.required, passwordRules.min]"
            :type="'password'"
            name="input-10-1"
            label="Password"
            hint="At least 8 characters"
            counter
        ></v-text-field>

      <v-btn type="submit" block class="mt-2" @click="login">Enter</v-btn>
    </v-form>
  </v-sheet>
  </v-app>
</template>

<script>
export default {
  name: "AuthComponent",
  data: () => ({
    userLogin: '',
    userLoginRules: [
      value => {
        if (value?.length > 3) return true

        return 'First name must be at least 3 characters.'
      },
    ],
    password: '',
    passwordRules: {
      required: value => !!value || 'Required.',
      min: v => v.length >= 6 || 'Min 6 characters',
      emailMatch: () => (`The email and password you entered don't match`),
    },
  }),
  methods: {
    login() {
      const credentials = {
        username: this.userLogin,
        password: this.password
      };

      this.$emit('login', credentials);
    },

  }
};
</script>
