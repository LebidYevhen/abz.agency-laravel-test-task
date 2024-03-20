<template>
  <div class="container mx-auto">
    <div class="bg-white">
      <nav class="flex flex-col justify-center sm:flex-row">
        <Link v-for="item in navigation" :href="route(item.route)"
              class="text-gray-600 py-4 px-6 block hover:text-blue-500 focus:outline-none"
              :class="{ 'text-blue-500 border-b-2 font-medium border-blue-500': route().current() === item.route }">
          {{ item.name }}
        </Link>
      </nav>
    </div>
  </div>
</template>

<script>

import {Link} from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link
  },
  data() {
    return {
      navigation: [
        {name: 'Users', route: 'users.index'},
        {name: 'Create a new user', route: 'users.create'},
      ]
    }
  }
}
</script>

<style scoped>

</style>