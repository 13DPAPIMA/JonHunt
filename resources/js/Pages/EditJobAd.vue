<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit your Job Advertisement
            </h2>
        </template>
        <Head title="Edit Job Advertisement" />

        <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6">
            <!-- Введение -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Edit Your Advertisement</h1>
                <p class="text-gray-600 text-lg">
                    Use this page to update the details of your job advertisement. 
                    You can edit the title, description, price, and manage example images to showcase your work.
                </p>
            </div>

            <!-- Основные данные -->
            <div class="mb-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Advertisement Details</h2>
                <form @submit.prevent="submitMainForm" class="space-y-6">
                    <div>
                        <InputLabel for="title" value="Title" />
                        <TextInput
                            id="title"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="mainForm.title"
                            required
                            autofocus
                            autocomplete="title"
                        />
                        <span class="text-sm text-gray-500">Keep it clear and concise (60 symbols minimum).</span>
                        <InputError class="mt-2" :message="mainForm.errors.title" />
                    </div>

                    <div>
                        <InputLabel for="description" value="Description" />
                        <textarea
                            id="description"
                            class="mt-1 block w-full h-32 focus-red-700 border"
                            v-model="mainForm.description"
                            required
                            autocomplete="description"
                        ></textarea>
                        <span class="text-sm text-gray-500">Provide a detailed and engaging description of your advertisement.</span>
                        <InputError class="mt-2" :message="mainForm.errors.description" />
                    </div>

                    <div>
                        <InputLabel for="price" value="Price (in USD)" />
                        <input
                            type="number"
                            id="price"
                            v-model="mainForm.price"
                            required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        />
                        <span class="text-sm text-gray-500">Set a reasonable price for your job offering.</span>
                        <InputError class="mt-2" :message="mainForm.errors.price" />
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton :class="{ 'opacity-25': mainForm.processing }" :disabled="mainForm.processing">
                            Update Advertisement
                        </PrimaryButton>
                    </div>
                </form>
            </div>

            <!-- Управление изображениями -->
            <div>
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Manage Example Images</h2>
                <p class="text-gray-600 mb-4">
                    Update or replace the current image that represents your job advertisement.
                    Ensure the image is relevant and of high quality to attract potential clients.
                </p>

                <div class="mb-6">
                    <img v-if="currentImage" :src="currentImage" alt="Example" class="rounded-lg shadow-md w-full max-w-xs" />
                    <p v-else class="text-gray-500 italic">No example image uploaded yet.</p>
                </div>

                <form @submit.prevent="submitImageForm" class="space-y-6">
                    <div>
                        <InputLabel for="examples" value="Upload New Example" />
                        <input
                            type="file"
                            id="examples"
                            @change="handleImageUpload"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        />
                        <InputError class="mt-2" :message="imageForm.errors.examples" />
                    </div>

                    <div class="flex justify-end">
                        <PrimaryButton :class="{ 'opacity-25': imageForm.processing }" :disabled="imageForm.processing">
                            Update Image
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { usePage, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const { props: pageProps } = usePage();
const mainForm = useForm({
    title: '',
    description: '',
    price: '',
});

const imageForm = useForm({
    examples: null,
});

const currentImage = ref(null);

onMounted(() => {
    mainForm.title = pageProps.jobAd.Title;
    mainForm.description = pageProps.jobAd.Description;
    mainForm.price = pageProps.jobAd.Price;
    currentImage.value = pageProps.jobAd.ExampleUrl || null;
});

const handleImageUpload = (event) => {
    imageForm.examples = event.target.files[0];
};

const submitMainForm = () => {
    mainForm.put(route('jobAds.update', { jobAd: pageProps.jobAd.id }));
};

const submitImageForm = () => {
    const formData = new FormData();
    if (imageForm.examples) {
        formData.append('examples', imageForm.examples);
    }

    axios.post(route('jobAds.updateImage', { jobAd: pageProps.jobAd.id }), formData, {
        headers: {
            'Content-Type': 'multipart/form-data',
        },
    })
    .then((response) => {
        currentImage.value = response.data.example_url;
    })
    .catch((error) => {
        console.error(error.response.data);
    });
};
</script>
