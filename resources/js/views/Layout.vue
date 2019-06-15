<template>
  <div>
    <div>
      <router-link to="/">Home</router-link>
      <router-link to="/about">About</router-link>
      <router-link to="/dashboard">Dashboard</router-link>
    </div>

    <div>
      <router-link to="/login">Login</router-link>
    </div>

    <div style="margin-top: 2rem">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {};
</script>

<style>
</style>
