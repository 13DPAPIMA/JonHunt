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

        <div class="flex justify-center mt-4">


            <TextInput 
                        v-model="searchQuery"
                        type="text"
                        placeholder="Filter projects"
                        class="flex content-center mt-4 block w-60 p-2 border border-gray-300 rounded-lg"
                    />
            
        </div>

        <div class="py-12">
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
                <br>
                <Link class="group block max-w-xs mx-auto rounded-lg p-6 bg-white ring-1 ring-slate-900/5 shadow-lg space-y-3 hover:bg-red-500 hover:ring-black-500"
                 :href="route('/projects/create')">
                 <svg class=" flex items-center space-x-3 h-6 w-6 stroke-black-500 group-hover:stroke-white" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="butt" stroke-linejoin="bevel"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M12 18v-6M9 15h6"/></svg>
                <h3 class="text-slate-900 group-hover:text-white text-sm font-semibold">New project</h3>
                <p class="text-slate-500 group-hover:text-white text-sm">Create an new advertisement for your needs.</p>
                </Link>

                <br>
            

                <ul v-if="filteredProjects.length !== undefined" class="py-12">
                    <div class="flex flex-wrap -mx-4">
                        <div v-for="project in filteredProjects" :key="project.id" class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-4 mb-8">
                            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                <div class="p-6 flex flex-col">
                                    <Link :href="`/projects/${project.id}`" class="text-xl font-semibold mb-2 hover:underline">{{ project.title }}</Link>
                                    <p class="text-gray-600">Creator: {{ project.creator }}</p>
                                    <p class="text-gray-600">Budget: {{ project.budget }}</p>
                                    <p class="text-gray-600">Completion Date: {{ project.completion_date }}</p>
                                    <p class="text-gray-600">Niche: {{ project.niche }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </ul>
                
            <div v-else class="text-gray-600">Users haven't created any projects yet.</div>
        </div>
    </div>
    <label className="swap swap-flip text-2xl">
        <input type="checkbox" />
        
        <div className="swap-on">😈</div>
        <div className="swap-off">😇</div>
      </label>
    </AuthenticatedLayout>
</template>