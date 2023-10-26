<template>
  <div class="card-body p-4">
    <div class="flex gap-2">
      <Link :href="'/' + post.user.id">
        <img
          src="/avatars/guest.png"
          class="w-12 h-12 rounded-full cursor-pointer"
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
          {{ post.created_at_human }}
        </Link>
      </div>
    </div>
    <div
      v-if="post.user.id == auth.user.id"
      @click="togglePopup"
      class="absolute right-4 hover:bg-[#3a3b3c] rounded-full cursor-pointer"
    >
      <span class="material-symbols-outlined p-2 select-none">
        more_horiz
      </span>
    </div>
    <p v-html="post.caption" class="break-all"></p>
  </div>

  <div
    v-if="showPopup"
    id="popup"
    class="absolute top-16 right-8 bg-[#242526] shadow-[0px_0px_15px_15px_rgba(0,0,0,0.1)] p-2 rounded-2xl z-20"
  >
    <button
      @click="toggleEdit()"
      class="text-start hover:bg-[#3a3b3c] p-2 rounded-md w-80 flex"
    >
      <span class="material-symbols-outlined align-middle">edit</span>
      <span class="align-text-top ml-2">Edit post</span>
    </button>
    <Link
      class="text-start hover:bg-[#3a3b3c] p-2 rounded-md w-80 flex"
      method="post"
      :href="'/delete/' + post.id"
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
<script setup>
import { ref } from "vue";
import EditPost from "./EditPost.vue";

defineProps({
  post: Object,
  auth: Object,
});

const showPopup = ref(false);

const handleClick = (e) => {
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

const handleClickEdit = (e) => {
  const edit = document.getElementById("edit");
  if (e.target == edit) {
    return toggleEdit();
  }
};
const showEdit = ref(false);

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
