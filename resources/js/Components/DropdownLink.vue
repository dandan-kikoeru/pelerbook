<template>
  <Link class="w-full text-start hover:bg-[#3a3b3c] p-2 rounded-md">
    <span class="material-symbols-outlined align-middle">{{ icon }}</span>
    <span class="align-text-top ml-2">{{ label }}</span>
  </Link>
</template>

<script setup lang="ts">
const { icon, label } = defineProps<{
  icon: string;
  label: string;
}>();
</script>
