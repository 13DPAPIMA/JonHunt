<template>
    <Head title="Freelancer Registration" />
    <AuthenticatedLayout>
      <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg mt-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Freelancer Registration</h2>
  
        <!-- Пошаговая форма -->
        <div v-if="step === 1">
          <h3 class="text-xl font-semibold text-gray-700 mb-4">Step 1: Personal Information</h3>
          <form @submit.prevent="nextStep" class="space-y-6">
            <!-- Поле для имени -->
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
  
            <!-- Поле для email -->
            <div>
              <InputLabel for="email" value="Email" />
              <TextInput
                id="email"
                type="email"
                class="mt-1 block w-full"
                v-model="form.email"
                required
                autocomplete="email"
              />
              <InputError class="mt-2" :message="form.errors.email" />
            </div>
  
            <!-- Поле для поиска и выбора страны -->
            <div>
              <InputLabel for="country" value="Country" />
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
  
        <div v-else-if="step === 2">
          <h3 class="text-xl font-semibold text-gray-700 mb-4">Step 2: Professional Information</h3>
          <form @submit.prevent="nextStep" class="space-y-6">
            <div>
              <InputLabel for="specialization" value="Specialization" />
              <TextInput
                id="specialization"
                type="text"
                class="mt-1 block w-full"
                v-model="form.specialization"
                required
                autocomplete="specialization"
              />
              <InputError class="mt-2" :message="form.errors.specialization" />
            </div>
  
            <div>
              <InputLabel for="experience" value="Experience" />
              <textarea
                id="experience"
                class="mt-1 block w-full h-32 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                v-model="form.experience"
                required
              ></textarea>
              <InputError class="mt-2" :message="form.errors.experience" />
            </div>
  
            <div>
              <InputLabel for="hourly_rate" value="Hourly Rate ($)" />
              <input
                type="number"
                id="hourly_rate"
                v-model="form.hourly_rate"
                required
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              />
              <InputError class="mt-2" :message="form.errors.hourly_rate" />
            </div>
  
            <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Next Step
            </PrimaryButton>
          </form>
        </div>
  
        <div v-else-if="step === 3">
          <h3 class="text-xl font-semibold text-gray-700 mb-4">Step 3: Upload Portfolio</h3>
          <form @submit.prevent="submit" class="space-y-6">
            <div>
              <InputLabel for="portfolio" value="Portfolio (optional)" />
              <input
                type="file"
                id="portfolio"
                @change="handleFileUpload"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
              />
              <InputError class="mt-2" :message="form.errors.portfolio" />
            </div>
  
            <PrimaryButton class="mt-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
              Submit Registration
            </PrimaryButton>
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
  
  // Текущий шаг формы
  const step = ref(1);
  
  // Форма для регистрации
  const form = useForm({
    name: '',
    email: '',
    country: '',
    specialization: '',
    experience: '',
    hourly_rate: '',
    portfolio: null,
  });
  
  // Обработка загрузки файла
  const handleFileUpload = (event) => {
    form.portfolio = event.target.files[0];
  };
  
  // Переход к следующему шагу
  const nextStep = () => {
    if (step.value < 3) {
      step.value++;
    }
  };
  
  // Отправка формы
  const submit = () => {
    form.post('/api/become-freelancer', {
      onSuccess: () => {
        step.value = 4;
      },
    });
  };
  
  // Управление поиском стран
  const searchQuery = ref('');
  const showDropdown = ref(false);
  
  // Фильтрация списка стран
  const filteredCountries = computed(() => {
    if (!searchQuery.value) return countries;
    return countries.filter((country) =>
      country.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
  });
  
  // Выбор страны
  const selectCountry = (country) => {
    form.country = country;
    searchQuery.value = country;
    showDropdown.value = false;
  };
  
  // Закрытие выпадающего списка
  const handleBlur = () => {
    setTimeout(() => {
      showDropdown.value = false;
    }, 100);
  };
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
  