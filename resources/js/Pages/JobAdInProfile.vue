<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your Job Advertisements
            </h2>
        </template>
        <br>
        <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 sm:p-8">
            <h2 class="text-2xl font-semibold text-gray-900 max-w-full">My Job Ads</h2>
            <ul class="mt-4 space-y-4 max-w-full">
                <ul v-if="jobAds !== undefined" class="py-12">
                    <li v-for="jobAd in jobAds" :key="jobAd.id" class="border-b border-gray-200 pb-4">
                        <br>
                        <h3 class="text-lg font-medium text-gray-900 overflow-hidden text-ellipsis whitespace-nowrap">{{ jobAd.Title }}</h3>
                        <p class="text-sm text-gray-600 overflow-hidden text-ellipsis whitespace-nowrap">{{ jobAd.Description }}</p>
                        <p class="overflow-hidden text-ellipsis whitespace-nowrap"><strong>Price:</strong> ${{ jobAd.Price }}</p>
                        <div class="mt-2">
                            <Link :href="route('jobAds.edit', { jobAd: jobAd.id })" class="text-blue-600 hover:text-blue-800 mr-4">Edit</Link>
                            <button @click="deleteJobAd(jobAd.id)" class="text-red-600 hover:text-red-800">Delete</button>
                        </div>
                    </li>
                </ul>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const { props: pageProps } = usePage();
const jobAds = ref(pageProps.jobAds);  // Объявления о работе пользователя


const deleteJobAd = (jobAdId) => {
    if (confirm('Are you sure you want to delete this job ad?')) {
        router.delete(route('jobAds.delete', { jobAd: jobAdId }), {
            onSuccess: () => {
                console.log(`Successfully deleted Job Ad with ID: ${jobAdId}`);
                jobAds.value = jobAds.value.filter(jobAd => jobAd.id !== jobAdId);
            },
            onError: () => {
                console.log(`Error occurred while deleting Job Ad with ID: ${jobAdId}`);
                alert('An error occurred while deleting the job ad.');
            },
        });
    }
};



</script>
