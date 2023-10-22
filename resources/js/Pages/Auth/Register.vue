<template>
  <!-- <Head title=" - Log in or sign up"></Head> -->
  <div class="flex justify-center items-center min-h-screen flex-col">
    <div class="text-center mb-16">
      <h1 class="text-6xl text-[#EDC9B9] font-semibold">pelerbook</h1>
      <p class="max-w-xs mt-8 text-lg">
        Pelerbook helps you connect your peler and share with other people's
        peler.
      </p>
    </div>
    <form @submit.prevent="submit">
      <div class="card w-[28rem] bg-base-100 shadow-xl">
        <div class="card-body gap-4">
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
                class="input input-bordered w-full max-w-xs"
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
                class="input input-bordered w-full max-w-xs"
              />
            </div>
          </div>

          <component
            :is="form.errors.email ? 'div' : 'div'"
            :class="
              form.errors.email ? 'tooltip tooltip-open tooltip-error' : ''
            "
            v-bind:data-tip="form.errors.email"
          ></component>
          <input
            v-model="form.email"
            name="email"
            type="text"
            placeholder="Email address"
            class="input input-bordered w-full"
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
            class="input input-bordered w-full"
          />
          <p class="text-xs">
            People who use our service may have uploaded your contact
            information to Pelerbook.
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
      </div>
    </form>
  </div>
</template>
<script>
export default {
  layout: null,
};
</script>
<script setup>
import { useForm } from "@inertiajs/vue3";
const form = useForm({
  firstname: "",
  surname: "",
  email: "",
  password: "",
});

const submit = () => {
  console.log("submit");
  form.post("/register");
};
</script>
