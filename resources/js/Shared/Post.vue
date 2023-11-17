<template>
  <div class="card-body p-4">
    <div class="flex gap-2">
      <Link :href="'/' + post.user.id">
        <img
          :src="post.user.avatar"
          class="w-12 h-12 rounded-full cursor-pointer object-cover"
        />
      </Link>
      <div>
        <Link
          :href="'/' + post.user.id"
          class="w-fit text-lg font-semibold hover:underline"
        >
          {{ post.user.firstname }} {{ post.user.surname }} </Link
        ><br />
        <Link :href="'/post/' + post.id" class="hover:underline text-sm">
          {{ post.createdAt }}
        </Link>
      </div>
    </div>
    <div
      v-if="post.user.id == auth.user.id"
      @click="toggleDropdown"
      class="absolute right-4 hover:bg-accent btn btn-ghost btn-circle"
    >
      <span class="material-symbols-outlined p-2 select-none">more_horiz</span>
    </div>
    <p v-html="post.caption" class="pb-2" />
    <img :src="post.image" class="rounded-md" />
    <p v-if="post.likes" class="flex gap-1">
      <span class="material-symbols-outlined text-primary"> thumb_up </span
      >{{ post.likes }}
    </p>
    <div class="border-accent border-y py-1">
      <form @submit.prevent="() => likePost(post.id)">
        <button
          :class="
            post.likedByUser
              ? 'btn btn-ghost btn-block text-primary normal-case'
              : 'btn btn-ghost btn-block active:text-primary normal-case'
          "
          preserve-scroll
        >
          <span class="material-symbols-outlined"> thumb_up </span>Like
        </button>
      </form>
    </div>
  </div>

  <div
    v-if="showDropdown"
    class="absolute top-16 right-8 bg-neutral shadow-[0px_0px_15px_15px_rgba(0,0,0,0.1)] p-2 rounded-2xl z-20"
    ref="dropdown"
  >
    <button
      @click="toggleEdit()"
      class="text-start hover:bg-accent p-2 rounded-md w-80 flex"
    >
      <span class="material-symbols-outlined align-middle">edit</span>
      <span class="align-text-top ml-2">Edit post</span>
    </button>
    <form @submit.prevent="() => deletePost(post.id)">
      <button class="text-start hover:bg-accent p-2 rounded-md w-80 flex">
        <span class="material-symbols-outlined align-middle">delete</span>
        <span class="align-text-top ml-2">Delete post</span>
      </button>
    </form>
    <div
      v-if="showEdit"
      class="fixed top-0 left-0 w-screen h-screen flex justify-center items-center bg-black/50 z-50"
    >
      <EditPost
        :post="post"
        @close-edit="toggleEdit"
        ref="editPost"
        @refetch-post="refetchPost"
      />
    </div>
  </div>
</template>
<script setup lang="ts">
import { ref } from 'vue'
import EditPost from './EditPost.vue'
import type { PostType } from '@/PostType'
import type { AuthType } from '@/AuthType'
import { onClickOutside } from '@vueuse/core'
import { useForm } from '@inertiajs/vue3'

const emit = defineEmits(['refetchPost', 'refetchData'])

const { post, auth, postIndex } = defineProps<{
  post: PostType
  auth: AuthType
  postIndex: number
}>()

const refetchPost = () => {
  emit('refetchPost', postIndex)
  toggleDropdown()
}

const showDropdown = ref<boolean>(false)
const dropdown = ref<HTMLElement | null>(null)

const toggleDropdown = () => (showDropdown.value = !showDropdown.value)
onClickOutside(dropdown, () => toggleDropdown())

const showEdit = ref<boolean>(false)
const editPost = ref<HTMLElement | null>(null)

const toggleEdit = () => (showEdit.value = !showEdit.value)
onClickOutside(editPost, () => toggleEdit())

const form = useForm({})
const deletePost = (id: string) => {
  form.post(`/api/post/destroy/${id}`, {
    onSuccess: () => {
      emit('refetchData')
    },
    preserveScroll: true,
  })
}

const likePost = (id: string) => {
  form.post(`/api/like/${id}`, {
    onSuccess: () => {
      emit('refetchData')
    },
    preserveScroll: true,
  })
}
</script>
