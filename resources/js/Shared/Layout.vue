<template>
  <section class="bg-base-100 text-white min-h-screen pb-6">
    <Navbar :auth="auth" class="sticky top-0" />
    <slot />
  </section>
</template>
<script setup lang="ts">
import Navbar from "./Navbar.vue";
import type { AuthType } from "@/AuthType";

defineProps<{
  auth: AuthType;
}>();
</script>
