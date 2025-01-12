<template>
  <AuthenticatedLayout>
    <Head title="Order Details" />

    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
      <h2 class="text-2xl font-bold mb-2">Order #{{ order.id }}</h2>

      <!-- Информация о заказе -->
      <div class="mb-4">
        <p><strong>Job Title:</strong> {{ order.job_application.job_ad.Title }}</p>
        <p><strong>Client:</strong> {{ order.client.name }}</p>
        <p><strong>Freelancer:</strong> {{ order.freelancer.name }}</p>
        <p><strong>Status:</strong> {{ order.status }}</p>
      </div>

      <!-- Форма отправки работы фрилансером -->
      <div v-if="order.status === 'in_progress'" class="mb-6">
        <h2 class="text-lg font-bold mb-2">Submit Your Work</h2>
        <form @submit.prevent="submitWork" class="space-y-4">
          <textarea
            v-model="resultText"
            placeholder="Describe your work"
            class="w-full p-2 border rounded"
            required
          ></textarea>
          <input type="file" @change="handleFileUpload" />

          <button
            type="submit"
            class="btn bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
          >
            Submit Work
          </button>
        </form>
      </div>

      <div v-if="order.result_text || order.result_file" class="mb-6">
        <h2 class="text-lg font-bold mb-2">Submitted Work</h2>
        <p><strong>Description:</strong> {{ order.result_text }}</p>
        <a
          v-if="order.result_file"
          :href="`${order.result_file}`"
          target="_blank"
          class="text-blue-500 underline"
        >
          Download File
        </a>
        <!-- Завершение заказа заказчиком -->
        <div v-if="order.status === 'submitted'" class="mt-4">
          <form @submit.prevent="completeOrder">
            <button
              type="submit"
              class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
            >
              Complete Order
            </button>
          </form>
        </div>
      </div>

      <!-- Статусы заказа -->
      <div>
        <div
          v-if="order.status === 'completed'"
          class="text-green-600 font-bold"
        >
          This order has been completed.
        </div>
        <div
          v-else-if="order.status === 'cancelled'"
          class="text-red-600 font-bold"
        >
          This order was cancelled.
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';

const { props } = usePage();
const order = props.order;

// Поля для результата работы
const resultText = ref('');
const resultFile = ref(null);

// Обработка загрузки файла
const handleFileUpload = (e) => {
  resultFile.value = e.target.files[0];
};

// Отправка работы фрилансером
const submitWork = async () => {
  const formData = new FormData();
  formData.append('result_text', resultText.value);
  if (resultFile.value) {
    formData.append('result_file', resultFile.value);
  }

  await axios
    .post(route('orders.submit-work', order.id), formData)
    .then(() => {
      alert('Work submitted successfully!');
      location.reload();
    })
    .catch((error) => {
      console.error(error);
      alert('Failed to submit work.');
    });
};

// Завершение заказа заказчиком
const completeOrder = async () => {
  await axios
    .post(route('orders.complete', order.id))
    .then(() => {
      alert('Order completed!');
      location.reload();
    })
    .catch((error) => {
      console.error(error);
      alert('Failed to complete order.');
    });
};
</script>
