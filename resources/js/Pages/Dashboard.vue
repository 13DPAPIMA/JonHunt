<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { defineProps,ref, computed } from 'vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    user: Object,
    avatar: String,
    projects: Array,
});

console.log(props.projects);

const sortedProjects = computed(() => {
    return props.projects.slice().sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
}); 

const searchQuery = ref('');

const filteredProjects = computed(() => {
    if (!searchQuery.value) {
        return sortedProjects.value;
    }
    return sortedProjects.value.filter(project => {
        if (!project) return false; 
        return (
            project.title.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            project.creator.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            project.niche.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            (project.budget && project.budget.toString().includes(searchQuery.value.toLowerCase())) || 
            (project.completion_date && project.completion_date.includes(searchQuery.value)) 
        );
    });
});



</script>

<template>
    <Head title="Applications" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projects List
            </h2>
        </template>

        
        <div class="py-12 selection:bg-red-500 selection:text-white overflow-hidden">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-red-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="text-center p-6 text-white">
                        <p class="text-2xl sm:text-3xl font-bold">Welcome, {{ $page.props.auth.user.name }}! 👋  </p>
                        
                        <div class="flex flex-col sm:flex-row mt-4">
                            <div class="bg-white m-2 p-4 text-black w-full sm:w-1/2 h-auto sm:h-32 overflow-hidden shadow-sm sm:rounded-lg">
                                <p class="text-left font-bold text-sm sm:text-base">RECOMMENDED FOR YOU</p>
                                <p class="my-3 sm:my-7 text-sm sm:text-base">Cooperate with other freelancers!</p>
                            </div>
                            <div class="bg-white m-2 p-4 text-black w-full sm:w-1/2 h-auto sm:h-32 overflow-hidden shadow-sm sm:rounded-lg">
                                <p class="text-left font-bold text-sm sm:text-base">BUSINESS RECOMMENDATIONS</p>
                                <p class="my-3 sm:my-7 text-sm sm:text-base">Write more about yourself in your profile!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center mt-4">    
                                <TextInput 
                                            v-model="searchQuery"
                                            type="text"
                                            placeholder="Filter projects"
                                            class="flex content-center mt-4 w-60 p-2 border border-gray-300 rounded-lg"
                                />
                </div>
                <ul v-if="filteredProjects.length !== undefined" class="py-12">
                    <div class="flex flex-wrap -mx-4">
                        <div 
                            v-for="project in filteredProjects" 
                            :key="project.id" 
                            class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 px-4 mb-8"
                        >
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                <div class="p-8">
                                    <Link 
                                        :href="`/projects/${project.id}`" 
                                        class="text-lg font-semibold text-gray-800 mb-4 hover:underline block truncate"
                                    >
                                        {{ project.title }}
                                    </Link>
                                    <p class="text-gray-600 text-base mb-2">
                                        <strong>Creator:</strong> {{ project.creator }}
                                    </p>
                                    <p class="text-gray-600 text-base mb-2">
                                        <strong>Budget:</strong> ${{ project.budget }}
                                    </p>
                                    <p class="text-gray-600 text-base mb-2">
                                        <strong>Completion Date:</strong> {{ project.completion_date }}
                                    </p>
                                    <p class="text-gray-600 text-base">
                                        <strong>Niche:</strong> {{ project.niche }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </ul>
                
            <div v-else class="text-gray-600">Users haven't created any projects yet.</div>
        </div>
    </div>
    </AuthenticatedLayout>
</template>