<template>
    <AuthenticatedLayout>
      <Head title="My Orders" />
  
      <div class="max-w-7xl mx-auto p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
  
        <h1 class="text-2xl font-bold mb-6">My Orders</h1>
  
        <!-- Блок: заказы, где пользователь — клиент -->
        <div class="mb-8">
          <h2 class="text-xl font-semibold mb-2">Orders as Client</h2>
  
          <div v-if="!ordersAsClient.length" class="text-gray-500">
            You have no orders as client.
          </div>
  
          <div v-else class="space-y-4">
            <div
              v-for="order in ordersAsClient"
              :key="order.id"
              class="border p-4 rounded-md shadow-sm bg-gray-50 dark:bg-gray-700"
            >
              <div class="flex justify-between items-center">
                <div>
                  <div class="text-lg font-bold">
                    Job: {{ order.job_application.job_ad.Title }}
                  </div>
                  <div class="text-sm text-gray-600">
                    Freelancer: {{ order.freelancer.name }}
                  </div>
                  <div class="text-sm">
                    Status: {{ order.status }}
                  </div>
                </div>
                <Link
                  :href="route('orders.show', order.id)"
                  class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                >
                  View
                </Link>
              </div>
            </div>
          </div>
        </div>
  
        <!-- Блок: заказы, где пользователь — фрилансер -->
        <div>
          <h2 class="text-xl font-semibold mb-2">Orders as Freelancer</h2>
  
          <div v-if="!ordersAsFreelancer.length" class="text-gray-500">
            You have no orders as freelancer.
          </div>
  
          <div v-else class="space-y-4">
            <div
              v-for="order in ordersAsFreelancer"
              :key="order.id"
              class="border p-4 rounded-md shadow-sm bg-gray-50 dark:bg-gray-700"
            >
              <div class="flex justify-between items-center">
                <div>
                  <div class="text-lg font-bold">
                    Job: {{ order.job_application.job_ad.Title }}
                  </div>
                  <div class="text-sm text-gray-600">
                    Client: {{ order.client.name }}
                  </div>
                  <div class="text-sm">
                    Status: {{ order.status }}
                  </div>
                </div>
                <Link
                  :href="route('orders.show', order.id)"
                  class="btn bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
                >
                  View
                </Link>
              </div>
            </div>
          </div>
        </div>
  
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { usePage, Head, Link } from '@inertiajs/vue3'
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
  
  const { props } = usePage()
  const ordersAsClient = props.ordersAsClient
  const ordersAsFreelancer = props.ordersAsFreelancer
  </script>
  