<template>
  <Head title="Job Ad Information" />
  <AuthenticatedLayout>
      <div class="my-10 max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 sm:p-8">
          <h2 class="text-2xl font-semibold text-gray-900">{{ jobAds.Title }}</h2>
          <div class="creator-info flex items-center mt-2">
            <a 
                v-if="jobAds.creator && jobAds.creator.avatar" 
                :href="`/user/${jobAds.creator.username}`" 
                class="flex items-center"
            >
                <img 
                    :src="jobAds.creator.avatar.photo_url" 
                    alt="Avatar" 
                    class="w-10 h-10 rounded-full mr-3"
                />
            </a>

            <a 
                v-else 
                :href="`/user/${jobAds.creator.username}`" 
                class="flex items-center"
            >
                <div 
                    class="w-10 h-10 rounded-full mr-3 flex items-center justify-center bg-gray-400 text-white font-bold"
                >
                    {{ jobAds.creator.name.charAt(0).toUpperCase() }}
                </div>
            </a>

            <a 
                :href="`/user/${jobAds.creator.username}`" 
                class="text-gray-700 font-medium hover:text-blue-500 transition"
            >
                {{ jobAds.creator.name }}
            </a>
        </div>
        <div class="mt-6">
          <h3 class="text-xl font-semibold text-gray-900">Details</h3>
          <p><strong>Price:</strong> ${{ jobAds.Price }}</p>
          <p><strong>Posted:</strong> {{ timeSincePosted }}</p>
          <p><strong>Creator:</strong> {{ jobAds.creator.name }}</p>
        </div>
        <p class="mt-2 text-lg text-gray-800 font-medium overflow-hidden text-ellipsis">{{ jobAds.Description }}</p>
        <div class="mt-6 flex justify-between items-center">

          <button 
          @click="applyForJob" 
          class="btn bg-blue-600 text-white hover:bg-blue-700">
                  Apply for Job
              </button>
          </div>
      </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  jobAds: Object,
});

console.log(props.jobAds);

const timeSincePosted = computed(() => {
  const postedDate = new Date(props.jobAds.created_at);
  const currentDate = new Date();

  const diffTime = Math.abs(currentDate - postedDate);
  const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));

  if (diffDays === 0) {
      return "Today";
  } else if (diffDays === 1) {
      return "1 day ago";
  } else {
      return `${diffDays} days ago`;
  }
});

const applyForJob = () => {
  alert("Application sent!"); // Позже можно заменить на реальный функционал
};
</script>
