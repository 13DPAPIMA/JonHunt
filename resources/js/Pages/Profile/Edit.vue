<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

// Состояния
const avatarUrl = ref(null); // URL текущего аватара
const avatar = ref(null); // Файл для загрузки
const status = ref(''); // Статус загрузки

// Получение текущего аватара
const fetchAvatar = () => {
    axios
        .get(route('avatar.get'))
        .then(response => {
            avatarUrl.value = response.data.photo_url; // Устанавливаем URL аватара
        })
        .catch(error => {
            console.error('Error fetching avatar:', error);
        });
};

// Обработка загрузки аватара
const submitForm = () => {
    if (!avatar.value) {
        status.value = 'Please select a file before uploading.';
        return;
    }

    const formData = new FormData();
    formData.append('photo', avatar.value);

    axios
        .post(route('avatar.upload'), formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        })
        .then(response => {
            status.value = 'Avatar uploaded successfully!';
            fetchAvatar(); // Обновляем аватар после загрузки
        })
        .catch(error => {
            console.error('Upload error:', error);
            status.value = 'Failed to upload avatar.';
        });
};

// Обработка выбора файла
const handleFileChange = event => {
    avatar.value = event.target.files[0]; // Получаем файл из input
};

// Удаление аватара
const deleteAvatar = () => {
    axios
        .delete(route('avatar.delete'))
        .then(() => {
            avatarUrl.value = null; // Удаляем URL аватара
            status.value = 'Avatar deleted successfully!';
        })
        .catch(error => {
            console.error('Error deleting avatar:', error);
            status.value = 'Failed to delete avatar.';
        });
};

// Получение аватара при монтировании компонента
onMounted(() => {
    fetchAvatar();
});
</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Profile</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Форма загрузки аватара -->
                <div class="p-6 bg-white shadow rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload Avatar</h2>
                    <form @submit.prevent="submitForm" class="space-y-4">
                        <input
                            type="file"
                            name="photo"
                            @change="handleFileChange"
                            class="block w-full text-sm text-gray-600 border border-gray-300 rounded-lg shadow-sm"
                        />
                        <button
                            type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition duration-200"
                        >
                            Upload
                        </button>
                    </form>
                    <p v-if="status" class="mt-4 text-green-600 font-medium">{{ status }}</p>
                    <!-- Отображение аватара -->
                    <div v-if="avatarUrl" class="mt-6">
                        <h3 class="text-lg font-medium text-gray-700">Current Avatar</h3>
                        <div class="mt-4 flex items-center space-x-4">
                            <img :src="avatarUrl" alt="Avatar" class="w-24 h-24 rounded-full shadow" />
                            <button
                                @click="deleteAvatar"
                                class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-lg transition duration-200"
                            >
                                Delete Avatar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Форма обновления профиля -->
                <div class="p-6 bg-white shadow rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <!-- Форма обновления пароля -->
                <div class="p-6 bg-white shadow rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <!-- Форма удаления аккаунта -->
                <div class="p-6 bg-white shadow rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Дополнительные стили */
</style>
