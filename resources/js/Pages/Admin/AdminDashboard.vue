<template>
    <AuthenticatedLayout>
      <Head title="Admin Dashboard" />
  
      <div class="max-w-7xl mx-auto p-6 bg-white shadow sm:rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>
        <p>Всего пользователей: {{ totalUsers }}</p>
        <p>Всего проектов: {{ totalProjects }}</p>
        <p>Всего объявлений о работе: {{ totalJobAds }}</p>
  
        <!-- ссылки на другие разделы админки -->
        <div class="mt-6 space-x-4">
          <Link :href="route('admin.users.index')" class="btn bg-blue-500 text-white">
            Пользователи
          </Link>
          <Link :href="route('admin.projects.index')" class="btn bg-green-500 text-white">
            Проекты
          </Link>
          <Link :href="route('admin.jobAds.index')" class="btn bg-orange-500 text-white">
            Объявления о работе
          </Link>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { Head, Link } from '@inertiajs/vue3'
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
  
  // Получаем пропсы, переданные контроллером
  const props = defineProps({
    totalUsers: Number,
    totalProjects: Number,
    totalJobAds: Number,
  })
  </script>
  