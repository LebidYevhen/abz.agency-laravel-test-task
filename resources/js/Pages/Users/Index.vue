<template>
  <Nav/>
  <div class="container mx-auto py-8">
    <button
        class="bg-indigo-500 text-white text-sm font-bold py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300 block mx-auto"
        v-if="!users.length" @click="fetchData('/api/v1/users?count=6')">Load Users
    </button>
    <table class="border-collapse w-full mb-8" v-if="users.length">
      <thead>
      <tr>
        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
          User ID
        </th>
        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
          User Name
        </th>
        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
          User Email
        </th>
        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
          User Phone
        </th>
        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
          User Position
        </th>
        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
          User Position ID
        </th>
        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
          User Photo
        </th>
      </tr>
      </thead>
      <tbody>
      <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0"
          v-for="user in users">
        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
          <span
              class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">User ID</span>
          {{ user.id }}
        </td>
        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
          <span
              class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">User Name</span>
          {{ user.name }}
        </td>
        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
          <span
              class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">User Email</span>
          {{ user.email }}
        </td>
        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
          <span
              class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">User Phone</span>
          {{ user.phone }}
        </td>
        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
          <span
              class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">User Position</span>
          {{ user.position }}
        </td>
        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
          <span
              class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">User Position ID</span>
          {{ user.position_id }}
        </td>
        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
          <span
              class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">User Photo</span>
          <img class="mx-auto" :src="user.photo" alt="" width="70" height="70">
        </td>
      </tr>
      </tbody>
    </table>
    <button
        class="bg-indigo-500 text-white text-sm font-bold py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300 block mx-auto"
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