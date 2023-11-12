<template>
  <div class="w-96 bg-neutral h-fit rounded-lg border border-accent">
    <form @submit.prevent="() => submit(post.id)">
      <div class="border-b py-6 border-accent flex justify-end">
        <p class="font-bold text-2xl w-full text-center">Edit post</p>
        <div
          @click="$emit('closeEdit')"
          class="absolute btn btn-circle btn-accent btn-sm w-fit mr-4 cursor-pointer float-right h-fit"
        >
          <span class="material-symbols-outlined p-2 select-none">close</span>
        </div>
      </div>
      <div class="card-body p-4">
        <div class="max-h-96 overflow-y-scroll">
          <textarea
            name="caption"
            :placeholder="revertFormatting(post.caption)"
            v-model="form.caption"
            autofocus
            class="bg-transparent outline-none resize-none w-full overflow-hidden"
            @input="handleTextArea"
          >
          </textarea>
          <div
            class="tooltip tooltip-error absolute left-1/2"
            :class="captionError ? 'tooltip-open' : ''"
            v-bind:data-tip="form.errors.caption"
          />
          <div class="relative w-fit mx-auto mt-2" v-if="form.image">
            <div
              class="btn btn-accent btn-circle absolute right-0 m-1 btn-sm"
              @click="form.image = ''"
            >
              <span class="material-symbols-outlined">close</span>
            </div>
            <img :src="imagePreview" class="rounded-md" />
          </div>
          <div class="flex">
            <div
              class="btn btn-ghost btn-circle btn-md"
              @click="openFileInput"
              v-if="!form.image"
            >
              <span class="material-symbols-outlined">add_photo_alternate</span>
            </div>
            <div
              class="tooltip tooltip-error tooltip-right"
              :class="imageError ? 'tooltip-open' : ''"
              data-tip="Invalid file
          format."
            />
          </div>
          <input
            type="file"
            name="image"
            accept=".jpg, .jpeg, .png, .webp"
            @change="handleImagePreview"
            @input="form.image = $event.target.files[0]"
            ref="fileInputRef"
            class="hidden"
          />
        </div>
        <div class="card-actions justify-center flex-col items-center">
          <button
            class="btn btn-primary normal-case w-full mt-2"
            :disabled="form.processing"
          >
            Post
          </button>
        </div>
      </div>
    </form>
  </div>
</template>
<script setup lang="ts">
import type { PostType } from "@/PostType";
import { useForm } from "@inertiajs/vue3";
import { ref, onMounted } from "vue";

// create a JavaScript function that removes HTML tags and reverts the formatting back to the original format
const revertFormatting = (htmlString: string) => {
  // Decode HTML entities
  let decodedString = document.createElement("textarea");
  decodedString.innerHTML = htmlString;
  let plainText = decodedString.value;

  // Revert formatting
  let revertedString: string = plainText.replace(/<b>(.*?)<\/b>/g, "*$1*");
  revertedString = revertedString.replace(/<i>(.*?)<\/i>/g, "_$1_");
  revertedString = revertedString.replace(/<strike>(.*?)<\/strike>/g, "~$1~");
  revertedString = revertedString.replace(/<code>(.*?)<\/code>/g, "```$1```");
  revertedString = revertedString.replace(
    /<a class="text-primary hover:underline" href="(.*?)" target="_blank">(.*?)<\/a>/g,
    "$1"
  );
  revertedString = revertedString.replace(/&#x(.*?);/g, function (match, p1) {
    return `\\u${p1}`;
  });
  // revertedString = revertedString.replace(/<\/?[^>]+(>|$)/g, "");
  revertedString = revertedString.replace(/<br \/>/g, "");
  return revertedString;
};

const { post } = defineProps<{
  post: PostType;
}>();

const form = useForm<any>({
  caption: revertFormatting(post.caption),
  image: post.image,
});

const handleTextArea = () => {
  captionError.value = false;
  const textarea = document.querySelector("textarea");
  if (textarea) {
    textarea.style.height = "full";
    textarea.style.height = `${textarea.scrollHeight}px`;
  }
};

const captionError = ref(false);

const submit = (id: string) => {
  imageError.value = false;
  form.post(`/api/post/update/${id}`, {
    onSuccess: () => {
      emit("closeEdit");
    },
    onError: () => {
      captionError.value = true;
    },
    preserveScroll: true,
  });
};

const emit = defineEmits(["closeEdit"]);

const fileInputRef = ref(null);

const openFileInput = () => {
  fileInputRef.value.click();
};

const imagePreview = ref<any>(post.image);
const imageError = ref(false);

const handleImagePreview = (event) => {
  const inputElement = event.target;
  const file = inputElement.files[0];

  if (file && isValidImageFile(file)) {
    const reader = new FileReader();

    reader.onload = () => {
      imagePreview.value = reader.result;
    };

    imageError.value = false;
    reader.readAsDataURL(file);
  } else {
    form.image = "";
    imageError.value = true;
  }
};

const isValidImageFile = (file) => {
  const allowedExtensions = [".jpg", ".jpeg", ".png", ".webp"];
  const fileExtension = file.name
    .toLowerCase()
    .substring(file.name.lastIndexOf("."));

  return allowedExtensions.includes(fileExtension);
};

onMounted(() => {
  handleTextArea();
});
</script>
