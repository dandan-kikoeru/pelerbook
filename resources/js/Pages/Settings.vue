<template>
  <div class="h-screen">
    <Navbar :auth="auth.auth" class="z-50 fixed" />
    <div
      class="fixed left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2"
      :class="[form.avatar ? 'mt-8' : '']"
    >
      <div class="card w-[28rem] bg-[#242526] shadow-xl">
        <form @submit.prevent="submit">
          <div class="border-b py-6 border-[#2f3031] flex justify-between">
            <div class="px-6">
              <p class="font-bold text-2xl">Edit profile</p>
            </div>
          </div>
          <div class="card-body gap-4 pt-0">
            <div class="flex gap-4">
              <div class="flex flex-col gap-4">
                <component
                  :is="form.errors.firstname ? 'div' : 'div'"
                  :class="
                    form.errors.firstname
                      ? 'tooltip tooltip-open tooltip-error'
                      : ''
                  "
                  v-bind:data-tip="form.errors.firstname"
                ></component>
                <input
                  v-model="form.firstname"
                  name="firstname"
                  type="text"
                  placeholder="First name"
                  class="input w-full max-w-xs bg-[#18191a]"
                />
              </div>
              <div class="flex flex-col gap-4">
                <component
                  :is="form.errors.surname ? 'div' : 'div'"
                  :class="
                    form.errors.surname
                      ? 'tooltip tooltip-open tooltip-error'
                      : ''
                  "
                  v-bind:data-tip="form.errors.surname"
                ></component>
                <input
                  v-model="form.surname"
                  name="surname"
                  type="text"
                  placeholder="Surname"
                  class="input w-full max-w-xs bg-[#18191a]"
                />
              </div>
            </div>
            <div
              :class="[
                form.avatar
                  ? 'aspect-square flex bg-[#18191a] rounded-xl cursor-pointer'
                  : 'flex bg-[#18191a] rounded-lg',
              ]"
              v-if="!form.deleteAvatar"
            >
              <input
                type="file"
                class="opacity-0 w-full z-10 file:w-full file:cursor-pointer file:h-full file:min-h-16"
                accept=".jpg, .jpeg, .png, .webp, .gif"
                @change="handleFileUpload"
                @input="form.avatar = $event.target.files[0]"
                :disabled="form.deleteAvatar"
              />
              <div
                v-if="!form.avatar"
                class="absolute flex h-16 left-1/2 -translate-x-1/2 items-center"
              >
                Upload avatar
              </div>
              <img
                v-if="form.avatar"
                :src="form.avatarPreview"
                class="absolute aspect-square h-[24rem] w-[24rem] object-cover rounded-full p-4"
              />
            </div>
            <div class="flex">
              <label class="cursor-pointer label ml-2">
                <input
                  type="checkbox"
                  checked="checked"
                  class="checkbox checkbox-error"
                  v-model="form.deleteAvatar"
                />
                <span class="label-text ml-2">Delete avatar</span>
              </label>
            </div>
            <button
              href="/register"
              class="btn btn-success normal-case w-2/3 mx-auto mt-2"
              :disabled="form.processing"
            >
              Save
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  layout: null,
};
</script>
<script setup>
import { useForm } from "@inertiajs/vue3";
import Navbar from "../Shared/Navbar.vue";

const auth = defineProps({
  auth: Object,
});

const form = useForm({
  firstname: auth.auth.user.firstname,
  surname: auth.auth.user.surname,
  avatar: null,
  deleteAvatar: false,
});

const submit = () => {
  form.post("/settings");
};

const handleFileUpload = (event) => {
  const file = event.target.files[0];
  const reader = new FileReader();

  reader.onload = () => {
    form.avatarPreview = reader.result;
  };

  reader.readAsDataURL(file);
};
</script>
