<template>
  <div class="card w-[28rem] bg-[#242526] shadow-xl">
    <form @submit.prevent="submit">
      <div class="border-b py-6 border-[#2f3031] flex justify-between">
        <div class="px-6">
          <p class="font-bold text-2xl">Sign up</p>
          <p>It's quick and easy.</p>
        </div>
        <div
          @click="$emit('close')"
          class="bg-[#3a3b3c] mr-4 rounded-full hover:bg-[#4e4f50] cursor-pointer float-right h-fit"
        >
          <span class="material-symbols-outlined p-2 select-none">close</span>
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
                form.errors.surname ? 'tooltip tooltip-open tooltip-error' : ''
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

        <component
          :is="form.errors.email ? 'div' : 'div'"
          :class="form.errors.email ? 'tooltip tooltip-open tooltip-error' : ''"
          v-bind:data-tip="form.errors.email"
        ></component>
        <input
          v-model="form.email"
          name="email"
          type="text"
          placeholder="Email address"
          class="input w-full bg-[#18191a]"
        />
        <component
          :is="form.errors.password ? 'div' : 'div'"
          :class="
            form.errors.password ? 'tooltip tooltip-open tooltip-error' : ''
          "
          v-bind:data-tip="form.errors.password"
        ></component>
        <input
          v-model="form.password"
          name="password"
          type="password"
          placeholder="Password"
          class="input w-full bg-[#18191a]"
        />
        <p class="text-xs">
          People who use our service may have uploaded your contact information
          to Pelerbook.
          <Link href="/help" class="text-blue-400 hover:underline"
            >Learn more.</Link
          >
        </p>
        <p class="text-xs">
          By clicking Sign Up, you agree to our
          <Link href="/about/terms" class="text-blue-400 hover:underline"
            >Terms</Link
          >,
          <Link href="/about/privacy" class="text-blue-400 hover:underline"
            >Privacy Policy</Link
          >
          and
          <Link href="/about/cookies" class="text-blue-400 hover:underline"
            >Cookies Policy</Link
          >. You may receive SMS notifications from us and can opt out at any
          time.
        </p>
        <button
          href="/register"
          class="btn btn-success normal-case w-2/3 mx-auto mt-2"
          :disabled="form.processing"
        >
          Sign up
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
const form = useForm({
  firstname: "",
  surname: "",
  email: "",
  password: "",
});

const submit = () => {
  form.post("/api/user/register");
};

defineEmits(["close"]);
</script>
