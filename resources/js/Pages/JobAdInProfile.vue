<template>
    <AuthenticatedLayout>

        <Head title="My Gigs" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your Job Advertisements
            </h2>
        </template>
        <br>
        <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 sm:p-8">
            <div class="flex justify-between items-center">
               <h2 class="text-2xl font-semibold text-gray-900 max-w-full">My Job Advertisments</h2>
               <Link :href="route('jobAds.create')" class="btn text-ml hover:bg-red-700 text-white bg-red-600 "> + Create new Job Advertisement </Link>
            </div>
            
            <div v-if="!jobAds || jobAds.length === 0" class="py-12">
                <h1>You have no Job Advertisements. Please create one.</h1>
            </div>
            <ul class="mt-4 space-y-4 max-w-full">
                <ul v-if="jobAds !== undefined" class="py-12">
                    <li v-for="jobAd in jobAds" :key="jobAd.id" class="border-b border-gray-200 pb-4">
                        <br>
                        <h3 class="text-lg font-medium text-gray-900 overflow-hidden text-ellipsis whitespace-nowrap">{{ jobAd.Title }}</h3>
                        <p class="text-sm text-gray-600 overflow-hidden text-ellipsis whitespace-nowrap">{{ jobAd.Description }}</p>
                        <p class="overflow-hidden text-ellipsis whitespace-nowrap"><strong>Price:</strong> ${{ jobAd.Price }}</p>
                         <div class="flex justify-end mt-2">
                            <Link :href="route('jobAds.edit', { jobAd: jobAd.id })" class="btn bg-white text-blue-600 hover:text-blue-800 mr-4">Edit</Link>
                            <button @click="openDeleteModal(jobAd.id)" class="btn bg-red-600 rounded-lg text-white hover:bg-red-700 hover:text-white">Delete</button>
                        </div>
                    </li>
                </ul>
            </ul>
            <div v-if="showModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white p-6 rounded shadow-lg w-96">
                    <h2 class="text-xl font-semibold mb-4">Confirm Deletion</h2>
                    <p class="text-gray-600 mb-6">
                        Are you sure you want to delete this job advertisement? This action cannot be undone.
                    </p>
                    <div class="flex justify-end space-x-4">
                        <button class="btn btn-outline hover:bg-gray-700" @click="cancelDelete">Back</button>
                        <button class="btn btn-error hover:bg-red-700 text-white" @click="confirmDelete">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, Link, Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const { props: pageProps } = usePage();
const jobAds = ref(pageProps.jobAds);


const showModal = ref(false);
const selectedJobAdId = ref(null);

const openDeleteModal = (jobAdId) => {
    selectedJobAdId.value = jobAdId;
    showModal.value = true;
};

const cancelDelete = () => {
    selectedJobAdId.value = null;
    showModal.value = false;
};

const confirmDelete = () => {
    const jobAdId = selectedJobAdId.value;

    router.delete(route('jobAds.delete', { jobAd: jobAdId }), {
        onSuccess: () => {
            console.log(`Successfully deleted Job Ad with ID: ${jobAdId}`);
            jobAds.value = jobAds.value.filter(jobAd => jobAd.id !== jobAdId);
            showModal.value = false;
        },
        onError: () => {
            console.log(`Error occurred while deleting Job Ad with ID: ${jobAdId}`);
            alert('An error occurred while deleting the job ad.');
            showModal.value = false;
        },
    });
};



</script>
