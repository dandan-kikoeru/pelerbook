<template>
  <div class="card-body p-4">
    <div class="flex gap-2">
      <Link :href="'/' + userId">
        <img src="guest.png" class="w-12 h-12 rounded-full cursor-pointer" />
      </Link>
      <div>
        <Link
          :href="'/' + userId"
          class="w-fit text-lg font-semibold hover:underline"
        >
          {{ firstname }} {{ surname }} </Link
        ><br />
        <Link :href="'/posts/' + id" class="hover:underline text-sm">
          {{ createdAt }}
        </Link>
      </div>
    </div>
    <div
      v-if="userId == authId"
      @click="togglePopup"
      class="absolute right-4 hover:bg-[#3a3b3c] rounded-full cursor-pointer"
    >
      <span class="material-symbols-outlined p-2 select-none">
        more_horiz
      </span>
    </div>
    <p>{{ caption }}</p>
  </div>

  <div
    v-if="showPopup"
    id="popup"
    class="absolute top-16 right-8 bg-[#242526] shadow-[0px_0px_15px_15px_rgba(0,0,0,0.1)] p-2 rounded-2xl z-20"
  >
    <Link
      class="text-start hover:bg-[#3a3b3c] p-2 rounded-md w-80 flex"
      href=""
      as="button"
    >
      <span class="material-symbols-outlined align-middle">edit</span>
      <span class="align-text-top ml-2">Edit post</span>
    </Link>
    <Link
      class="text-start hover:bg-[#3a3b3c] p-2 rounded-md w-80 flex"
      method="post"
      :href="'/delete/'+id"
      as="button"
    >
      <span class="material-symbols-outlined align-middle">delete</span>
      <span class="align-text-top ml-2">Delete post</span>
    </Link>
  </div>
</template>
<script setup>
import { ref } from "vue";
defineProps({
  firstname: String,
  surname: String,
  caption: String,
  createdAt: String,
  id: Number,
  userId: Number,
  authId: Number
});

const test = ref(false);

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
</script>
