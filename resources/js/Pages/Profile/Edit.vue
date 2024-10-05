<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import UploadProfilePicture from './Partials/UploadProfilePicture.vue';
import { ref, onMounted  } from 'vue';
import { Head, useForm  } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const avatarUrl = ref(null); // URL аватара
const avatar = ref(null);
const status = ref('');

const form = useForm({
    avatar: null,
});

const fetchAvatar = () => {
    // Запрашиваем аватар пользователя
    axios.get(route('avatar.get'))
        .then(response => {
            avatarUrl.value = response.data.photo_url; // Устанавливаем URL аватара
        })
        .catch(error => {
            console.log('Error fetching avatar:', error);
        });
};

const submitForm = () => {
    const formData = new FormData();
    formData.append('photo', avatar.value); // Добавляем файл в FormData

    axios.post(route('avatar.upload'), formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    })
    .then(response => {
        console.log('Upload success:', response.data);
        status.value = 'Photo uploaded successfully';
        fetchAvatar(); // Обновляем аватар после загрузки
    })
    .catch(error => {
        console.log('Upload error:', error);
        status.value = 'Upload failed';
    });
};

const handleFileChange = (event) => {
    avatar.value = event.target.files[0]; // Получаем файл из input
};

onMounted(() => {
    fetchAvatar(); // Получаем аватар при монтировании компонента
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
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                  
                    <form @submit.prevent="submitForm" enctype="multipart/form-data">
                        <input type="file" name="photo" @change="handleFileChange" />
                        <button type="submit">Upload</button>
                    </form>

                    <p v-if="status">{{ status }}</p>

                    <!-- Отображение аватара -->
                    <div v-if="avatarUrl">
                        <h3>Your Avatar:</h3>
                        <img :src="avatarUrl" alt="Avatar" style="max-width: 200px;" />
                    </div>
                </div>
               
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                 <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
        
    </AuthenticatedLayout>
</template>
