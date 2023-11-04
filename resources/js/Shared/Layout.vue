<template>
  <Navbar :auth="auth" class="fixed" />
  <section class="bg-[#18191a] text-[#e4e6eb] py-16 min-h-screen">
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
