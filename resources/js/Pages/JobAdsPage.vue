<template>
    <Head title="Job Ad Information" />
    <AuthenticatedLayout>
      <div class="my-10 max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 sm:p-8">
        <h2 class="text-2xl font-semibold text-gray-900">{{ jobAds.Title }}</h2>
        <p class="mt-2 text-lg text-gray-800 font-medium">{{ jobAds.Description }}</p>
        <div class="mt-6">
          <h3 class="text-xl font-semibold text-gray-900">Details</h3>
          <p><strong>Price:</strong> ${{ jobAds.Price }}</p>
          <p><strong>Posted On:</strong> {{ jobAds.created_at }}</p>
        </div>
      </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
  jobAds: Object,
});

console.log(props.jobAds);
</script>