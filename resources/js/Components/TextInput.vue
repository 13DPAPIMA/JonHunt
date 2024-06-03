<template>
    <input
      class="appearance-none border rounded-md dark:bg-gray-900 dark:text-gray-300 dark:bg-black-900 py-2 px-3 text-black-700 leading-tight focus:border-red-500 focus:outline-none focus:shadow-outline shadow-sm"
      v-model="model"
      ref="input"
    />
</template>

  <script setup>
  import { onMounted, ref, defineModel, defineExpose } from 'vue';
  
  const model = defineModel({
      type: String,
      required: true,
  });
  
  const input = ref(null);
  
  onMounted(() => {
      if (input.value.hasAttribute('autofocus')) {
          input.value.focus();
      }
  });
  
  defineExpose({ focus: () => input.value.focus() });
  </script>
  
  <style scoped>
  
  </style>
  