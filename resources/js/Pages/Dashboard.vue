<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";


const props = defineProps({
    user: Object,
    avatar: String,
    projects: Array,
});

console.log(props.projects);

</script>

<template>
    <Head title="Applications" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900"> Welcome , {{ $page.props.auth.user.name }}!  </div>
                </div>

                <Link class="group block max-w-xs mx-auto rounded-lg p-6 bg-white ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-red-500 hover:ring-black-500"
                 :href="route('/projects/create')">
                 <svg class=" flex items-center space-x-3 h-6 w-6 stroke-black-500 group-hover:stroke-white" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="butt" stroke-linejoin="bevel"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M12 18v-6M9 15h6"/></svg>
                <h3 class="text-slate-900 group-hover:text-white text-sm font-semibold">New project</h3>
                <p class="text-slate-500 group-hover:text-white text-sm">Create an new advertisement for your needs.</p>
                </Link>
                <br>
                <ul v-if="projects !== undefined" class="py-12">
                    <li v-for="project in projects" :key="project.id" class="mb-8">
                        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                            <div class="p-6">
                                <h2 class="text-xl font-semibold mb-2">{{ project.title }}</h2>
                                <p class="text-gray-600 mb-4">{{ project.description }}</p>
                                <p class="text-gray-500">Creator: {{ project.creator }}</p>
                                <p class="text-gray-500">Completion Date: {{ project.CompletionDate }}</p>
                            </div>
                        </div>
                    </li>
                </ul>
                
            <div v-else class="text-gray-600">You haven't created any projects yet.</div>
        </div>
            </div>
    </AuthenticatedLayout>
</template>