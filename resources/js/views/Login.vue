<template>
  <div>
    <h1>Login</h1>

    <p>
      <label for="username">Email</label>
      <input type="text" name="username" v-model="username">
    </p>

    <p>
      <label for="password">Password</label>
      <input type="password" name="password" v-model="password">
    </p>

    <button @click="login">Login</button>
  </div>
</template>

<script>
export default {
  data() {
    return {
      username: "",
      password: ""
    };
  },
  methods: {
    login() {
      let data = {
        username: this.username,
        password: this.password
      };

      axios
        .post("/api/login", data)
        .then(({ data }) => {
          // TODO: store data
          // data.token
          // data.
        })
        .catch(({ response }) => {
          alert(response.data.message);
        });
    }
  }
};
</script>