<script setup>
import { reactive } from "vue";
import MainLayout from "../../../../Layouts/MainLayout.vue";
import axios from "../../../../Services/axios";
import storage from "@/Services/storage"
import router from '@/router'
import { errorNotification,successNotification } from '@/Composable/notification'

const state = reactive({
  email: "admin@gmail.com",
  password: "p@ssword10",
});

const handleSubmit = async () => {
  const body = { ...state };

  try {
    const response = await axios.post("/login", body);

    storage.setItem("token", response.data.token);
    storage.setItem("user", response.data.user);

    successNotification('Successfully logged in.');
    return router.push({ name: "task" });

  } catch (error) {
    errorNotification('Unathorized, please try again!')
  }
};
</script>

<template>
  <MainLayout>
    <template #main>
      <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
        <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
              Sign in to your account
            </h1>
            <form class="space-y-4 md:space-y-6" @submit.prevent="handleSubmit">
              <div>
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                <input
                  v-model="state.email"
                  type="email"
                  name="email"
                  id="email"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                  placeholder="name@company.com"
                  required=""
                />
              </div>
              <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                <input
                  v-model="state.password"
                  type="password"
                  name="password"
                  id="password"
                  placeholder="••••••••"
                  class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                  required=""
                />
              </div>
             
              <button type="submit" class="btn-primary w-full justify-center">Sign in</button>
             
            </form>
          </div>
        </div>
      </div>
    </template>
  </MainLayout>
</template>
