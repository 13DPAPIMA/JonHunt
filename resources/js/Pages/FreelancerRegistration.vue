<template>
  <Head title="Freelancer Registration" />
  <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6">
      <h2 class="text-2xl font-semibold text-gray-800 mb-6">Freelancer Registration</h2>

      <ul class="steps mb-6">
        <li class="step" :class="{ 'step-accent': step >= 1 }">Personal Info</li>
        <li class="step" :class="{ 'step-accent': step >= 2 }">Professional Info</li>
        <li class="step" :class="{ 'step-accent': step >= 3 }">Portfolio</li>
        <li class="step" :class="{ 'step-accent': step === 4 }">Complete</li>
      </ul>

      <!-- Step 1 -->
      <div v-if="step === 1">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Step 1: Personal Information</h3>
        <form @submit.prevent="nextStep" class="space-y-6">
          <div>
            <InputLabel for="name" value="Name" />
            <p class="mt-2 text-sm text-gray-600">Write your display name</p>
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

          <div>
            <InputLabel for="bio" value="Bio" />
            <p class="mt-2 text-sm text-gray-600">Write bio about yourself to let people know about you</p>
            <textarea
              id="bio"
              type="bio"
              class="textarea textarea-bordered h-24 mt-1 block w-full resize-none"
              v-model="form.bio"
              required
              autocomplete="bio"
            />
            <InputError class="mt-2" :message="form.errors.bio" />
          </div>

          <div>
            <InputLabel for="country" value="Country" />
            <p class="mt-2 text-sm text-gray-600">Choose country where you live</p>
            <div class="relative">
              <TextInput
                type="text"
                id="country-search"
                v-model="searchQuery"
                placeholder="Start typing your country..."
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                @focus="showDropdown = true"
                @blur="handleBlur"
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

          <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Next Step
          </PrimaryButton>
        </form>
      </div>

      <!-- Step 2 -->
      <div v-else-if="step === 2">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Step 2: Professional Information</h3>
        <form @submit.prevent="nextStep" class="space-y-6">
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
            <!-- Добавьте другие специализации -->
          </select>
            <InputError class="mt-2" :message="form.errors.specialization" />
          </div>

          <div>
            <InputLabel for="experience" value="Experience" />
            <textarea
              id="experience"
              class=" textarea  resize-none mt-1 block w-full h-32 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              v-model="form.experience"
              required
            ></textarea>
            <InputError class="mt-2" :message="form.errors.experience" />
          </div>

          <div>
            <label for="skills" class="block text-sm font-medium text-gray-700">Skills</label>
            <multiselect
              v-model="form.skills"
              :options="availableSkills"
              :multiple="true"
              :close-on-select="false"
              placeholder="Select up to 5 skills"
              :limit="5"
            ></multiselect>
            <InputError class="mt-2" :message="form.errors.skills" />
          </div>
          
          <div>
            <InputLabel for="hourly_rate" value="Hourly Rate ($)" />
            <TextInput
              type="number"
              id="hourly_rate"
              v-model="form.hourly_rate"
              required
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <InputError class="mt-2" :message="form.errors.hourly_rate" />
          </div>

          <div class="flex justify-between">
            <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" @click.prevent="previousStep">
              Previous Step
            </PrimaryButton>
            <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Next Step
            </PrimaryButton>
          </div>
        </form>
      </div>

      <!-- Step 3 -->
      <div v-else-if="step === 3">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Step 3: Upload Portfolio</h3>
        <form @submit.prevent="submit" class="space-y-6">
          <div>
            <InputLabel for="portfolio_photos" value="Portfolio (optional)" />
            <input
              type="file"
              id="portfolio_photos"
              name="portfolio_photos[]"
              @change="handleFileUpload"
              multiple
              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            />
            <div v-if="form.portfolio_photos && form.portfolio_photos.length">
              <h4 class="mt-4">Selected Files:</h4>
              <ul>
                <li v-for="(file, index) in form.portfolio_photos" :key="index">
                  {{ file.name }}
                </li>
              </ul>
              </div>
            <InputError class="mt-2" :message="form.errors.portfolio_photos" />
          </div>

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

      <div v-if="step === 4" class="text-center">
        <h3 class="text-xl font-semibold text-green-600">Registration Successful!</h3>
        <p class="mt-4 text-gray-600">Thank you for registering as a freelancer. You can now start using the platform.</p>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { countries } from '@/countries.js';
import Multiselect from "vue-multiselect";
import "vue-multiselect/dist/vue-multiselect.min.css";

const step = ref(1);


const form = useForm({
  name: '',
  bio: '',
  country: '',
  specialization: '',
  experience: '',
  hourly_rate: '',
  portfolio_photos: [],
  skills: [],
});

const handleFileUpload = (event) => {
  form.portfolio_photos = [...event.target.files];
  console.log(event.target.files);
};

const nextStep = () => {
  if (step.value < 3) {
    step.value++;
  }
};

const previousStep = () => {
  if (step.value > 1) {
    step.value--;
  }
};

const submit = () => {
  form.post('/api/become-freelancer', {
    forceFormData: true,
    onSuccess: () => {
      step.value = 4;
    },
  });
};

const searchQuery = ref('');
const showDropdown = ref(false);

const filteredCountries = computed(() => {
  if (!searchQuery.value) return countries;
  return countries.filter((country) =>
    country.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const selectCountry = (country) => {
  form.country = country;
  searchQuery.value = country;
  showDropdown.value = false;
};

const handleBlur = () => {
  setTimeout(() => {
    showDropdown.value = false;
  }, 100);
};



const availableSkills = [
  "Web Development",
  "Graphic Design",
  "Content Writing",
  "Digital Marketing",
  "SEO",
  "Mobile App Development",
  "UI/UX Design",
];


</script>

<style scoped>
form div {
  margin-bottom: 1rem;
}
ul {
  list-style: none;
  padding: 0;
  margin: 0;
}
li {
  padding: 0.5rem;
}
</style>
