<template>
    <div class="max-w-4xl mx-auto bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
      <h2 class="text-2xl font-semibold text-gray-900 mb-6">
        Your current balance: ${{ balance }}
      </h2>
  
      <form @submit.prevent="submitForm">
        <div class="mb-4">
          <label for="amount" class="block text-sm font-medium text-gray-700">Deposit amount</label>
          <input
            v-model="form.amount"
            type="number"
            id="amount"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm"
            placeholder="Введите сумму"
          />
          <div v-if="form.errors.amount" class="text-red-500 text-sm">
            {{ form.errors.amount }}
          </div>
        </div>
        <button type="submit" class="btn bg-blue-600 text-white hover:bg-blue-700">
          Deposit
        </button>
      </form>
    </div>
  </template>
  
  <script setup>
  import { useForm } from '@inertiajs/vue3';
  import { defineProps } from 'vue';
  
  const props = defineProps({
    balance: Number,
  });
  
  const form = useForm({
    amount: '',
  });
  
  const submitForm = () => {
    form.post(route('balance.store'), {
      onSuccess: () => {
        // Обработать успех
      },
    });
  };
  </script>
