<template>
  <div class="card max-w-lg bg-[#242526] shadow-xl mx-auto mt-4">
    <Post :post="post[0]" :auth="auth" />
  </div>
</template>
<script setup>
import Post from "../Shared/Post.vue";
defineProps({
  post: Object,
  auth: Object,
});
</script>
