<template>
  <div class="bg-neutral rounded-xl p-2 shadow-lg">
    <ul>
      <li class="w-96">
        <DropdownLink
          :href="'/' + auth.user.id"
          as="button"
          icon="person"
          :label="auth.user.firstname + ' ' + auth.user.surname"
          :class="{ 'bg-accent': $page.url.startsWith(`/${auth.user.id}`) }"
        />
      </li>
      <li class="w-96">
        <DropdownLink
          href="/settings"
          as="button"
          icon="settings"
          label="Settings"
          :class="{ 'bg-accent': $page.component === 'Settings' }"
        />
      </li>
      <li class="w-96">
        <DropdownLink
          href="/api/user/logout"
          as="button"
          method="post"
          icon="logout"
          label="Log out"
        />
      </li>
    </ul>
  </div>
</template>
<script setup lang="ts">
import type { AuthType } from '@/AuthType'
import DropdownLink from '../Components/DropdownLink.vue'
import { useEventListener } from '@vueuse/core'

defineProps<{
  auth: AuthType
}>()
const emit = defineEmits()

useEventListener(document, 'keydown', (e) => {
  if (e.key === 'Escape') {
    emit('close')
  }
})
</script>
