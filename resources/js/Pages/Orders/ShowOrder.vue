<template>
  <AuthenticatedLayout>
    <Head title="Order Details" />

    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
      <h2 class="text-2xl font-bold mb-2">Order #{{ order.id }}</h2>

      <!-- Информация о заказе -->
      <div class="mb-4">
        <p>Job Title: {{ order.job_application.job_ad.Title }}</p>
        <p>Client: {{ order.client.name }}</p>
        <p>Freelancer: {{ order.freelancer.name }}</p>
        <p>Status: {{ order.status }}</p>
      </div>

      <!-- Если заказ не завершён и не отменён -->
      <div v-if="order.status === 'in_progress'" class="space-x-4">
        <!-- Завершить заказ -->
        <form
          @submit.prevent="updateStatus('completed')"
          class="inline-block"
        >
          <button
            type="submit"
            class="btn bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
          >
            Mark as Completed
          </button>
        </form>
        <!-- Отменить заказ -->
        <form
          @submit.prevent="updateStatus('cancelled')"
          class="inline-block"
        >
          <button
            type="submit"
            class="btn bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
          >
            Cancel Order
          </button>
        </form>
      </div>

      <!-- Если заказ завершён -->
      <div v-else-if="order.status === 'completed'" class="text-green-600 font-bold">
        This order has been completed.
      </div>

      <!-- Если заказ отменён -->
      <div v-else-if="order.status === 'cancelled'" class="text-red-600 font-bold">
        This order was cancelled.
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'

const { props } = usePage()
const order = props.order

function updateStatus(status) {
  router.post(route('orders.updateStatus', order.id), {
    status,
    // Либо PUT/PATCH, но проще через POST + hidden input _method=PUT
    // Или можно напрямую: router.put(...)
  })
}
</script>
