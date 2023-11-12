<template>
  <Head
    :title="profile.firstname + ' ' + profile.surname + ` | Pelerbook`"
  ></Head>
  <div class="bg-neutral">
    <div>
      <div
        v-if="profile.cover"
        class="relative aspect-[3/1] max-w-6xl mx-auto overflow-hidden rounded-b-xl"
      >
        <img class="object-cover w-full h-full" :src="profile.cover" />
      </div>
      <div
        v-else
        class="relative aspect-[3/1] max-w-6xl mx-auto overflow-hidden rounded-xl bg-black"
      ></div>
    </div>
  </div>
  <div
    class="flex flex-col items-center bg-neutral h-40 border-b border-accent relative"
  >
    <div class="absolute -top-16 flex flex-col items-center">
      <img
        class="h-32 rounded-full border-4 border-neutral"
        :src="profile.avatar"
      />
      <h1 class="text-2xl">{{ profile.firstname }} {{ profile.surname }}</h1>
      Joined {{ profile.createdAt }}
    </div>
  </div>
  <div
    class="bg-neutral h-32 p-4 rounded-2xl mt-4 max-w-lg mx-auto"
    v-if="auth.user.id == profile.id"
  >
    <div class="flex gap-4 border-b pb-4 border-accent">
      <Link class="aspect-square h-12" :href="'/' + auth.user.id">
        <img
          :src="auth.user.avatar"
          class="rounded-full object-cover w-12 h-12"
        />
      </Link>
      <button
        @click="showCreatePost"
        class="bg-accent w-full rounded-full px-6 py-3 text-start"
        v-html="`What's on your mind, ` + auth.user.firstname + `?`"
      />
    </div>
  </div>
  <div
    class="fixed top-0 w-screen h-screen flex justify-center items-center bg-black/50 z-50 rounded-xl"
    v-if="createPost"
    id="post"
  >
    <CreatePost :firstname="auth.user.firstname" @close="showCreatePost" />
  </div>

  <div
    v-for="post in posts.data"
    class="card max-w-lg bg-neutral mx-auto mt-4"
    :key="post.id"
  >
    <Post :post="post" :auth="auth" />
  </div>
</template>
<script setup lang="ts">
import { ref } from "vue";
import CreatePost from "../Shared/CreatePost.vue";
import Post from "../Shared/Post.vue";
import type { UserType } from "@/UserType";
import type { AuthType } from "@/AuthType";
import type { PostsType } from "@/PostsType";

const { posts, auth, profile } = defineProps<{
  posts: PostsType;
  auth: AuthType;
  profile: UserType;
}>();

const createPost = ref<boolean>(false);

const showCreatePost = () => {
  createPost.value = !createPost.value;
  if (createPost.value) {
    return document.body.classList.add("overflow-hidden");
  }
  document.body.classList.remove("overflow-hidden");
};
</script>
