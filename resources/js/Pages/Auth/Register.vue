<template>
    <GuestLayout>
        <Head title="Register" />

        <div v-if="!roleSelected">
            <h2 class="text-center text-2xl font-semibold text-gray-900">Please select your role</h2>
            <div class="flex justify-center mt-4 space-x-4">
                <PrimaryButton @click="selectRole('freelancer')" class="ms-4 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-700">Freelancer</PrimaryButton>
                <PrimaryButton @click="selectRole('employer')" class=" ms-4 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-700">Employer</PrimaryButton>
            </div>
        </div>

        <form v-else @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="username" value="Username" />
            
                <TextInput
                    id="username"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.username"
                    required
                    autocomplete="username"
                />
            
                <InputError class="mt-2" :message="form.errors.username" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <input type="hidden" v-model="form.role" />

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Already registered?
                </Link>

                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({
    name: '',
    email: '',
    username: '', 
    password: '',
    password_confirmation: '',
    role: '', 
});

const roleSelected = ref(false);

const selectRole = (role) => {
    form.role = role;
    roleSelected.value = true;
};

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

