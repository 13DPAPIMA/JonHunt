<template>
    <AuthenticatedLayout>
      <Head title="Users Management" />
  
      <div class="max-w-7xl mx-auto p-6 bg-white shadow sm:rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Управление пользователями</h1>
  
        <table class="min-w-full divide-y divide-gray-200">
          <thead>
            <tr>
              <th class="px-6 py-3 text-left">ID</th>
              <th class="px-6 py-3 text-left">Name</th>
              <th class="px-6 py-3 text-left">Email</th>
              <th class="px-6 py-3 text-left">Role</th>
              <th class="px-6 py-3 text-left">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="user in users.data" :key="user.id">
              <td class="px-6 py-4">{{ user.id }}</td>
              <td class="px-6 py-4">{{ user.name }}</td>
              <td class="px-6 py-4">{{ user.email }}</td>
              <td class="px-6 py-4">{{ user.role }}</td>
              <td class="px-6 py-4">
                <button
                  @click="deleteUser(user.id)"
                  class="text-red-600 hover:text-red-900"
                >
                  Удалить
                </button>
              </td>
            </tr>
          </tbody>
        </table>
  
        <!-- Пагинация -->
        <div class="mt-4 flex space-x-2">
          <button
            :disabled="!users.links.prev"
            @click="goTo(users.links.prev)"
            class="btn bg-gray-300 px-3 py-1 rounded"
          >
            Предыдущая
          </button>
          <button
            :disabled="!users.links.next"
            @click="goTo(users.links.next)"
            class="btn bg-gray-300 px-3 py-1 rounded"
          >
            Следующая
          </button>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { Head, Link, router } from '@inertiajs/vue3'
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
  
  // Принимаем пропсы
  const props = defineProps({
    users: Object, // результаты пагинации
  })
  
  // Функция удаления пользователя
  function deleteUser(userId) {
    if (!confirm('Вы уверены, что хотите удалить этого пользователя?')) {
      return
    }
    router.delete(route('admin.users.destroy', userId))
  }
  
  // Функция перехода по пагинации
  function goTo(url) {
    if (url) router.get(url)
  }
  </script>
  