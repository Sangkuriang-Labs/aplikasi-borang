<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import SelectMenu from "../../Components/SelectMenu.vue";
import { ref, watch } from "vue";

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  position_id: "",
  major_id: "",
  terms: false,
});

const props = defineProps(["positions", "majors"]);

const selectedDekan = ref(false);

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};

watch(
  () => form.position_id,
  (newValue, oldValue) => {
    form.reset("major_id");
    const [dekan] = props.positions.filter(
      (position) => position.value === "Dekan"
    );
    if (newValue == dekan.id) {
      selectedDekan.value = true;
    } else {
      selectedDekan.value = false;
    }
  }
);
</script>

<template>
  <Head title="Register" />

  <AuthenticationCard>
    <template #logo>
      <AuthenticationCardLogo />
    </template>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="name" value="Nama" />
        <TextInput
          id="name"
          v-model="form.name"
          type="text"
          class="mt-1 block w-full"
          required
          autofocus
          autocomplete="name"
        />
        <InputError :message="form.errors.name" class="mt-2" />
      </div>

      <div class="mt-4">
        <InputLabel for="email" value="Email" />
        <TextInput
          id="email"
          v-model="form.email"
          type="email"
          class="mt-1 block w-full"
          required
        />
        <InputError :message="form.errors.email" class="mt-2" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" />
        <TextInput
          id="password"
          v-model="form.password"
          type="password"
          class="mt-1 block w-full"
          required
          autocomplete="new-password"
        />
        <InputError :message="form.errors.password" class="mt-2" />
      </div>

      <div class="mt-4">
        <InputLabel for="password_confirmation" value="Konfirmasi Password" />
        <TextInput
          id="password_confirmation"
          v-model="form.password_confirmation"
          type="password"
          class="mt-1 block w-full"
          required
          autocomplete="new-password"
        />
        <InputError :message="form.errors.password_confirmation" class="mt-2" />
      </div>

      <div class="mt-4">
        <InputLabel for="position_id" value="Jabatan" />
        <SelectMenu v-model="form.position_id" :data-option="positions" />
        <InputError :message="form.errors.position_id" class="mt-2" />
      </div>

      <div class="mt-4">
        <InputLabel for="major_id" value="Program Studi" />
        <SelectMenu
          v-model="form.major_id"
          :data-option="majors"
          :disabled="selectedDekan"
        />
        <InputError :message="form.errors.major_id" class="mt-2" />
      </div>

      <div
        v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
        class="mt-4"
      >
        <InputLabel for="terms">
          <div class="flex items-center">
            <Checkbox
              id="terms"
              v-model:checked="form.terms"
              name="terms"
              required
            />

            <div class="ml-2">
              I agree to the
              <a
                :href="route('terms.show')"
                class="text-sm text-gray-600 underline hover:text-gray-900"
                target="_blank"
                >Terms of Service</a
              >
              and
              <a
                :href="route('policy.show')"
                class="text-sm text-gray-600 underline hover:text-gray-900"
                target="_blank"
                >Privacy Policy</a
              >
            </div>
          </div>
          <InputError :message="form.errors.terms" class="mt-2" />
        </InputLabel>
      </div>

      <div class="mt-4 flex items-center justify-end">
        <Link
          :href="route('login')"
          class="text-sm text-gray-600 underline hover:text-gray-900"
        >
          Already registered?
        </Link>

        <PrimaryButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
          class="ml-4"
        >
          Register
        </PrimaryButton>
      </div>
    </form>
  </AuthenticationCard>
</template>
