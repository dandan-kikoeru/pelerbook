<template>
  <Head
    :title="
      post.data.user.firstname +
      ' ' +
      post.data.user.surname +
      ' - ' +
      headTitle(post.data.caption)
    "
  />
  <div class="card max-w-lg bg-neutral shadow-xl mx-auto mt-4">
    <Post :post="post.data" :auth="auth" :postIndex="0" />
  </div>
</template>
<script setup lang="ts">
import type { PostType } from '@/PostType'
import Post from '../Shared/Post.vue'
import type { AuthType } from '@/AuthType'

const { post, auth } = defineProps<{
  post: { data: PostType }
  auth: AuthType
}>()

const headTitle = (input, maxLength = 64) => {
  const textWithoutTags = input.replace(/<\/?[^>]+(>|$)/g, '')
  const truncatedText = textWithoutTags
    .slice(0, maxLength)
    .replace(/\s+\S*$/, '')
  if (textWithoutTags.length > truncatedText.length) {
    return truncatedText + '...'
  }
  return truncatedText
}
</script>
