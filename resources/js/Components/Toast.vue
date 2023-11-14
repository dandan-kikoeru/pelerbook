<template>
  <div class="alert alert-error">
    <slot />
  </div>
</template>
<script setup>
import { onMounted } from 'vue'

const emit = defineEmits()

onMounted(() => {
  setTimeout(() => {
    emit('close')
  }, 5000)
})
</script>
