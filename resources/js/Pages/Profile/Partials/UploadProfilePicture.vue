<script>
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

export default {
    setup() {
        const { props: { auth } } = usePage();
        const form = useForm({
            avatar: null,
        });
        const fileInput = ref(null);
        const handleFileChange = (event) => {
           const file = event.target.files[0];
    console.log('Selected file:', file);
    form.avatar = file;
        };
        return {
            auth,
            form,
            fileInput,
            handleFileChange,
        };
    },
    components: { PrimaryButton, InputLabel }
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Upload Profile Picture</h2>
            <p class="mt-1 text-sm text-gray-600">
                Upload your account's profile picture.
            </p>
        </header>

        <form @submit.prevent="form.post(route('avatar.upload'))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="avatar" value="Avatar" />

                <input ref="fileInput" type="file" class="file-input file-input-bordered w-full max-w-xs" @change="handleFileChange">
            </div>

            <div class="flex items-center gap-4">


               <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
