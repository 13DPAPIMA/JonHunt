
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';


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
        <AuthenticatedLayout>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
    <section>

        <header>
            <h2 class="text-lg font-medium text-gray-900">Addvertisment title</h2>
            
            <p class="mt-1 text-sm text-gray-600">
                Write a title for your project
            </p>
        </header>

            
        <form @submit.prevent="form.post(route('projects.store'))">
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
                    
                </div>
                
                <InputError class="mt-2" :message="form.errors.title" />

                <header>
            <h2 class="text-lg font-medium text-gray-900">Addvertisment title</h2>
            
            <p class="mt-1 text-sm text-gray-600">
                Write a title for your project
            </p>
        </header>
                <div>
                    <InputLabel for="description" value="Description" />
                    
                    <textarea id="desc"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.desc"
                        required
                        autocomplete="description"
                        
                ></textarea>
                        
                <InputError class="mt-2" :message="form.errors.desc" />
                    
                    <label class="form-control w-full max-w-xs">
                         <div class="label">
                            <span class="label-text-alt">At least 500 simbols</span>
                        </div>
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
                
        
        <div class="flex items-center gap-4 mt-10">
            <PrimaryButton :disabled="form.processing">Create a new project</PrimaryButton>
            
            <Transition
            enter-active-class="transition ease-in-out"
            enter-from-class="opacity-0"
            leave-active-class="transition ease-in-out"
            leave-to-class="opacity-0"
            >
            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Project created.</p>
            </Transition>
        </div>
    </form>
    </section>
    </div>
    </div>
    </div>
</AuthenticatedLayout>


</template>

<style>

</style>