<template>
  <div class="navbar bg-neutral border-b border-accent z-30">
    <div class="flex-1">
      <Link href="/" class="rounded-full mx-2">
        <img :src="'/logo.webp'" class="h-12 aspect-square rounded-full" />
      </Link>
    </div>
    <div class="flex-none gap-2">
      <label class="btn btn-ghost btn-circle avatar" @click="toggleDropdown()">
        <div class="w-10 rounded-full">
          <img :src="auth.user.avatar" />
        </div>
      </label>
    </div>
    <Dropdown
      class="fixed right-2 top-20"
      v-if="showDropdown"
      :auth="auth"
      @close="toggleDropdown()"
      ref="dropdown"
    />
  </div>
</template>
<script setup lang="ts">
import { ref } from 'vue'
import Dropdown from './Dropdown.vue'
import type { AuthType } from '@/AuthType'
import { onClickOutside, useToggle } from '@vueuse/core'

defineProps<{
  auth: AuthType
}>()

const [showDropdown, toggleDropdown] = useToggle()
const dropdown = ref<HTMLElement | null>(null)
onClickOutside(dropdown, () => toggleDropdown())
</script>
