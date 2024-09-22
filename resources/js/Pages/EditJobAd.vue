<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit your Job Advertisement
            </h2>
        </template>
        <Head title="Edit Job Advertisement" />

        <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Edit Job Advertisement</h2>

            <form @submit.prevent="submit" class="space-y-6">
                <div>
                    <InputLabel for="title" value="Title" />
                    <TextInput
                        id="title"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.title"
                        required
                        autofocus
                        autocomplete="title"
                    />
                    <span class="text-sm text-gray-500">At least 60 symbols</span>
                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <div>
                    <InputLabel for="description" value="Description" />
                    <textarea
                        id="description"
                        class="mt-1 block w-full h-32 focus-red-700 border"
                        v-model="form.description"
                        required
                        autocomplete="description"
                    ></textarea>
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div>
                    <InputLabel for="price" value="Price" />
                    <input
                        type="number"
                        id="price"
                        v-model="form.price"
                        required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                    <InputError class="mt-2" :message="form.errors.price" />
                </div>

                <div>
                    <InputLabel for="examples" value="Example of Work (optional)" />
                    <input
                        type="file"
                        id="examples"
                        @change="handleFileUpload"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                    />
                    <InputError class="mt-2" :message="form.errors.examples" />
                </div>

                <div class="flex justify-end">
                    <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Update Advertisement
                    </PrimaryButton>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-if="form.recentlySuccessful" class="ml-4 text-sm text-gray-600">Job Ad edited</p>
                    </Transition>
                </div>
            </form>
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
const form = useForm({
    title: '',
    description: '',
    price: '',
    examples: null,
});

// Заполнение формы текущими данными объявления о работе
onMounted(() => {
    form.title = pageProps.jobAd.Title;
    form.description = pageProps.jobAd.Description;
    form.price = pageProps.jobAd.Price;
});

// Обработка загрузки файла примера работы
const handleFileUpload = (event) => {
    form.examples = event.target.files[0];
};

// Отправка формы для обновления объявления о работе
const submit = () => {
    form.put(route('jobAds.update', { jobAd: pageProps.jobAd.id }));
};
</script>
