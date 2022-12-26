<template>
  <AppLayout title="Tambahkan Dokumen">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Tambahkan Dokumen
      </h2>
    </template>
    <form @submit.prevent="form.post(route('operator.contents.store'))">
      <div
        class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow"
      >
        <div class="px-4 py-5 sm:px-6">
          <!-- Content goes here -->
          <!-- We use less vertical padding on card headers on desktop than on body sections -->
          <div class="grid grid-cols-6 gap-5">
            <div class="col-span-6 sm:col-span-3">
              <InputLabel for="major_id" value="Program Studi" />
              <SelectMenu
                id="major_id"
                v-model="form.major_id"
                :data-option="majors"
                name="major_id"
              />
              <InputError
                v-if="form.errors.major_id"
                :message="form.errors.major_id"
              />
            </div>
            <div class="col-span-6 sm:col-span-3">
              <InputLabel for="standard_id" value="Standar" />
              <SelectMenu
                id="standard_id"
                v-model="form.standar_id"
                :data-option="standards"
                name="standard_id"
              />
              <InputError
                v-if="form.errors.standar_id"
                :message="form.errors.standar_id"
              />
            </div>
            <div class="col-span-6 sm:col-span-3">
              <InputLabel for="sub_id" value="Sub" />
              <SelectMenu
                id="sub_id"
                v-model="form.sub_id"
                :data-option="subs"
                name="sub_id"
              />
              <InputError
                v-if="form.errors.sub_id"
                :message="form.errors.sub_id"
              />
            </div>
            <div class="col-span-6 sm:col-span-3">
              <InputLabel for="file" value="Dokumen" />
              <TextInput
                id="file"
                class="py-2 shadow-none"
                name="file"
                type="file"
                @input="form.file = $event.target.files[0]"
              />
              <InputError v-if="form.errors.file" :message="form.errors.file" />
            </div>
          </div>
        </div>
        <div class="flex items-center justify-end px-4 py-5 sm:p-6">
          <PrimaryButton type="submit">Save</PrimaryButton>
        </div>
      </div>
    </form>
  </AppLayout>
</template>

<script setup>
import AppLayout from "../../../Layouts/AppLayout.vue";
import InputLabel from "../../../Components/InputLabel.vue";
import SelectMenu from "../../../Components/SelectMenu.vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import TextInput from "../../../Components/TextInput.vue";
import PrimaryButton from "../../../Components/PrimaryButton.vue";

defineProps(["majors", "standards", "subs"]);

const form = useForm({
  user_id: usePage().props.value.auth.user.id,
  major_id: "",
  standar_id: "",
  sub_id: "",
  file: "",
});

watch(
  () => form.major_id,
  (newValue, oldValue) => {
    Inertia.get(
      route("operator.contents.create", { majorId: newValue }),
      {},
      { preserveState: true }
    );
    form.standar_id = "";
  }
);

watch(
  () => form.standar_id,
  (newValue, oldValue) => {
    Inertia.get(
      route("operator.contents.create", {
        majorId: form.major_id,
        standardId: newValue,
      }),
      {},
      { preserveState: true }
    );
    form.sub_id = "";
  }
);
</script>
