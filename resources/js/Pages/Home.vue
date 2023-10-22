<template>
  <Head title=" - Home"></Head>
  <div class="bg-[#242526] h-32 p-4 rounded-lg mt-6 max-w-lg mx-auto">
    <div class="flex gap-4 border-b pb-4 border-[#3a3b3c]">
      <img src="guest.png" class="w-12 h-12 rounded-full" />
      <button
        @click="showCreatePost"
        class="bg-[#3a3b3c] hover:bg-[#4e4f50] w-full rounded-full px-6 py-3 text-start"
        v-html="`What's on your mind, ` + auths.firstname + `?`"
      ></button>
    </div>
  </div>
  <div
    class="fixed top-0 w-screen h-screen flex justify-center items-center bg-black/50"
    v-if="createPost"
  >
    <Create :firstname="auths.firstname" />
  </div>

  <div v-for="post in posts" class="border p-4">
    {{ post.user.firstname }}
    {{ post.user.surname }}<br><br>
    {{ post.caption }}
  </div>
</template>
<script setup>
import Create from "./Post/Create.vue";
import { ref } from "vue";

defineProps({
  users: Object,
  auths: Array,
  posts: Object,
});

// const test = ref("What's on your mind, {{ auths.firstname }}");

const createPost = ref(false);

const showCreatePost = () => {
  createPost.value = !createPost.value;
};
</script>
