<template>
    <AuthenticatedLayout>
      <Head title="Job Ads Management" />
  
      <div class="max-w-7xl mx-auto p-6 bg-white shadow sm:rounded-lg">
        <h1 class="text-2xl font-bold mb-4">Объявления о работе</h1>
  
        <!-- Горизонтальная прокрутка, если ширина таблицы больше контейнера -->
        <div class="overflow-x-auto">
          <table class="min-w-full text-left divide-y divide-gray-200 table-auto">
            <thead>
              <tr>
                <th class="px-6 py-3">ID</th>
                <th class="px-6 py-3">Заголовок</th>
                <th class="px-6 py-3">Описание</th>
                <th class="px-6 py-3">Цена</th>
                <th class="px-6 py-3">Действия</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="jobAd in jobAds.data" :key="jobAd.id">
                <td class="px-6 py-4">{{ jobAd.id }}</td>
                <td class="px-6 py-4 truncate max-w-[150px]">
                  {{ jobAd.Title }}
                </td>
                <td class="px-6 py-4 truncate max-w-[250px]">
                  {{ jobAd.Description }}
                </td>
                <td class="px-6 py-4">{{ jobAd.Price }} $</td>
                <td class="px-6 py-4">
                  <button
                    @click="deleteJobAd(jobAd.id)"
                    class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600"
                  >
                    Удалить
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
  
        <!-- Пагинация -->
        <div class="mt-4 flex items-center space-x-2">
          <button
            :disabled="!jobAds.links.prev"
            @click="goTo(jobAds.links.prev)"
            class="px-3 py-2 bg-gray-300 text-sm rounded disabled:opacity-50"
          >
            Предыдущая
          </button>
          <button
            :disabled="!jobAds.links.next"
            @click="goTo(jobAds.links.next)"
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
    jobAds: Object, // результаты пагинации (Job Ad)
  })
  
  // Удаление объявления
  function deleteJobAd(id) {
    if (confirm('Точно удалить это объявление?')) {
      router.delete(route('admin.jobAds.destroy', id))
    }
  }
  
  // Переход по ссылке пагинации
  function goTo(url) {
    if (url) router.get(url)
  }
  </script>
  