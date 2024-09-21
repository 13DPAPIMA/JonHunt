<template>
    <Head title="Create Job Advertisement" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Job Advertisement
            </h2>
        </template>
        <div class="py-8 px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="p-6 sm:p-8">
                    <h2 class="text-2xl font-semibold text-gray-900">Advertisement Title</h2>
                    <p class="mt-2 text-sm text-gray-600">Write a title for your advertisement</p>
                    <form @submit.prevent="submitForm" class="mt-6 space-y-6">
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
                            <span class="label-text-alt">At least 60 characters</span>
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>
                        
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900">Advertisement Description</h2>
                            <p class="mt-2 text-sm text-gray-600">Write a description for your advertisement</p>
                            <br />
                            <InputLabel for="description" value="Description" />
                            <textarea
                                id="description"
                                class="mt-1 block w-full h-32 focus-red-700 border"
                                v-model="form.description"
                                required
                                autocomplete="description"
                            ></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                            <label class="form-control w-full max-w-xs mt-2">
                                <span class="label-text-alt">At least 100 characters</span>
                            </label>
                        </div>

                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900">Price</h2>
                            <p class="mt-2 text-sm text-gray-600">Set a price for the advertisement</p>
                            <br />
                            <InputLabel for="price" value="Price" />
                            <TextInput
                                id="price"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.price"
                                required
                                autocomplete="price"
                            />
                            <InputError class="mt-2" :message="form.errors.price" />
                        </div>

                        <div>
                            <h2 class="text-2xl font-semibold text-gray-900">Upload Examples</h2>
                            <p class="mt-2 text-sm text-gray-600">Upload examples of your work (optional)</p>
                            <br />
                            <InputLabel for="examples" value="Examples of Work" />
                            <input
                                type="file"
                                id="examples"
                                @change="handleFileUpload"
                                class="mt-1 block w-full"
                            />
                            <InputError class="mt-2" :message="form.errors.examples" />
                        </div>

                        <div class="flex justify-end">
                            <PrimaryButton :disabled="form.processing">Create Advertisement</PrimaryButton>
                            <Transition
                  enter-active-class="transition ease-in-out"
                  enter-from-class="opacity-0"
                  leave-active-class="transition ease-in-out"
                  leave-to-class="opacity-0"
                >
                  <p v-if="form.recentlySuccessful" class="ml-4 text-sm text-gray-600">Project created.</p>
                </Transition>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from './../Layouts/AuthenticatedLayout.vue';

import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    title: '',
    description: '',
    price: '',
    examples: null,
});

const handleFileUpload = (event) => {
    form.examples = event.target.files[0];
};

const submitForm = () => {
    form.post(route('jobAds.store'));
};
</script>

<style>

</style>
