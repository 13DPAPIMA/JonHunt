<template>
    <AuthenticatedLayout>
    <div class="max-w-4xl mx-auto bg-white shadow sm:rounded-lg p-6 my-10">
      <h2 class="text-2xl font-bold mb-4">Order #{{ order.id }}</h2>
      <p>Status: <strong>{{ order.status }}</strong></p>
  
      <div class="my-4">
        <h3 class="text-xl font-semibold">Requirements:</h3>
       <!-- <p class="text-gray-700">{{ order.jobApplication.requirements }}</p> --> 
      </div>
  
      <div class="my-4">
        <h3 class="text-xl font-semibold">Freelancer Info:</h3>
        <p>Name: {{ order.freelancer.name }}</p>
        <p>Email: {{ order.freelancer.email }}</p>
      </div>
  
      <div class="my-4">
        <h3 class="text-xl font-semibold">Client Info:</h3>
        <p>Name: {{ order.client.name }}</p>
        <p>Email: {{ order.client.email }}</p>
      </div>
  
      <div v-if="canUpdateOrder">
        <button
          @click="updateOrderStatus('completed')"
          class="bg-red-600 text-white px-4 py-2 rounded-md"
        >
          Mark as Completed
        </button>
        <button
          @click="updateOrderStatus('cancelled')"
          class="bg-red-600 text-white px-4 py-2 rounded-md ms-2"
        >
          Cancel
        </button>
      </div>
    </div>
   </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import { useForm, usePage } from '@inertiajs/vue3';
  
  const { props } = usePage();
  const order = props.order;
  

  const canUpdateOrder = (order.freelancer_id === props.auth.user.id) || 
                         (order.client_id === props.auth.user.id);
  
  const form = useForm({
    status: '',
  });
  
  function updateOrderStatus(newStatus) {
    form.put(route('orders.updateStatus', order.id), {
      data: { status: newStatus },
      onSuccess: () => {
        alert(`Order status changed to: ${newStatus}`);
      },
      onError: (errors) => {
        console.error(errors);
      },
    });
  }
  </script>
  