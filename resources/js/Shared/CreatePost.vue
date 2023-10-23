<template>
  <div class="w-96 bg-[#242526] h-fit rounded-lg border border-[#2f3031]">
    <form @submit.prevent="submit">
      <div class="border-b py-6 border-[#2f3031] flex justify-end">
        <p class="font-bold text-2xl w-full text-center">Create post</p>
        <div
          @click="$emit('close')"
          class="absolute bg-[#3a3b3c] mr-4 rounded-full hover:bg-[#4e4f50] cursor-pointer"
        >
          <span class="material-symbols-outlined p-2 select-none">close</span>
        </div>
      </div>
      <div class="card-body gap-4 p-4">
        <component
          :is="form.errors.caption ? 'div' : 'div'"
          :class="
            form.errors.caption ? 'tooltip tooltip-open tooltip-error' : ''
          "
          v-bind:data-tip="form.errors.caption"
        ></component>
        <textarea
          name="caption"
          :placeholder="`What's on your mind, ` + firstname + `?`"
          v-model="form.caption"
          autofocus
          class="bg-transparent outline-none resize-none h-80"
        >
        </textarea>
        <div class="card-actions justify-center flex-col items-center">
          <button
            class="btn btn-info normal-case w-full mt-2"
            :disabled="form.processing"
          >
            Post
          </button>
        </div>
      </div>
    </form>
  </div>
  <p v-if="form.errors.messages">
    {{ form.errors.messages }}
  </p>
</template>
<script>
export default {
  layout: null,
};
</script>
<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  caption: "",
});

const submit = () => {
  form.post("/store");
};

defineProps({
  firstname: String,
});
defineEmits(["close"]);
</script>
