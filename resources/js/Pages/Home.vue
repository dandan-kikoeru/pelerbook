<template>
  <Head title="Pelerbook"></Head>
  <div class="bg-neutral h-32 p-4 rounded-2xl mt-4 max-w-lg mx-auto">
    <div class="flex gap-4 border-b pb-4 border-accent">
      <Link class="aspect-square h-12" :href="'/' + auth.user.id">
        <img
          :src="auth.user.avatar"
          class="rounded-full object-cover w-12 h-12"
        />
      </Link>
      <button
        @click="toggleCreatePost"
        class="bg-accent hover:bg-accent w-full rounded-full px-6 py-3 text-start"
        v-html="`What's on your mind, ` + auth.user.firstname + `?`"
      />
    </div>
  </div>
  <div
    class="fixed top-0 w-screen h-screen flex justify-center items-center bg-black/50 z-50"
    v-if="showCreatePost"
  >
    <CreatePost
      :firstname="auth.user.firstname"
      @close="toggleCreatePost"
      @refetch-data="refetchData"
      ref="createPost"
    />
  </div>
  <div
    v-for="(post, index) in posts.data"
    class="card max-w-lg bg-neutral mx-auto mt-4"
    :key="post.id"
    ref="postsContainer"
  >
    <Post
      :post="post"
      :auth="auth"
      :postIndex="index"
      @refetch-post="refetchPost"
      @refetch-data="refetchData"
    />
  </div>
  <div class="-translate-y-[64rem]" ref="target" />
  <PostSkeleton v-for="i in 2" v-if="isFetching" />
</template>
<script setup lang="ts">
import { ref } from 'vue'
import CreatePost from '../Shared/CreatePost.vue'
import Post from '../Shared/Post.vue'
import type { AuthType } from '@/AuthType'
import type { PostsType } from '@/PostsType'
import { onClickOutside, useIntersectionObserver } from '@vueuse/core'
import axios from 'axios'
import PostSkeleton from '../Shared/PostSkeleton.vue'

const { auth } = defineProps<{
  auth: AuthType
}>()

const posts = ref<PostsType>({ data: [], links: null })
const page = ref<number>(1)
const isFetching = ref<boolean>(false)

const fetchData = async () => {
  try {
    isFetching.value = true
    const response = await axios.get(`/api/post?page=${page.value}`)
    posts.value.data = [...posts.value.data, ...response.data.data]
    posts.value.links = response.data.links
    page.value++
  } catch (error) {
    console.error('Error fetching data:', error)
  } finally {
    isFetching.value = false
  }
}

const refetchPost = async (postIndex) => {
  const response = await axios.get(
    `/api/post/${posts.value.data[postIndex].id}`
  )
  posts.value.data[postIndex] = response.data.data
}

const refetchData = async () => {
  const response = await axios.get(`/api/post?take=${page.value - 1}`)
  posts.value.data = [...response.data.data]
}

const target = ref<HTMLElement | null>(null)
const { stop } = useIntersectionObserver(target, ([{ isIntersecting }]) => {
  if (!isIntersecting) {
    return
  }
  fetchData()
  if (!posts.value.links.next) {
    stop()
  }
})
fetchData()

const showCreatePost = ref<boolean>(false)
const createPost = ref<HTMLElement | null>(null)

const toggleCreatePost = () => {
  showCreatePost.value = !showCreatePost.value
}

onClickOutside(createPost, () => toggleCreatePost())
</script>
