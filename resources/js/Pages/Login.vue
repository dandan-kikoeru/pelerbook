<template>
  <Head title="Log in or sign up | Pelerbook"></Head>
  <div class="flex justify-center items-center min-h-screen flex-col">
    <div class="text-center mb-16">
      <img :src="'/title.webp'" class="max-w-xs" />
      <p class="max-w-xs mt-8 text-lg">
        Pelerbook helps you connect your peler and share it with other people's
        peler.
      </p>
    </div>
    <form @submit.prevent="submit">
      <div class="card w-96 bg-neutral shadow-xl">
        <div class="card-body gap-4">
          <component
            :is="form.errors.email ? 'div' : 'div'"
            :class="
              form.errors.email ? 'tooltip tooltip-open tooltip-error' : ''
            "
            v-bind:data-tip="form.errors.email"
          ></component>
          <input
            type="text"
            placeholder="Email address"
            class="input w-full bg-base-100 max-w-xs"
            v-model="form.email"
          />
          <component
            :is="form.errors.password ? 'div' : 'div'"
            :class="
              form.errors.password ? 'tooltip tooltip-open tooltip-error' : ''
            "
            v-bind:data-tip="form.errors.password"
          ></component>
          <input
            type="password"
            placeholder="Password"
            class="input bg-base-100 w-full max-w-xs"
            v-model="form.password"
          />
          <div
            class="card-actions justify-center border-b-2 border-accent pb-4 flex-col items-center"
          >
            <button
              class="btn btn-primary normal-case w-full mt-2"
              :disabled="form.processing"
            >
              Log in
            </button>
            <Link href="/recover" class="hover:underline text-primary text-sm"
              >Forgotten password?</Link
            >
          </div>
          <div
            @click="toggleRegister"
            class="btn btn-secondary normal-case w-2/3 mx-auto mt-2"
          >
            Create new account
          </div>
        </div>
      </div>
    </form>
  </div>

  <div
    class="fixed top-0 w-screen h-screen bg-black/50 flex justify-center items-center z-50"
    v-if="showRegister"
    id="register"
  >
    <Register @close="toggleRegister" />
  </div>
  <div class="toast toast-end" v-if="form.errors.messages">
    <Toast @close="form.errors.messages = null">
      {{ form.errors.messages }}
    </Toast>
  </div>
</template>
<script setup lang="ts">
import { useForm } from "@inertiajs/vue3";
import Register from "../Shared/Register.vue";
import { ref } from "vue";
import Toast from "../Components/Toast.vue";

defineOptions({
  layout: null,
});

const form = useForm<any>({
  email: "",
  password: "",
});

const submit = () => {
  form.post("/api/user/login");
};

const showRegister = ref(false);

const handleClick = (e: Event) => {
  const register = document.getElementById("register");
  if (e.target == register) {
    return toggleRegister();
  }
};

const toggleRegister = () => {
  showRegister.value = !showRegister.value;
  if (!showRegister.value) {
    return document.removeEventListener("click", handleClick);
  }
  setTimeout(() => {
    document.addEventListener("click", handleClick);
  }, 100);
};
</script>
