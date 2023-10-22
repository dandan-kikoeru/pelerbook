<template>
  <Head title=" – Log in"></Head>
  <div class="flex justify-center items-center min-h-screen flex-col">
    <div class="text-center mb-16">
      <h1 class="text-6xl text-blue-500 font-semibold">pelerbook</h1>
      <p class="max-w-xs mt-8 text-lg">
        Pelerbook helps you connect your peler and share it with other people's
        peler.
      </p>
    </div>
    <form @submit.prevent="submit">
      <div class="card w-96 bg-base-100 shadow-xl">
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
            class="input input-bordered w-full max-w-xs"
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
            class="input input-bordered w-full max-w-xs"
            v-model="form.password"
          />
          <div
            class="card-actions justify-center border-b-2 pb-4 flex-col items-center"
          >
            <button
              class="btn btn-info normal-case w-full mt-2"
              :disabled="form.processing"
            >
              Log in
            </button>
            <Link href="/recover" class="hover:underline text-info text-sm"
              >Forgotten password?</Link
            >
          </div>
          <Link
            href="/register"
            class="btn btn-success normal-case w-2/3 mx-auto mt-2"
          >
            Create new account
          </Link>
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
  email: "",
  password: "",
});

const submit = () => {
  form.post("/login");
};
</script>
