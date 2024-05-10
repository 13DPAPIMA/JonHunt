<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { ref } from 'vue';

const props = defineProps({
    user: Object,
    avatar: String,
});

function getUserAvatar(user) {
    if (avatar) {
        return `/avatar/${avatar}`; // Предполагается, что вы используете маршрут /avatar/{userId} для получения изображения
    } else {
        // Получаем первые буквы имени пользователя
        const initials = user.name.split(' ').map(word => word.charAt(0)).join('');
        // Создаем динамическое изображение с первыми буквами имени пользователя
        return `https://ui-avatars.com/api/?name=${initials}`;
    }
}


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


            </div>
        </div>
    </AuthenticatedLayout>
</template>