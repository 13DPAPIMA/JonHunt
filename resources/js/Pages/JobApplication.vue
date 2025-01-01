<template>
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Apply for Job: {{ jobAd.Title }}</h2>
        <h2 class="text-xl font-semibold text-gray-600 mb-6">{{ jobAd.Description }}</h2>
        <h2 class="text-xl font-semibold text-gray-600 mb-6">${{ jobAd.Price }}</h2>

        
        <form @submit.prevent="submitApplication">
            <div class="mb-4">
                <label for="requirements" class="block text-sm font-medium text-gray-700">Requirements</label>
                <textarea v-model="form.requirements" id="requirements" rows="5"
                    class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Enter your job requirements..."></textarea>
                <div v-if="form.errors.requirements" class="text-red-500 text-sm">{{ form.errors.requirements }}</div>
            </div>

            <button type="submit" class="btn bg-blue-600 text-white hover:bg-blue-700">Submit Application</button>
        </form>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
    jobAd: Object,
});

const form = useForm({
    requirements: '',
});

const submitApplication = () => {
    form.post(`/jobs/${props.jobAd.id}/apply`, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Application submitted successfully!');
        },
    });
};
</script>
