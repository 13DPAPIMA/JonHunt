<template>
  <AuthenticatedLayout>
    <!-- Если пользователь - фрилансер, показываем сообщение и выходим -->
    <div
      v-if="isFreelancer"
      class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6 text-center"
    >
      <h2 class="text-2xl font-bold text-gray-800 mb-4">
        Oops! You’re Already a Freelancer
      </h2>
      <p class="text-gray-600">
        Looks like you already have a freelancer profile with us. If you want to
        update your information or explore new opportunities, just visit your
        profile settings. 
      </p>
    </div>

    <!-- Если пользователь НЕ фрилансер, показываем форму -->
    <div v-else class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6">
      <h2 class="text-2xl font-bold text-gray-800 mb-6">
        Become a Freelancer with Us
      </h2>

      <ul class="steps mb-6">
        <li class="step" :class="{ 'step-accent': step >= 1 }">Personal Info</li>
        <li class="step" :class="{ 'step-accent': step >= 2 }">Professional Info</li>
        <li class="step" :class="{ 'step-accent': step === 3 }">Complete</li>
      </ul>

      <!-- Step 1 -->
      <div v-if="step === 1">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">
          Step 1: Personal Details
        </h3>
        <p class="text-gray-600 mb-4 leading-relaxed">
          We’d love to know a little more about you! Your country of residence 
          and a short bio can help potential clients understand who you are 
          and what you’re passionate about.
        </p>

        <form @submit.prevent="nextStep" class="space-y-6">
          <!-- Country -->
          <div>
            <InputLabel for="country-search" value="Country" />
            <p class="mt-2 text-sm text-gray-600">
              Let us know where you’re from so we can better connect you with local and global opportunities.
            </p>
            <div class="relative">
              <TextInput
                type="text"
                id="country-search"
                v-model="searchQuery"
                placeholder="Start typing your country..."
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                       focus:border-indigo-500 focus:ring focus:ring-indigo-200 
                       focus:ring-opacity-50"
                @focus="showDropdown = true"
                @blur="handleBlur"
                required
              />
              <ul
                v-if="showDropdown && filteredCountries.length"
                class="absolute z-10 w-full bg-white border border-gray-300 
                       rounded-md shadow-lg mt-1 max-h-48 overflow-y-auto"
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
              Use this space to briefly describe your background, interests, or any unique qualities that set you apart.
            </p>
            <textarea
              id="bio"
              class="textarea textarea-bordered h-24 mt-1 block w-full resize-none"
              v-model="form.bio"
              required
            />
            <InputError class="mt-2" :message="form.errors.bio" />
          </div>

          <PrimaryButton 
            class="mt-4" 
            :class="{ 'opacity-25': form.processing }" 
            :disabled="form.processing"
          >
            Next Step
          </PrimaryButton>
        </form>
      </div>

      <!-- Step 2 -->
      <div v-else-if="step === 2">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">
          Step 2: Professional Background
        </h3>
        <p class="text-gray-600 mb-4 leading-relaxed">
          Here’s where you can let your professional side shine! Share your 
          main specialization and how long you’ve been active in your field.
          Remember, the more accurate you are, the better clients can match 
          with you.
        </p>

        <form @submit.prevent="submit" class="space-y-6">
          <!-- Specialization -->
          <div>
            <InputLabel for="specialization" value="Specialization" />
            <p class="mt-2 text-sm text-gray-600">
              Pick the skill area or industry where you feel most at home.
            </p>
            <select
              id="specialization"
              v-model="form.specialization"
              class="form-select mt-1 block w-full 
                     border border-gray-300 rounded-md shadow-sm 
                     focus:border-indigo-500 focus:ring focus:ring-indigo-200 
                     focus:ring-opacity-50"
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

          <!-- Experience From/To -->
          <div class="flex space-x-4">
            <div class="w-1/2">
              <InputLabel for="experience_from" value="Experience From (year)" />
              <p class="mt-2 text-sm text-gray-600">
                When did you officially begin your journey in this field?
              </p>
              <TextInput
                id="experience_from"
                type="number"
                v-model="form.experience_from"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                       focus:border-indigo-500 focus:ring focus:ring-indigo-200 
                       focus:ring-opacity-50"
                placeholder="e.g. 2018"
                required
              />
              <InputError class="mt-2" :message="form.errors.experience_from" />
            </div>

            <div class="w-1/2">
              <InputLabel for="experience_to" value="Experience To (year)" />
              <p class="mt-2 text-sm text-gray-600">
                If you finished at a certain time, or just set it to the current year if you’re still active.
              </p>
              <TextInput
                id="experience_to"
                type="number"
                v-model="form.experience_to"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm 
                       focus:border-indigo-500 focus:ring focus:ring-indigo-200 
                       focus:ring-opacity-50"
                placeholder="e.g. 2023"
              />
              <InputError class="mt-2" :message="form.errors.experience_to" />
            </div>
          </div>

          <!-- Skills -->
          <div>
            <InputLabel for="skills" value="Core Skills" />
            <p class="mt-2 text-sm text-gray-600">
              Highlight the top skills that showcase your strengths. 
              You can select up to 5.
            </p>
            <multiselect
              v-model="form.skills"
              :options="availableSkills"
              :multiple="true"
              :close-on-select="false"
              :limit="5"
              placeholder="Choose or type a skill..."
              class="mt-1"
            ></multiselect>
            <InputError class="mt-2" :message="form.errors.skills" />
          </div>

          <div class="flex justify-between">
            <PrimaryButton
              class="mt-4"
              :class="{ 'opacity-25': form.processing }"
              @click.prevent="previousStep"
            >
              Previous Step
            </PrimaryButton>
            <PrimaryButton
              class="mt-4"
              :class="{ 'opacity-25': form.processing }"
              :disabled="form.processing"
            >
              Submit Registration
            </PrimaryButton>
          </div>
        </form>
      </div>

      <!-- Step 3 -->
      <div v-else-if="step === 3" class="text-center">
        <h3 class="text-2xl font-bold text-green-600 mb-4">
          Welcome Aboard!
        </h3>
        <p class="text-gray-600 leading-relaxed">
          Congratulations on completing your registration as a freelancer!
          You’re now all set to create gigs, connect with clients, and grow
          your professional profile on our platform. Let’s make something
          amazing together!
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

// Данные о пользователе (role) приходят через Inertia
const page = usePage();     
const user = page.props.auth.user;

// Проверяем, является ли пользователь фрилансером
const isFreelancer = computed(() => user && user.role === 'freelancer');

// Шаги
const step = ref(1);

// Форма
const form = useForm({
  country: '',
  bio: '',
  specialization: '',
  experience_from: '',
  experience_to: '',
  skills: [],
});

// Список стран
import { countries } from '@/countries.js';

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

// Список доступных навыков
const availableSkills = [
  "Web Development",
  "Graphic Design",
  "Content Writing",
  "Digital Marketing",
  "SEO",
  "Mobile App Development",
  "UI/UX Design",
];

// Шаг 1 -> Шаг 2
function nextStep() {
  form.country = searchQuery.value;
  if (step.value < 2) {
    step.value++;
  }
}

// Шаг 2 -> Предыдущий шаг
function previousStep() {
  if (step.value > 1) {
    step.value--;
  }
}

// Шаг 2 -> Submit
function submit() {
  form.country = searchQuery.value;
  form.post('/api/become-freelancer', {
    onSuccess: () => {
      step.value = 3;
    },
    onError: () => {
      // Обработка ошибок
    },
  });
}
</script>
