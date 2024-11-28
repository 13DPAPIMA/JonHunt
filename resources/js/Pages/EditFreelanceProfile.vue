<template>
    <div class="p-6 bg-gray-100">
      <form @submit.prevent="updateProfile" class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>
        
        <!-- Общий блок ошибок -->
        <div v-if="errors.general" class="bg-red-100 text-red-800 p-4 rounded mb-4">
          {{ errors.general }}
        </div>
  
        <div class="mb-4">
          <label class="block mb-2">Country</label>
          <input v-model="form.country" type="text" class="w-full p-2 border rounded" />
          <p v-if="errors.country" class="text-red-600 text-sm mt-1">{{ errors.country }}</p>
        </div>
  
        <div class="mb-4">
          <label class="block mb-2">Specialization</label>
          <input v-model="form.specialization" type="text" class="w-full p-2 border rounded" />
          <p v-if="errors.specialization" class="text-red-600 text-sm mt-1">{{ errors.specialization }}</p>
        </div>
  
        <div class="mb-4">
          <label class="block mb-2">Hourly Rate</label>
          <input v-model="form.hourly_rate" type="number" class="w-full p-2 border rounded" />
          <p v-if="errors.hourly_rate" class="text-red-600 text-sm mt-1">{{ errors.hourly_rate }}</p>
        </div>
  
        <div class="mb-4">
          <label class="block mb-2">Experience</label>
          <textarea v-model="form.experience" class="w-full p-2 border rounded"></textarea>
          <p v-if="errors.experience" class="text-red-600 text-sm mt-1">{{ errors.experience }}</p>
        </div>
  
        <div class="mb-4">
          <label class="block mb-2">Bio</label>
          <textarea v-model="form.bio" class="w-full p-2 border rounded"></textarea>
          <p v-if="errors.bio" class="text-red-600 text-sm mt-1">{{ errors.bio }}</p>
        </div>
  
        <div class="mb-4">
          <label class="block mb-2">Portfolio</label>
          <input @change="onFileChange" type="file" class="w-full p-2 border rounded" />
          <p v-if="errors.portfolio" class="text-red-600 text-sm mt-1">{{ errors.portfolio }}</p>
        </div>
  
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Save Changes</button>
      </form>
    </div>
  </template>
  
  
  <script setup>
  import { ref } from 'vue';
  import { usePage, router } from '@inertiajs/vue3';
  
  const { props } = usePage();
  const form = ref({ ...props.freelancer });
  const errors = ref({}); // Хранение ошибок
  
  const onFileChange = (event) => {
    form.value.portfolio = event.target.files[0];
  };
  
  const updateProfile = async () => {
    const data = new FormData();
    for (const key in form.value) {
      data.append(key, form.value[key]);
    }
  
    try {
      await router.post(route('freelancers.update', props.user.username), data, {
        onError: (newErrors) => {
          errors.value = newErrors; // Обновление ошибок
        },
      });
    } catch (e) {
      errors.value.general = 'An unexpected error occurred. Please try again later.';
    }
  };
  </script>
  