<template>
    <AuthenticatedLayout>
      <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
        <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ jobAd.Title }}</h2>
        <p class="text-lg text-gray-700 mb-4">{{ jobAd.Description }}</p>
        <p class="text-xl font-semibold text-gray-600 mb-6">
          Price per unit: ${{ jobAd.Price }}
        </p>
  
        <!-- Убрали выбор количества -->
        <form @submit.prevent="submitApplication">
          <!-- Поле для требований -->
          <div class="mb-4">
            <label
              for="requirements"
              class="block text-sm font-medium text-gray-700"
            >
              Requirements
            </label>
            <textarea
              v-model="form.requirements"
              id="requirements"
              rows="5"
              class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm
                     focus:ring-blue-500 focus:border-blue-500"
              placeholder="Enter your job requirements..."
            ></textarea>
            <div v-if="form.errors.requirements" class="text-red-500 text-sm">
              {{ form.errors.requirements }}
            </div>
          </div>
  
          <!-- Кнопка отправки -->
          <button
            type="submit"
            class="btn bg-blue-600 text-white hover:bg-blue-700 px-6 py-2 rounded-md"
          >
            Submit Application
          </button>
        </form>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
  import { useForm } from "@inertiajs/vue3";
  
  const props = defineProps({
    jobAd: Object,
  });
  
  // Поля формы (только requirements)
  const form = useForm({
    requirements: "",
  });
  
  /**
   * При нажатии "Submit Application":
   * Отправляем POST на /jobs/{jobAd.id}/apply
   * Где в контроллере будет списание денег + создание заявки
   */
  function submitApplication() {
    if (!form.requirements.trim()) {
      form.errors.requirements = "Please enter your job requirements.";
      return;
    }
  
    form.post(`/jobs/${props.jobAd.id}/apply`, {
      onSuccess: () => {
        alert("Application submitted and payment processed!");
      },
      onError: (errors) => {
        // Если недост. средств или что-то ещё, придёт ошибка
        alert(errors.message || "An error occurred during application.");
      },
    });
  }
  </script>
  