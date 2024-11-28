<template>
    <div class="p-6 bg-gray-100">
      <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg">
        <!-- Верхний раздел с градиентом -->
        <div class="bg-gradient-to-l from-red-600 to-purple-500 h-32 relative">
          <div class="absolute bottom-0 left-1/2 transform -translate-x-1/2 -mb-10">
            <img
              v-if="user.avatar && user.avatar.photo_url"
              :src="user.avatar.photo_url"
              alt="Avatar"
              class="w-20 h-20 rounded-full border-4 border-white"
            />
            <div
              v-else
              class="w-20 h-20 rounded-full bg-gray-400 flex items-center justify-center text-white font-bold border-4 border-white"
            >
              {{ user.name.charAt(0).toUpperCase() }}
            </div>
          </div>
        </div>
  
        <!-- Информация о фрилансере -->
        <div class="mt-12 px-6 pb-6 text-center">
          <h1 class="text-2xl font-bold">{{ user.name }}</h1>
          <p v-if="freelancer.bio" class="text-gray-500 mt-2">{{ freelancer.bio }}</p>
        </div>
        
        <div class="px-6 py-4">
            <h3 class="text-lg font-medium text-gray-700">Freelancer Information</h3>
            <p><strong>Country:</strong> {{ freelancer.country }}</p>
          <p><strong>Specialization:</strong> {{ freelancer.specialization }}</p>
          <p><strong>Hourly Rate:</strong> ${{ freelancer.hourly_rate }}</p>
          <p><strong>Experience:</strong> {{ freelancer.experience }}</p>
          <p v-if="freelancer.portfolio">
            <a :href="'/storage/' + freelancer.portfolio" target="_blank" class="text-blue-500">View Portfolio</a>
          </p>
        </div>
  
        <!-- Проекты -->
        <div v-if="projects && projects.length > 0" class="px-6 py-4">
          <h3 class="text-lg font-medium text-gray-700">Projects</h3>
          <ul class="mt-4 space-y-4">
            <li
              v-for="project in projects"
              :key="project.id"
              class="bg-gray-100 p-4 rounded-lg shadow-sm hover:shadow-md transition"
            >
              <h4 class="text-blue-600 font-semibold">{{ project.title }}</h4>
              <p class="text-gray-600 text-sm mt-2">{{ project.description }}</p>
            </li>
          </ul>
        </div>
        <div v-else class="text-gray-500 px-6 py-4">
          This user has not participated in any projects yet.
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({
    freelancer: Object,
    user: Object,
    projects: Array,
  });
  </script>
  
  <style scoped>
  </style>
  