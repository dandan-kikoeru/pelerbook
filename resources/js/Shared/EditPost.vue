<template>
  <div class="w-96 bg-[#242526] h-fit rounded-lg border border-[#2f3031]">
    <form @submit.prevent="() => submit(post.id)">
      <div class="border-b py-6 border-[#2f3031] flex justify-end">
        <p class="font-bold text-2xl w-full text-center">Edit post</p>
        <div
          @click="$emit('closeEdit')"
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
          :placeholder="revertFormatting(post.caption)"
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
<script setup lang="ts">
import type { PostType } from "@/PostType";
import { useForm } from "@inertiajs/vue3";

const { post } = defineProps<{
  post: PostType;
}>();

// create a JavaScript function that removes HTML tags and reverts the formatting back to the original format
const revertFormatting = (htmlString: string) => {
  let revertedString: string = htmlString.replace(/<b>(.*?)<\/b>/g, "*$1*");
  revertedString = revertedString.replace(/<i>(.*?)<\/i>/g, "_$1_");
  revertedString = revertedString.replace(/<strike>(.*?)<\/strike>/g, "~$1~");
  revertedString = revertedString.replace(/<code>(.*?)<\/code>/g, "```$1```");
  revertedString = revertedString.replace(
    /<a class="text-blue-500 hover:underline" href="(.*?)" target="_blank">(.*?)<\/a>/g,
    "$1"
  );
  revertedString = revertedString.replace(/&#x(.*?);/g, function (match, p1) {
    return `\\u${p1}`;
  });
  revertedString = revertedString.replace(/<\/?[^>]+(>|$)/g, "");
  return revertedString;
};

const form = useForm<any>({
  caption: revertFormatting(post.caption),
});

const submit = (id: string) => {
  form.post(`/api/post/update/${id}`);
};

defineEmits(["closeEdit"]);
</script>
