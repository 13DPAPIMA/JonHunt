<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { defineProps, ref, computed } from 'vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    user: Object,
    avatar: String,
    projects: Array,
    jobAds: Array,
});

console.log(props.projects);
console.log(props.jobAds);

const searchQuery = ref('');
const activeTab = ref('projects');

const sortedProjects = computed(() => {
    return props.projects.slice().sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
});

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

const filteredJobAds = computed(() => {
    if (!searchQuery.value) {
        return props.jobAds;
    }
    return props.jobAds.filter(ad => {
        if (!ad) return false;

        return (
            ad.Title?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            ad.Description?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            ad.Price?.toString().includes(searchQuery.value) || // Проверяем цену
            ad.creator?.name?.toLowerCase().includes(searchQuery.value.toLowerCase()) || // Проверяем имя создателя
            ad.creator?.username?.toLowerCase().includes(searchQuery.value.toLowerCase()) // Проверяем username создателя
        );
    });
});




const setTab = (tab) => {
    activeTab.value = tab;
};
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

                <!-- Tabs for switching between Projects and Freelancer Ads -->
                <div class="tabs flex justify-center gap-4 mt-6">
                    <button 
                        :class="{'border-b-4 border-blue-500 font-bold': activeTab === 'projects'}" 
                        @click="setTab('projects')" 
                        class="py-2 px-4">
                        Projects
                    </button>
                    <button 
                        :class="{'border-b-4 border-blue-500 font-bold': activeTab === 'jobAds'}" 
                        @click="setTab('jobAds')" 
                        class="py-2 px-4">
                        Freelancer Ads
                    </button>
                </div>

                <!-- Search bar -->
                <div class="flex justify-center mt-4">    
                    <TextInput 
                        v-model="searchQuery"
                        type="text"
                        placeholder="Filter by keyword"
                        class="flex content-center mt-4 w-60 p-2 border border-gray-300 rounded-lg"
                    />
                </div>

                <!-- Conditional Rendering based on activeTab -->
                <div v-if="activeTab === 'projects'">
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

                                        <div class="creator-info flex items-center mt-2">
                                            <a 
                                                v-if="project.creator && project.creator.avatar" 
                                                :href="`/users/${project.creator.username}`" 
                                                class="flex items-center"
                                            >
                                                <img 
                                                    :src="project.creator.avatar.photo_url" 
                                                    alt="Avatar" 
                                                    class="w-10 h-10 rounded-full mr-3"
                                                />
                                            </a>

                                            <a 
                                                v-else 
                                                :href="`/users/${project.creator.username}`" 
                                                class="flex items-center"
                                            >
                                                <div 
                                                    class="w-10 h-10 rounded-full mr-3 flex items-center justify-center bg-gray-400 text-white font-bold"
                                                >
                                                    {{ project.creator.name.charAt(0).toUpperCase() }}
                                                </div>
                                            </a>

                                            <a 
                                                :href="`/user/${project.creator.username}`" 
                                                class="text-gray-700 font-medium hover:text-blue-500 transition"
                                            >
                                                {{ project.creator.name }}
                                            </a>
                                        </div>

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

                <div v-if="activeTab === 'jobAds'">
                    <ul v-if="filteredJobAds.length !== undefined" class="py-12">
                        <div class="flex flex-wrap -mx-4">
                            <div 
                                v-for="ad in filteredJobAds" 
                                :key="ad.id" 
                                class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 px-4 mb-8"
                            >
                                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                                    <div class="p-8">
                                        <Link 
                                            :href="`/gigs/${ad.id}`" 
                                            class="text-lg font-semibold text-gray-800 mb-4 hover:underline block truncate"
                                        >
                                            {{ ad.Title || 'No title provided' }}
                                        </Link>
                
                                        <div class="creator-info flex items-center mt-2">
                                            <a 
                                                v-if="ad.creator && ad.creator.avatar" 
                                                :href="`/users/${ad.creator.username}`" 
                                                class="flex items-center"
                                            >
                                                <img 
                                                    :src="ad.creator.avatar.photo_url" 
                                                    alt="Avatar" 
                                                    class="w-10 h-10 rounded-full mr-3"
                                                />
                                            </a>
                
                                            <a 
                                                v-else 
                                                :href="`/users/${ad.creator.username}`" 
                                                class="flex items-center"
                                            >
                                                <div 
                                                    class="w-10 h-10 rounded-full mr-3 flex items-center justify-center bg-gray-400 text-white font-bold"
                                                >
                                                    {{ ad.creator.name.charAt(0).toUpperCase() }}
                                                </div>
                                            </a>
                
                                            <a 
                                                :href="`/user/${ad.creator.username}`" 
                                                class="text-gray-700 font-medium hover:text-blue-500 transition"
                                            >
                                                {{ ad.creator.name }}
                                            </a>
                                        </div>
                <br>   
                                        <p class="text-gray-600 text-base mb-2">
                                            <strong>Starts from:</strong> ${{ ad.Price }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </ul>
                
                    <div v-else class="text-gray-600">No freelancer ads available.</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
