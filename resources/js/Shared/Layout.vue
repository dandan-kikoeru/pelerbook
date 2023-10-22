<template>
  <Navbar />
  <section class="pt-16">
    <slot />
  </section>
</template>
<script setup>
import Navbar from "./Navbar.vue";
</script>
