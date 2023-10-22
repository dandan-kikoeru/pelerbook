<template>
  <div class="bg-[#232425] rounded-xl p-2">
    <ul>
      <li class="w-96">
        <DropdownLink
          href="/help"
          as="button"
          icon="person"
          label="Profile"
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
</script>
