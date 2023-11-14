<template>
  <div class="card w-[28rem] bg-neutral shadow-xl">
    <form @submit.prevent="submit">
      <div class="border-b py-6 border-accent flex justify-between">
        <div class="px-6">
          <p class="font-bold text-2xl">Sign up</p>
          <p>It's quick and easy.</p>
        </div>
        <div
          @click="$emit('close')"
          class="btn btn-circle btn-accent btn-sm w-fit mr-4 cursor-pointer float-right h-fit"
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
              class="input w-full max-w-xs bg-base-100"
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
              class="input w-full max-w-xs bg-base-100"
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
          class="input w-full bg-base-100"
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
          class="input w-full bg-base-100"
        />
        <p class="text-xs">
          People who use our service may have uploaded your contact information
          to Pelerbook.
          <Link href="/help" class="text-primary hover:underline"
            >Learn more.</Link
          >
        </p>
        <p class="text-xs">
          By clicking Sign Up, you agree to our
          <Link href="/about/terms" class="text-primary hover:underline"
            >Terms</Link
          >,
          <Link href="/about/privacy" class="text-primary hover:underline"
            >Privacy Policy</Link
          >
          and
          <Link href="/about/cookies" class="text-primary hover:underline"
            >Cookies Policy</Link
          >. You may receive SMS notifications from us and can opt out at any
          time.
        </p>
        <button
          href="/register"
          class="btn btn-secondary normal-case w-2/3 mx-auto mt-2"
          :disabled="form.processing"
        >
          Sign up
        </button>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
const form = useForm<any>({
  firstname: '',
  surname: '',
  email: '',
  password: '',
})

const submit = () => {
  form.post('/api/user/register')
}

defineEmits(['close'])
</script>
