<template>
  <Head
    :title="
      post.data[0].user.firstname +
      ' ' +
      post.data[0].user.surname +
      ' - ' +
      removeHtmlTags(post.data[0].caption)
    "
  />
  <div class="card max-w-lg bg-[#242526] shadow-xl mx-auto mt-4">
    <Post :post="post.data[0]" :auth="auth" />
  </div>
</template>
<script setup>
import Post from "../Shared/Post.vue";
defineProps({
  post: Object,
  auth: Object,
});

const removeHtmlTags = (input) => {
  return input.replace(/<\/?[^>]+(>|$)/g, "");
};
</script>
