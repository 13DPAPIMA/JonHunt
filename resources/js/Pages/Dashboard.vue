<script setup>
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import TextInput from '@/Components/TextInput.vue';

const { props: pageProps } = usePage();

const Layout = computed(() => {
    return pageProps.auth ? AuthenticatedLayout : GuestLayout;
});

const user = computed(() => pageProps.auth || null);

const activeTab = ref('projects');

const selectedNiche = ref('');
const selectedBudgetRange = ref('');
const selectedCompletionDate = ref('');

const budgetRanges = [
    { label: 'Any', value: '' },
    { label: 'Up to $500', value: '0-500' },
    { label: '$500 - $1000', value: '500-1000' },
    { label: 'Over $1000', value: '1000+' },
];

const sortedProjects = computed(() => {
    return pageProps.projects.slice().sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
});

const filteredProjects = computed(() => {
    return sortedProjects.value.filter(project => {
        if (selectedNiche.value && project.niche !== selectedNiche.value) {
            return false;
        }

        if (selectedBudgetRange.value) {
            const [min, max] = selectedBudgetRange.value.split('-').map(Number);
            const budget = project.budget || 0;
            if ((min && budget < min) || (max && budget > max)) {
                return false;
            }
        }

        if (selectedCompletionDate.value && project.completion_date !== selectedCompletionDate.value) {
            return false;
        }

        return true;
    });
});

const filteredJobAds = computed(() => {
    return pageProps.jobAds.filter(ad => {
        if (selectedBudgetRange.value) {
            const [min, max] = selectedBudgetRange.value.split('-').map(Number);
            const price = ad.Price || 0;
            if ((min && price < min) || (max && price > max)) {
                return false;
            }
        }

        return true;
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
                    <a href="/login" class="text-white-500 hover:underline">login</a>
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


        <div class="filters mt-6">
          <div class="flex flex-wrap gap-4 justify-center">
              <select v-model="selectedNiche" class="p-2 border border-gray-300 rounded-lg">
                  <option value="">All Niches</option>
                  <option v-for="niche in [...new Set(pageProps.projects.map(p => p.niche))]" :key="niche" :value="niche">
                      {{ niche }}
                  </option>
              </select>

              <select v-model="selectedBudgetRange" class="p-2 border border-gray-300 rounded-lg">
                  <option v-for="range in budgetRanges" :key="range.value" :value="range.value">
                      {{ range.label }}
                  </option>
              </select>
          </div>
      </div>

        <!-- Tabs for switching between Projects and Freelancer Ads -->
        <div class="tabs flex justify-center gap-4 mt-6">
            <button
                :class="{'border-b-4 border-red-500 font-bold': activeTab === 'projects'}"
                @click="setTab('projects')"
                class="py-2 px-4">
                Projects
            </button>
            <button
                :class="{'border-b-4 border-red-500 font-bold': activeTab === 'jobAds'}"
                @click="setTab('jobAds')"
                class="py-2 px-4">
                Freelancer Ads
            </button>
        </div>

<!-- Контейнер, создающий отступы от стен и ограничение по ширине -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div v-if="activeTab === 'projects'">
      <ul v-if="filteredProjects.length !== undefined">
        <!-- Сетка карточек -->
        <div class="flex flex-wrap -mx-2 sm:-mx-3">
          <div
            v-for="project in filteredProjects"
            :key="project.id"
            class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 px-2 sm:px-3 mb-6 sm:mb-8"
          >
            <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
              <div class="p-4 sm:p-6">
                <a
                  :href="`/projects/${project.id}`"
                  class="text-base sm:text-lg font-semibold text-gray-800 mb-3 hover:underline block truncate"
                >
                  {{ project.title }}
                </a>
                <div class="creator-info flex items-center mt-2">
                  <a
                    v-if="project.creator && project.creator.avatar"
                    :href="`/user/${project.creator.username}`"
                    class="flex items-center"
                  >
                    <img
                      :src="project.creator.avatar.photo_url"
                      alt="Avatar"
                      class="w-8 h-8 sm:w-10 sm:h-10 rounded-full mr-3"
                    />
                  </a>
                  <a
                    v-else
                    :href="`/user/${project.creator.username}`"
                    class="flex items-center"
                  >
                    <div
                      class="w-8 h-8 sm:w-10 sm:h-10 rounded-full mr-3 flex items-center justify-center bg-gray-400 text-white font-bold"
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
                <p class="text-gray-600 text-sm sm:text-base mb-1 sm:mb-2 mt-2">
                  <strong>Budget:</strong> ${{ project.budget }}
                </p>
                <p class="text-gray-600 text-sm sm:text-base mb-1 sm:mb-2">
                  <strong>Completion Date:</strong> {{ project.completion_date }}
                </p>
                <p class="text-gray-600 text-sm sm:text-base">
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
      <ul v-if="filteredJobAds.length !== undefined">
        <div class="flex flex-wrap -mx-2 sm:-mx-3">
          <div
            v-for="ad in filteredJobAds"
            :key="ad.id"
            class="w-full sm:w-1/2 md:w-1/2 lg:w-1/3 px-2 sm:px-3 mb-6 sm:mb-8"
          >
            <div class="bg-white shadow-md rounded-lg overflow-hidden hover:shadow-lg transition-shadow duration-300">
              <div class="p-4 sm:p-6">
                <a
                  :href="`/gigs/${ad.id}`"
                  class="text-base sm:text-lg font-semibold text-gray-800 mb-3 hover:underline block truncate"
                >
                  {{ ad.Title || 'No title provided' }}
                </a>
                <div class="creator-info flex items-center mt-2">
                  <a
                    v-if="ad.creator && ad.creator.avatar"
                    :href="`/users/${ad.creator.username}`"
                    class="flex items-center"
                  >
                    <img
                      :src="ad.creator.avatar.photo_url"
                      alt="Avatar"
                      class="w-8 h-8 sm:w-10 sm:h-10 rounded-full mr-3"
                    />
                  </a>
                  <a
                    v-else
                    :href="`/users/${ad.creator.username}`"
                    class="flex items-center"
                  >
                    <div
                      class="w-8 h-8 sm:w-10 sm:h-10 rounded-full mr-3 flex items-center justify-center bg-gray-400 text-white font-bold"
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
                <div v-if="ad.portfolios && ad.portfolios.length > 0" class="mt-4">
                  <h3 class="text-sm font-semibold text-gray-700 mb-2">Portfolio Examples</h3>
                  <div class="grid grid-cols-1 sm:grid-cols-2 ">
                    <div
                      v-for="portfolio in ad.portfolios"
                      :key="portfolio.id"
                      class="aspect-ratio rounded-lg overflow-hidden"
                    >
                      <img
                        :src="portfolio.example_url"
                        alt="Portfolio example"
                      />
                    </div>
                  </div>
                </div>
                <br>
                <p class="text-gray-600 text-sm sm:text-base mb-1 sm:mb-2">
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
  
  
        
    </component>
</template>
