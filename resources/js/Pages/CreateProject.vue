
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';


defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});


const project = usePage().props.auth.user;

const form = useForm({
    title: " ",
    desc: " ",
    niche: " ",
});

</script>


<template>
    <Head title="Create project" />
    <AuthenticatedLayout>
      <div class="py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg">
          <div class="p-6 sm:p-8">
            <h2 class="text-2xl font-semibold text-gray-900">Advertisement Title</h2>
            <p class="mt-2 text-sm text-gray-600">Write a title for your project</p>
            <form @submit.prevent="form.post(route('projects.store'))" class="mt-6 space-y-6">
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
                <InputError class="mt-2" :message="form.errors.title" />
              </div>
              <div>
                <h2 class="text-2xl font-semibold text-gray-900">Advertisement Description</h2>
                <p class="mt-2 text-sm text-gray-600">Write a description for your project</p>
                <textarea
                  id="description"
                  class="mt-1 block w-full h-32"
                  v-model="form.desc"
                  required
                  autocomplete="description"
                ></textarea>
                <InputError class="mt-2" :message="form.errors.desc" />
                <label class="form-control w-full max-w-xs mt-2">
                  <span class="label-text-alt">At least 500 symbols</span>
                </label>
              </div>
              <div>
                <InputLabel for="niche" value="Niche" />
                <TextInput
                  id="niche"
                  type="text"
                  class="mt-1 block w-full"
                  v-model="form.niche"
                  required
                  autofocus
                  autocomplete="niche"
                />
              </div>
              <div class="flex justify-end">
                <PrimaryButton :disabled="form.processing">Create a New Project</PrimaryButton>
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

<style>

</style>