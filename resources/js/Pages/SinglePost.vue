<template>
  <Head
    :title="post[0].user.firstname + ' ' + post[0].user.surname + ' - ' + removeHtmlTags(post[0].caption)"
  ></Head>
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

const removeHtmlTags = (input) => {
  return input.replace(/<\/?[^>]+(>|$)/g, "");
};
</script>
