<script setup>
import AdminLayout from '../../../Layouts/AdminLayout.vue';
import router from '@/router'

</script>
<template>
  <AdminLayout>
    <template #main>
      <div class="text-red border">Hello man from banner page.....!</div>
      <button class="btn-primary" @click="router.push({name: 'CreateBanner'})">go to create page</button>
    </template>
  </AdminLayout>
</template>
