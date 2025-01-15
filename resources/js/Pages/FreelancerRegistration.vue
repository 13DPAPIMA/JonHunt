<template>
  <AuthenticatedLayout>
    <!-- Если пользователь - фрилансер, показываем сообщение и выходим -->
    <div v-if="isFreelancer" class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6 text-center">
      <h2 class="text-2xl font-semibold text-gray-800 mb-4">
        You are already a freelancer!
      </h2>
      <p class="text-gray-600">
        You cannot register again.
      </p>
    </div>

    <!-- Если пользователь НЕ фрилансер, показываем форму -->
    <div v-else class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">
        Freelancer Registration
      </h2>

      <ul class="steps mb-6">
        <!-- Допустим, теперь у нас всего 2 шага -->
        <li class="step" :class="{ 'step-accent': step >= 1 }">Personal Info</li>
        <li class="step" :class="{ 'step-accent': step >= 2 }">Professional Info</li>
        <li class="step" :class="{ 'step-accent': step === 3 }">Complete</li>
      </ul>

      <!-- Step 1 -->
      <div v-if="step === 1">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">
          Step 1: Personal Information
        </h3>
        <form @submit.prevent="nextStep" class="space-y-6">
          <!-- Country -->
          <div>
            <InputLabel for="country-search" value="Country" />
            <p class="mt-2 text-sm text-gray-600">
              Choose country where you live
            </p>
            <div class="relative">
              <TextInput
                type="text"
                id="country-search"
                v-model="searchQuery"
                placeholder="Start typing your country..."
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                @focus="showDropdown = true"
                @blur="handleBlur"
                required
              />
              <ul
                v-if="showDropdown && filteredCountries.length"
                class="absolute z-10 w-full bg-white border border-gray-300 rounded-md shadow-lg mt-1 max-h-48 overflow-y-auto"
              >
                <li
                  v-for="country in filteredCountries"
                  :key="country"
                  @mousedown.prevent="selectCountry(country)"
                  class="p-2 hover:bg-indigo-500 hover:text-white cursor-pointer"
                >
                  {{ country }}
                </li>
              </ul>
            </div>
            <InputError class="mt-2" :message="form.errors.country" />
          </div>

          <!-- Bio -->
          <div>
            <InputLabel for="bio" value="Bio" />
            <p class="mt-2 text-sm text-gray-600">
              Write a short bio about yourself
            </p>
            <textarea
              id="bio"
              class="textarea textarea-bordered h-24 mt-1 block w-full resize-none"
              v-model="form.bio"
              required
            />
            <InputError class="mt-2" :message="form.errors.bio" />
          </div>

          <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Next Step
          </PrimaryButton>
        </form>
      </div>

      <!-- Step 2 -->
      <div v-else-if="step === 2">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">
          Step 2: Professional Information
        </h3>
        <form @submit.prevent="submit" class="space-y-6">
          <!-- Specialization -->
          <div>
            <InputLabel for="specialization" value="Specialization" />
            <select
              id="specialization"
              v-model="form.specialization"
              class="form-select mt-1 block w-full"
            >
              <option disabled value="">Select a specialization</option>
              <option value="Web Development">Web Development</option>
              <option value="Graphic Design">Graphic Design</option>
              <option value="Content Writing">Content Writing</option>
              <option value="Digital Marketing">Digital Marketing</option>
              <option value="SEO">SEO</option>
              <option value="Mobile App Development">Mobile App Development</option>
              <option value="UI/UX Design">UI/UX Design</option>
            </select>
            <InputError class="mt-2" :message="form.errors.specialization" />
          </div>

          <!-- Experience From/To (вместо experience textarea) -->
          <div class="flex space-x-4">
            <div>
              <InputLabel for="experience_from" value="Experience From (year)" />
              <TextInput
                id="experience_from"
                type="number"
                v-model="form.experience_from"
                class="mt-1 block w-full"
                placeholder="2024"
                required
              />
              <InputError class="mt-2" :message="form.errors.experience_from" />
            </div>

            <div>
              <InputLabel for="experience_to" value="Experience To (year)" />
              <TextInput
                id="experience_to"
                type="number"
                v-model="form.experience_to"
                class="mt-1 block w-full"
                placeholder="2025 (or empty if current)"
              />
              <InputError class="mt-2" :message="form.errors.experience_to" />
            </div>
          </div>

          <!-- Skills -->
          <div>
            <InputLabel for="skills" value="Skills" />
            <multiselect
              v-model="form.skills"
              :options="availableSkills"
              :multiple="true"
              :close-on-select="false"
              :limit="5"
              placeholder="Select up to 5 skills"
            ></multiselect>
            <InputError class="mt-2" :message="form.errors.skills" />
          </div>

          <!-- Убрали Hourly Rate -->
          <!-- Убрали Portfolio Upload -->

          <div class="flex justify-between">
            <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" @click.prevent="previousStep">
              Previous Step
            </PrimaryButton>
            <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Submit Registration
            </PrimaryButton>
          </div>
        </form>
      </div>

      <!-- Step 3 -->
      <div v-else-if="step === 3" class="text-center">
        <h3 class="text-xl font-semibold text-green-600">
          Registration Successful!
        </h3>
        <p class="mt-4 text-gray-600">
          Thank you for registering as a freelancer. You can now start using the platform.
        </p>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

import { countries } from '@/countries.js';

const step = ref(1);
const page = usePage();     

const user = page.props.auth.user; 

const isFreelancer = computed(() => user && user.role === 'freelancer');

const form = useForm({
  country: '',
  bio: '',
  specialization: '',
  experience_from: '',
  experience_to: '',
  skills: [],
});

// Логика поиска страны
const searchQuery = ref('');
const showDropdown = ref(false);

const filteredCountries = computed(() => {
  if (!searchQuery.value) return countries;
  return countries.filter((country) =>
    country.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

function selectCountry(country) {
  form.country = country;
  searchQuery.value = country;
  showDropdown.value = false;
}

function handleBlur() {
  setTimeout(() => {
    showDropdown.value = false;
  }, 100);
}

// Для выбора навыков
const availableSkills = [
  "Web Development",
  "Graphic Design",
  "Content Writing",
  "Digital Marketing",
  "SEO",
  "Mobile App Development",
  "UI/UX Design",
];

// Переход на следующий шаг
function nextStep() {
  // Сохраняем страну
  form.country = searchQuery.value;
  if (step.value < 2) {
    step.value++;
  }
}

function previousStep() {
  if (step.value > 1) {
    step.value--;
  }
}

function submit() {
  // Перед отправкой убедимся, что тоже берём country из searchQuery
  form.country = searchQuery.value;

  // Отправляем форму
  form.post('/api/become-freelancer', {
    onSuccess: () => {
      step.value = 3; // Переходим на "Complete"
    },
    onError: () => {
      // Обработка ошибок
    },
  });
}
</script>

<style scoped>
ul {
  list-style: none;
  margin: 0;
  padding: 0;
}
li {
  padding: 0.5rem;
}
</style>
