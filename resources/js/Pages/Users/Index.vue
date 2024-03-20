<template>
  <Nav/>
  <div class="container mx-auto py-8">
    <button
        class="bg-indigo-500 text-white text-sm font-bold py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300"
        v-if="!users.length" @click="fetchData('http://127.0.0.1/api/v1/users?count=6')">Load Users
    </button>
    <ul class="flex flex-col gap-10 mb-8" v-if="users.length">
      <li v-for="user in users">
        <p>User id: {{ user.id }}</p>
        <p>User name: {{ user.name }}</p>
        <p>User email: {{ user.email }}</p>
        <p>User phone: {{ user.phone }}</p>
        <p>User position: {{ user.position }}</p>
        <p>User position_id: {{ user.position_id }}</p>
        <img :src="user.photo" alt="" width="70" height="70">
      </li>
    </ul>
    <button
        class="bg-indigo-500 text-white text-sm font-bold py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300"
        v-if="nextUrl" @click="fetchData(nextUrl)">Load More
    </button>
  </div>
</template>

<script>

import Nav from "../../Components/Nav.vue";

export default {
  components: {
    Nav,
  },
  data() {
    return {
      users: [],
      nextUrl: ''
    };
  },
  methods: {
    fetchData(url) {
      fetch(url, {
        method: "GET",
      })
          .then((response) => {
            response.json().then((data) => {
              this.users.push(...data.users);
              this.nextUrl = data.links.next_url
            });
          })
          .catch((err) => {
            console.error(err);
          });
    },
  },
};
</script>

<style>
button {
  padding: 12px 32px;
  font-size: 16px;
  border-radius: 8px;
  cursor: pointer;
}
</style>