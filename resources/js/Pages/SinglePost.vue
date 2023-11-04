<template>
  <Head
    :title="
      post.data.user.firstname +
      ' ' +
      post.data.user.surname +
      ' - ' +
      removeHtmlTags(post.data.caption)
    "
  />
  <div class="card max-w-lg bg-[#242526] shadow-xl mx-auto mt-4">
    <Post :post="post.data" :auth="auth" />
  </div>
</template>
<script setup lang="ts">
import type { PostType } from "@/PostType";
import Post from "../Shared/Post.vue";
import type { AuthType } from "@/AuthType";

const { post, auth } = defineProps<{
  post: { data: PostType };
  auth: AuthType;
}>();

const removeHtmlTags = (input) => {
  return input.replace(/<\/?[^>]+(>|$)/g, "");
};
</script>
