<template>
  <div class="navbar bg-[#242526] border-b border-[#38393a] z-30">
    <div class="flex-1">
      <Link href="/" class="rounded-full mx-2">
        <img :src="'/logo.webp'" class="h-12 aspect-square rounded-full" />
      </Link>
    </div>
    <div class="flex-none gap-2">
      <label class="btn btn-ghost btn-circle avatar" @click="toggleDropdown">
        <div class="w-10 rounded-full">
          <img :src="auth.user.avatar" />
        </div>
      </label>
    </div>
    <Dropdown
      class="fixed right-2 top-20"
      v-if="showDropdown"
      id="dropdown"
      :auth="auth"
    />
  </div>
</template>
<script setup lang="ts">
import { ref } from "vue";
import Dropdown from "./Dropdown.vue";
import { Link } from "@inertiajs/vue3";
import type { AuthType } from "@/AuthType";

defineProps<{
  auth: AuthType;
}>();

const showDropdown = ref(false);

const handleClick = (e: Event) => {
  const dropdown = document.getElementById("dropdown");
  if (e.target !== dropdown) {
    return toggleDropdown();
  }
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
