<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your projects
            </h2>
        </template>
        <br>
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 sm:p-8">
            <h2 class="text-2xl font-semibold text-gray-900">My Projects</h2>
            <ul class="mt-4 space-y-4">
                <ul v-if="projects !== undefined" class="py-12">
                    <li v-for="project in projects" :key="project.id" class="border-b border-gray-200 pb-4">
                      <br>
                        <h3 class="text-lg font-medium text-gray-900">{{ project.title }}</h3>
                        <p class="text-sm text-gray-600">{{ project.description }}</p>
                         <p><strong>Niche:</strong> {{ project.niche }}</p>
                         <p><strong>Completion Date:</strong> {{ project.completion_date }}</p>
                        <p><strong>Budget:</strong> ${{ project.budget }}</p>
                        <div class="mt-2">
                            <Link :href="route('projects.edit', project.id)" class="text-blue-600 hover:text-blue-800 mr-4">Edit</Link>
                            <button @click="deleteProject(project.id)" class="text-red-600 hover:text-red-800">Delete</button>
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
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const { props: pageProps } = usePage();
const projects = ref(pageProps.projects);

const deleteProject = (projectId) => {
    if (confirm('Are you sure you want to delete this project?')) {
        $project.delete(route('projects.delete', projectId));
    }
};
</script>
