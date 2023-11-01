<template>
  <Head title="Pelerbook"></Head>
  <div class="bg-[#242526] h-32 p-4 rounded-lg mt-6 max-w-lg mx-auto">
    <div class="flex gap-4 border-b pb-4 border-[#3a3b3c]">
      <Link class="aspect-square h-12" :href="'/' + auth.user.id">
        <img
          :src="auth.user.avatar"
          class="rounded-full object-cover w-12 h-12"
        />
      </Link>
      <button
        @click="showCreatePost"
        class="bg-[#3a3b3c] hover:bg-[#4e4f50] w-full rounded-full px-6 py-3 text-start"
        v-html="`What's on your mind, ` + auth.user.firstname + `?`"
      />
    </div>
  </div>
  <div
    class="fixed top-0 w-screen h-screen flex justify-center items-center bg-black/50 z-50"
    v-if="createPost"
    id="createpostpopup"
  >
    <CreatePost :firstname="auth.user.firstname" @close="showCreatePost" />
  </div>
  <div
    v-for="post in posts.data"
    class="card max-w-lg bg-[#242526] shadow-xl mx-auto mt-4"
    :key="posts.data.id"
  >
    <Post :post="post" :auth="auth" />
  </div>
  <div ref="target" class="-translate-y-64" />
</template>
<script setup>
import { ref } from "vue";
import CreatePost from "../Shared/CreatePost.vue";
import Post from "../Shared/Post.vue";
import { useIntersectionObserver } from "@vueuse/core";
import axios from "axios";

const { posts, auth } = defineProps({
  posts: Object,
  auth: Object,
});

const target = ref(null);
const { stop } = useIntersectionObserver(target, ([{ isIntersecting }]) => {
  if (!isIntersecting) {
    return;
  }
  axios
    .get(`${posts.meta.path}?cursor=${posts.meta.next_cursor}`)
    .then((response) => {
      console.log(response);
      posts.data = [...posts.data, ...response.data.data];
      posts.meta = response.data.meta;

      if (!response.data.meta.next_cursor) {
        stop();
      }
    });
});

const createPost = ref(false);

const handleClickCreate = (e) => {
  const createpostpopup = document.getElementById("createpostpopup");
  if (e.target == createpostpopup) {
    return showCreatePost();
  }
};

const showCreatePost = () => {
  createPost.value = !createPost.value;
  if (createPost.value) {
    document.addEventListener("click", handleClickCreate);
    return document.body.classList.add("overflow-hidden");
  }
  document.removeEventListener("click", handleClickCreate);
  document.body.classList.remove("overflow-hidden");
};
</script>
