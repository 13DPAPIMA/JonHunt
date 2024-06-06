<template>
  <div>
    <h1>{{ user.name }}</h1>
    <p>{{ user.description }}</p>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  }
};
</script>