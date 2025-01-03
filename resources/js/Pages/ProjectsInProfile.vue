<template>
    <AuthenticatedLayout>
        <Head title="My Projects" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Your projects
            </h2>
        </template>
        <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6 sm:p-8 my-10 selection:bg-red-500 selection:text-white overflow-hidden">
           <div class="flex justify-between items-center">
               <h2 class="text-2xl font-semibold text-gray-900 max-w-full">My Projects</h2>
               <Link :href="route('/projects/create')" class="btn text-ml hover:bg-red-700 text-white bg-red-600 "> + Create new project </Link>
            </div>
            
            <div v-if="!projects || projects.length === 0" class="py-12">
                <h1>You have no projects. Please create one.</h1>
            </div>
            <ul v-else class="mt-4 space-y-4 max-w-full py-12">
                <li v-for="project in projects" :key="project.id" class="border-b border-gray-200 pb-4">
                    <h3 class="text-lg font-medium text-gray-900 overflow-hidden text-ellipsis whitespace-nowrap">{{ project.title }}</h3>
                    <p class="text-sm text-gray-600 overflow-hidden text-ellipsis whitespace-nowrap">{{ project.description }}</p>
                    <p class="overflow-hidden text-ellipsis whitespace-nowrap"><strong>Niche:</strong> {{ project.niche }}</p>
                    <p class="overflow-hidden text-ellipsis whitespace-nowrap"><strong>Completion Date:</strong> {{ project.completion_date }}</p>
                    <p class="overflow-hidden text-ellipsis whitespace-nowrap"><strong>Budget:</strong> ${{ project.budget }}</p>
                    <div class="flex justify-end mt-2">
                        <Link :href="route('projects.edit', project.id)" class="btn bg-white text-blue-600 hover:text-blue-800 mr-4">Edit</Link>
                        <button @click="openDeleteModal(project.id)(project.id)" class="btn bg-red-600 rounded-lg text-white hover:bg-red-700 hover:text-white">Delete</button>
                    </div>
                </li>
            </ul>
            <div v-if="showModal" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex justify-center items-center z-50">
                <div class="bg-white p-6 rounded shadow-lg w-96">
                  <h2 class="text-xl font-semibold mb-4">Confirm Deletion</h2>
                  <p class="text-gray-600 mb-6">
                    Are you sure you want to delete this project? This action cannot be undone.
                  </p>
                  <div class="flex justify-end space-x-4">
                    <button
                      class="btn btn-outline"
                      @click="cancelDelete"
                    >
                      Back
                    </button>
                    <button
                      class="btn btn-error text-white hover:bg-red-700"
                      @click="confirmDelete"
                    >
                      Delete
                    </button>
                  </div>
                </div>
              </div>
        </div>
        
        
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, Link, router, Head } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const { props } = usePage();
const projects = ref(props.projects);

const showModal = ref(false);
const selectedProjectId = ref(null);

const openDeleteModal = (projectId) => {
  selectedProjectId.value = projectId;
  showModal.value = true;
};

const cancelDelete = () => {
  selectedProjectId.value = null;
  showModal.value = false;
};

const confirmDelete = () => {
  const projectId = selectedProjectId.value;

  router.delete(route('projects.delete', projectId), {
    onSuccess: () => {
      projects.value = projects.value.filter(project => project.id !== projectId);
      showModal.value = false;
    },
    onError: () => {
      alert('An error occurred while deleting the project.');
      showModal.value = false;
    },
  });
};
</script>