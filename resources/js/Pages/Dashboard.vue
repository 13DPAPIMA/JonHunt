<script setup>
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import TextInput from '@/Components/TextInput.vue';

// Получаем данные страницы через usePage
const { props: pageProps } = usePage();

// Определяем макет
const Layout = computed(() => {
    return pageProps.auth ? AuthenticatedLayout : GuestLayout;
});

// Пользовательские данные
const user = computed(() => pageProps.auth || null);

console.log('Page props:', pageProps);
console.log('User:', pageProps.auth);
console.log('User:', user.value);


// Фильтрация и сортировка
const searchQuery = ref('');
const activeTab = ref('projects');

const sortedProjects = computed(() => {
    return pageProps.projects.slice().sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
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
        return pageProps.jobAds;
    }
    return pageProps.jobAds.filter(ad => {
        if (!ad) return false;
        return (
            ad.Title?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            ad.Description?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            ad.Price?.toString().includes(searchQuery.value) ||
            ad.creator?.name?.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            ad.creator?.username?.toLowerCase().includes(searchQuery.value.toLowerCase())
        );
    });
});

const setTab = (tab) => {
    activeTab.value = tab;
};
</script>

<template>
    <Head title="Dashboard" />

    <component :is="Layout">
        <template #header v-if="user">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Projects List
            </h2>
        </template>

        <div class="bg-red-600 overflow-hidden shadow-sm sm:rounded-lg w-2/3 mx-auto my-10">
            <div class="text-center p-6 text-white">
                <!-- Авторизованный пользователь -->
                <div v-if="$page.props.auth && $page.props.auth.user" class="text-2xl sm:text-3xl font-bold">
                    Welcome, {{ $page.props.auth.user.name }}!
                </div>
        
                <!-- Гость -->
                <div v-else class="text-2xl sm:text-3xl font-bold">
                    Welcome, Guest! Please 
                    <a href="/login" class="text-blue-500 hover:underline">login</a>
                    to access more features.
                </div>
        
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
                        class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 px-4 mb-8">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="p-8">
                                <a
                                    :href="`/projects/${project.id}`"
                                    class="text-lg font-semibold text-gray-800 mb-4 hover:underline block truncate">
                                    {{ project.title }}
                            </a>

                                <div class="creator-info flex items-center mt-2">
                                    <a
                                        v-if="project.creator && project.creator.avatar"
                                        :href="`/user/${project.creator.username}`"
                                        class="flex items-center">
                                        <img
                                            :src="project.creator.avatar.photo_url"
                                            alt="Avatar"
                                            class="w-10 h-10 rounded-full mr-3"
                                        />
                                    </a>
                                    <a
                                        v-else
                                        :href="`/user/${project.creator.username}`"
                                        class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-full mr-3 flex items-center justify-center bg-gray-400 text-white font-bold">
                                            {{ project.creator.name.charAt(0).toUpperCase() }}
                                        </div>
                                    </a>
                                    <a
                                        :href="`/user/${project.creator.username}`"
                                        class="text-gray-700 font-medium hover:text-blue-500 transition">
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
                        class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 px-4 mb-8">
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <div class="p-8">
                                <a
                                    :href="`/gigs/${ad.id}`"
                                    class="text-lg font-semibold text-gray-800 mb-4 hover:underline block truncate">
                                    {{ ad.Title || 'No title provided' }}
                            </a>

                                <div class="creator-info flex items-center mt-2">
                                    <a
                                        v-if="ad.creator && ad.creator.avatar"
                                        :href="`/users/${ad.creator.username}`"
                                        class="flex items-center">
                                        <img
                                            :src="ad.creator.avatar.photo_url"
                                            alt="Avatar"
                                            class="w-10 h-10 rounded-full mr-3"
                                        />
                                    </a>
                                    <a
                                        v-else
                                        :href="`/users/${ad.creator.username}`"
                                        class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-full mr-3 flex items-center justify-center bg-gray-400 text-white font-bold">
                                            {{ ad.creator.name.charAt(0).toUpperCase() }}
                                        </div>
                                    </a>
                                    <a
                                        :href="`/user/${ad.creator.username}`"
                                        class="text-gray-700 font-medium hover:text-blue-500 transition">
                                        {{ ad.creator.name }}
                                    </a>
                                </div>
                                <br />
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
    </component>
</template>
