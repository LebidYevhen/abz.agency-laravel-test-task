<template>
  <Nav/>
  <div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-6 text-center">Registration Form</h1>
    <form class="w-full max-w-lg mx-auto bg-white p-8 rounded-md shadow-md" @submit.prevent="submit">
      <p v-if="statusMessage" class="text-xl font-bold mb-6 text-center text-green-700">{{ statusMessage }}</p>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Name</label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
               type="text" id="name" name="name" placeholder="John Doe" v-model="form.name">
        <span class="block text-sm mt-2 text-red-700" v-if="form.fails?.name">{{ form.fails.name[0] }}</span>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
               type="email" id="email" name="email" placeholder="john@example.com" v-model="form.email">
        <span class="block text-sm mt-2 text-red-700" v-if="form.fails?.email">{{ form.fails.email[0] }}</span>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="phone">Phone</label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
               type="tel" id="phone" name="phone" placeholder="+380123456789" v-model="form.phone">
        <span class="block text-sm mt-2 text-red-700" v-if="form.fails?.phone">{{ form.fails.phone[0] }}</span>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2 flex items-center gap-2.5" for="position_id">Position
          ID
          <div
              class="group max-w-max h-4 w-4 relative flex flex-col items-center justify-center rounded-full text-gray-500 hover:bg-gray-200 hover:text-gray-600 cursor-pointer">
            <p class="w-4 h-4">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                <path
                    d="M464 256A208 208 0 1 0 48 256a208 208 0 1 0 416 0zM0 256a256 256 0 1 1 512 0A256 256 0 1 1 0 256zm169.8-90.7c7.9-22.3 29.1-37.3 52.8-37.3h58.3c34.9 0 63.1 28.3 63.1 63.1c0 22.6-12.1 43.5-31.7 54.8L280 264.4c-.2 13-10.9 23.6-24 23.6c-13.3 0-24-10.7-24-24V250.5c0-8.6 4.6-16.5 12.1-20.8l44.3-25.4c4.7-2.7 7.6-7.7 7.6-13.1c0-8.4-6.8-15.1-15.1-15.1H222.6c-3.4 0-6.4 2.1-7.5 5.3l-.4 1.2c-4.4 12.5-18.2 19-30.6 14.6s-19-18.2-14.6-30.6l.4-1.2zM224 352a32 32 0 1 1 64 0 32 32 0 1 1 -64 0z"/>
              </svg>
            </p>
            <div
                class="absolute bottom-0 mb-4 origin-bottom transform rounded text-white opacity-0 transition-all duration-300 group-hover:opacity-100 group-hover:pointer-events-auto pointer-events-none">
              <div class="flex max-w-xs flex-col items-center">
                <table class="border-collapse w-full">
                  <thead>
                  <tr>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                      Position ID
                    </th>
                    <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">
                      Position Name
                    </th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0"
                      v-for="position in positionsData">
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                      <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Position ID</span>
                      {{ position.id }}
                    </td>
                    <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                      <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Position Name</span>
                      {{ position.name }}
                    </td>
                  </tr>
                  </tbody>
                </table>
                <div class="clip-bottom h-2 w-4 bg-gray-900"></div>
              </div>
            </div>
          </div>
        </label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
               type="number" id="position_id" name="position_id" placeholder="1" v-model="form.position_id">

        <span class="block text-sm mt-2 text-red-700" v-if="form.fails?.position_id">{{
            form.fails.position_id[0]
          }}</span>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="position_id">Photo</label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
               type="file" id="photo" name="photo" ref="file" v-on:change="selectedFile = $event.target.files[0]">
        <span class="block text-sm mt-2 text-red-700" v-if="form.fails?.photo">{{ form.fails.photo[0] }}</span>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">Password</label>
        <input class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:border-indigo-500"
               type="password" id="password" name="password" placeholder="********" v-model="form.password">
        <span class="block text-sm mt-2 text-red-700" v-if="form.fails?.password">{{ form.fails.password[0] }}</span>
      </div>
      <button
          class="w-full bg-indigo-500 text-white text-sm font-bold py-2 px-4 rounded-md hover:bg-indigo-600 transition duration-300"
          type="submit">Register
      </button>
    </form>
  </div>
</template>

<script>
import {onMounted, reactive, ref} from 'vue'
import Nav from "../../Components/Nav.vue";
import axios from "axios";

export default {
  components: {Nav},
  setup() {
    const form = reactive({
      name: '',
      phone: '',
      email: '',
      password: '',
      position_id: '',
      photo: null,
      fails: null
    });

    const selectedFile = ref('');
    const statusMessage = ref('');
    const positionsData = ref('');

    onMounted(async () => {
      try {
        const response = await axios.get('/api/v1/positions');
        positionsData.value = response.data.positions;
      } catch (error) {
        console.error('Error fetching positions:', error);
      }
    });

    async function submit() {
      try {
        const formData = new FormData();
        formData.append('name', form.name);
        formData.append('phone', form.phone);
        formData.append('email', form.email);
        formData.append('password', form.password);
        formData.append('position_id', form.position_id);
        formData.append('photo', selectedFile.value);

        const response = await axios.post('/api/v1/users', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })

        Object.keys(form).forEach(key => {
          form[key] = null;
        });
        selectedFile.value = null;
        statusMessage.value = response.data.message;
      } catch (error) {
        form.fails = error.response.data.fails;
        statusMessage.value = '';
      }
    }

    return {form, selectedFile, submit, statusMessage, positionsData}
  }
}
</script>

<style>
.clip-bottom {
  clip-path: polygon(100% 50%, 0 0, 100% 0, 50% 100%, 0 0)
}
</style>