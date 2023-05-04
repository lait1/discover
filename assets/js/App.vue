<template>

    <nav>
      <ul>
        <li><router-link to="/admin/test">Home</router-link></li>
        <li><router-link to="/admin/about">About</router-link></li>
      </ul>
    </nav>




  <div>{{ message }}</div>

  <router-view></router-view>
</template>

<script>
export default {
  data() {
    return {
      message: 'Hesllo Vue 3!'
    };
  }
};
</script>