<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const page = usePage();
const query = computed(() => page.props.query);
const users = computed(() => page.props.users || []);
const projects = computed(() => page.props.projects || []);
const jobAds = computed(() => page.props.jobAds || []);

console.log(page.props);
</script>

<template>
    <AuthenticatedLayout>
  <div class="container mx-auto mt-6">
    <h1 class="text-2xl font-bold mb-4">Search Results</h1>
    <p class="mb-4">Results for: <strong>"{{ query }}"</strong></p>

    <!-- Пользователи -->
    <div v-if="users.length" class="mb-10">
      <h2 class="text-xl font-semibold mb-4">Users</h2>
      <div class="flex flex-wrap -mx-2 sm:-mx-3">
        <div
          v-for="user in users"
          :key="user.id"
          class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2 sm:px-3 mb-6"
        >
          <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300 flex items-center p-4">
            <img
              v-if="user.avatar"
              :src="user.avatar.photo_url"
              alt="User Avatar"
              class="w-16 h-16 rounded-full mr-4"
            />
            <div v-else class="w-16 h-16 bg-gray-400 text-white rounded-full flex items-center justify-center text-xl font-bold mr-4">
              {{ user.name.charAt(0).toUpperCase() }}
            </div>
            <a :href="`/user/${user.username}`" class="text-gray-800 font-semibold hover:underline">
              {{ user.name }}
            </a>
          </div>
        </div>
      </div>
    </div>
    <p v-else class="text-gray-500">No users found.</p>

    <!-- Проекты -->
    <div v-if="projects.length" class="mb-10">
      <h2 class="text-xl font-semibold mb-4">Projects</h2>
      <div class="flex flex-wrap -mx-2 sm:-mx-3">
        <div
          v-for="project in projects"
          :key="project.id"
          class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2 sm:px-3 mb-6"
        >
          <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="p-4">
              <a
                :href="`/projects/${project.id}`"
                class="text-lg font-semibold text-gray-800 hover:underline block truncate"
              >
                {{ project.title }}
              </a>
              <div class="creator-info flex items-center mt-2">
                <img
                  v-if="project.creator?.avatar"
                  :src="project.creator.avatar.photo_url"
                  alt="Avatar"
                  class="w-8 h-8 rounded-full mr-2"
                />
                <span v-else class="w-8 h-8 bg-gray-400 text-white rounded-full flex items-center justify-center text-sm font-bold mr-2">
                  {{ project.creator?.name.charAt(0).toUpperCase() }}
                </span>
                <a
                  :href="`/user/${project.creator?.username}`"
                  class="text-gray-700 font-medium hover:text-blue-500"
                >
                  {{ project.creator?.name || 'Unknown' }}
                </a>
              </div>
              <p class="text-gray-600 text-sm mt-2">
                <strong>Budget:</strong> ${{ project.budget }}
              </p>
              <p class="text-gray-600 text-sm">
                <strong>Completion Date:</strong> {{ project.completion_date }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <p v-else class="text-gray-500">No projects found.</p>


    <div v-if="jobAds.length" class="mb-10">
      <h2 class="text-xl font-semibold mb-4">Job Ads</h2>
      <div class="flex flex-wrap -mx-2 sm:-mx-3">
        <div
          v-for="job in jobAds"
          :key="job.id"
          class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2 sm:px-3 mb-6"
        >
          <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <div class="p-4">
              <a
                :href="`/jobAds/${job.id}`"
                class="text-lg font-semibold text-gray-800 hover:underline block truncate"
              >
                {{ job.Title }}
              </a>
              <div class="creator-info flex items-center mt-2">
                <!-- Проверка на наличие creator -->
                <img
                  v-if="job.creator && job.creator.avatar"
                  :src="job.creator.avatar.photo_url"
                  alt="Avatar"
                  class="w-8 h-8 rounded-full mr-2"
                />
                <span v-else class="w-8 h-8 bg-gray-400 text-white rounded-full flex items-center justify-center text-sm font-bold mr-2">
                  {{ job.creator?.name?.charAt(0).toUpperCase() || '?' }}
                </span>
                <a
                  :href="job.creator ? `/user/${job.creator.username}` : '#'"
                  class="text-gray-700 font-medium hover:text-blue-500"
                >
                  {{ job.creator?.name || 'Unknown' }}
                </a>
              </div>
              <p class="text-gray-600 text-sm mt-2">
                <strong>Description:</strong> {{ job.Description }}
              </p>
              <p class="text-gray-600 text-sm">
                <strong>Salary:</strong> ${{ job.Price }}
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
      
    <p v-else class="text-gray-500">No job ads found.</p>
  </div>
</AuthenticatedLayout>
</template>
