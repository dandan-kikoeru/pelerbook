<template>
  <div class="navbar bg-[#242526] border-b border-[#38393a] fixed">
    <div class="flex-1">
      <Link href="/" class="btn btn-ghost normal-case text-xl">pelerbook</Link>
    </div>
    <div class="flex-none gap-2">
      <label class="btn btn-ghost btn-circle avatar" @click="toggleDropdown">
        <div class="w-10 rounded-full">
          <img src="guest.png" />
        </div>
      </label>
    </div>
    <Dropdown
      class="fixed right-2 top-20"
      v-show="showDropdown"
      id="dropdown"
    />
  </div>
</template>

<script setup>
import { ref } from "vue";
import Dropdown from "./Dropdown.vue";

const showDropdown = ref(false);

const handleClick = () => {
  toggleDropdown();
};

const toggleDropdown = () => {
  showDropdown.value = !showDropdown.value;
  if (!showDropdown.value) {
    return document.removeEventListener("click", handleClick);
  }
  setTimeout(() => {
    document.addEventListener("click", handleClick);
  }, 100);
};
</script>
