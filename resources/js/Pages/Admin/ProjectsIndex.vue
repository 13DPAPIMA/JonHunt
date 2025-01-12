<template>
    <AuthenticatedLayout>
      <Head title="Projects Management" />
  
      <div class="max-w-7xl mx-auto p-6 bg-white shadow sm:rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Проекты</h1>
  
        <!-- Таблица проектов -->
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-6 py-3 text-left">ID</th>
              <th class="px-6 py-3 text-left">Название</th>
              <th class="px-6 py-3 text-left">Описание</th>
              <th class="px-6 py-3 text-left">Бюджет</th>
              <th class="px-6 py-3 text-left">Действия</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="project in projects.data" :key="project.id">
              <td class="px-6 py-4">{{ project.id }}</td>
              <td class="px-6 py-4">{{ project.title }}</td>
              <td class="px-6 py-4">
                {{ project.description }}
              </td>
              <td class="px-6 py-4">
                {{ project.budget }} $
              </td>
              <td class="px-6 py-4">
                <button
                  @click="deleteProject(project.id)"
                  class="text-red-600 hover:text-red-800"
                >
                  Удалить
                </button>
              </td>
            </tr>
          </tbody>
        </table>
  
        <!-- Пагинация -->
        <div class="mt-4 flex items-center space-x-2">
          <button
            :disabled="!projects.links.prev"
            @click="goTo(projects.links.prev)"
            class="px-3 py-2 bg-gray-300 text-sm rounded disabled:opacity-50"
          >
            Предыдущая
          </button>
          <button
            :disabled="!projects.links.next"
            @click="goTo(projects.links.next)"
            class="px-3 py-2 bg-gray-300 text-sm rounded disabled:opacity-50"
          >
            Следующая
          </button>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { defineProps } from 'vue'
  import { Head, router } from '@inertiajs/vue3'
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
  
  const props = defineProps({
    projects: Object, // результаты пагинации (Projects)
  })
  
  function deleteProject(id) {
    if (confirm('Точно удалить этот проект?')) {
      // Маршрут admin.projects.destroy или admin.projects.delete
      // Важно, чтобы совпадало с web.php
      router.delete(route('admin.projects.destroy', id))
    }
  }
  
  function goTo(url) {
    if (url) router.get(url)
  }
  </script>
  