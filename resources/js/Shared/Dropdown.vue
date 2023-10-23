<template>
  <div class="bg-[#232425] rounded-xl p-2 shadow-lg">
    <ul>
      <li class="w-96">
        <DropdownLink
          :href="'/' + auth.user.id"
          as="button"
          icon="person"
          :label="auth.user.firstname + ' ' + auth.user.surname"
        />
      </li>
      <li class="w-96">
        <DropdownLink
          href="/help"
          as="button"
          icon="settings"
          label="Settings"
        />
      </li>
      <li class="w-96">
        <DropdownLink
          href="/logout"
          as="button"
          method="post"
          icon="logout"
          label="Log out"
        />
      </li>
    </ul>
  </div>
</template>
<script setup>
import DropdownLink from "../Components/DropdownLink.vue";

defineProps({
  auth: Object
})
</script>
