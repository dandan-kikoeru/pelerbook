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
      @click="togglePopup"
      class="absolute right-4 hover:bg-accent btn btn-ghost btn-circle"
    >
      <span class="material-symbols-outlined p-2 select-none">more_horiz</span>
    </div>
    <p v-html="post.caption" class="pb-2" />
    <img :src="post.image" />
    <p v-if="post.likes" class="flex gap-1">
      <span class="material-symbols-outlined text-primary"> thumb_up </span
      >{{ post.likes }}
    </p>
    <div class="border-accent border-y py-1">
      <Link
        as="button"
        method="post"
        :href="`/api/like/${post.id}`"
        :class="
          post.likedByUser
            ? 'btn btn-ghost btn-block text-primary normal-case'
            : 'btn btn-ghost btn-block active:text-primary normal-case'
        "
        preserve-scroll
      >
        <span class="material-symbols-outlined"> thumb_up </span>Like
      </Link>
    </div>
  </div>

  <div
    v-if="showPopup"
    id="popup"
    class="absolute top-16 right-8 bg-neutral shadow-[0px_0px_15px_15px_rgba(0,0,0,0.1)] p-2 rounded-2xl z-20"
  >
    <button
      @click="toggleEdit()"
      class="text-start hover:bg-accent p-2 rounded-md w-80 flex"
    >
      <span class="material-symbols-outlined align-middle">edit</span>
      <span class="align-text-top ml-2">Edit post</span>
    </button>
    <Link
      class="text-start hover:bg-accent p-2 rounded-md w-80 flex"
      method="post"
      :href="'/api/post/destroy/' + post.id"
      as="button"
      preserve-scroll
    >
      <span class="material-symbols-outlined align-middle">delete</span>
      <span class="align-text-top ml-2">Delete post</span>
    </Link>
  </div>
  <div
    v-if="showEdit"
    class="fixed top-0 left-0 w-screen h-screen flex justify-center items-center bg-black/50 z-50"
    id="edit"
  >
    <EditPost :post="post" @close-edit="toggleEdit" />
  </div>
</template>
<script setup lang="ts">
import { ref } from "vue";
import EditPost from "./EditPost.vue";
import type { PostType } from "@/PostType";
import type { AuthType } from "@/AuthType";

const { post, auth } = defineProps<{
  post: PostType;
  auth: AuthType;
}>();

const showPopup = ref<boolean>(false);

const handleClick = (e: Event) => {
  const popup = document.getElementById("popup");
  if (e.target !== popup) {
    return togglePopup();
  }
};

const togglePopup = () => {
  showPopup.value = !showPopup.value;
  if (!showPopup.value) {
    return document.removeEventListener("click", handleClick);
  }
  setTimeout(() => {
    document.addEventListener("click", handleClick);
  }, 100);
};

const handleClickEdit = (e: Event) => {
  const edit = document.getElementById("edit");
  if (e.target == edit) {
    return toggleEdit();
  }
};
const showEdit = ref<boolean>(false);

const toggleEdit = () => {
  showEdit.value = !showEdit.value;
  if (showEdit.value) {
    document.addEventListener("click", handleClickEdit);
    return document.body.classList.add("overflow-hidden");
  }
  document.removeEventListener("click", handleClickEdit);
  document.body.classList.remove("overflow-hidden");
};
</script>
