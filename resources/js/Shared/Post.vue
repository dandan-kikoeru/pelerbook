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
    <div class="absolute right-4 hover:bg-[#3a3b3c] rounded-full cursor-pointer">
      <span
        class="material-symbols-outlined p-2 select-none"
      >
        more_horiz
      </span>
    </div>
    <p>{{ caption }}</p>
  </div>
</template>
<script setup>
defineProps({
  firstname: String,
  surname: String,
  caption: String,
  createdAt: String,
  id: Number,
  userId: Number,
});
</script>
