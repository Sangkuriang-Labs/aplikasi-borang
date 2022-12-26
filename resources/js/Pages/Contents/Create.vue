<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import InputLabel from "../../Components/InputLabel.vue";
import SelectMenu from "../../Components/SelectMenu.vue";
import { useForm, usePage } from "@inertiajs/inertia-vue3";
import { onMounted, ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import TextInput from "../../Components/TextInput.vue";
import PrimaryButton from "../../Components/PrimaryButton.vue";
import InputError from "../../Components/InputError.vue";

const props = defineProps(["standards", "subs", "majors"]);

const selectedStandard = ref("");

const form = useForm({
  user_id: usePage().props.value.auth.user.id,
  sub_id: "",
  major_id: usePage().props.value.auth.user.major_id,
  file: "",
});

onMounted(() => {
  selectedStandard.value = props.standards[0].id;
});

watch(
  () => selectedStandard.value,
  (newValue, oldValue) => {
    Inertia.get(
      route("contents.create", { standardId: newValue }),
      {},
      { preserveState: true }
    );
  }
);
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Tambah Dokumen
      </h2>
    </template>

    <div class="overflow-hidden rounded-lg bg-white p-5 shadow">
      <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
          <div class="px-4 sm:px-0">
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Tambahkan Dokumen Baru
            </h3>
            <p class="mt-1 text-sm text-gray-600">
              Upload dokumen ke dalam sistem
            </p>
          </div>
        </div>
        <div class="mt-5 md:col-span-2 md:mt-0">
          <form
            method="POST"
            @submit.prevent="form.post(route('contents.store'))"
          >
            <div class="overflow-hidden shadow sm:rounded-md">
              <div class="bg-white px-4 py-5 sm:p-6">
                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-6 sm:col-span-3">
                    <InputLabel for="standard_id" value="Standar" />
                    <SelectMenu
                      id="standard_id"
                      v-model="selectedStandard"
                      :data-option="standards"
                      name="standard_id"
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

                  <div
                    v-if="usePage().props.value.level >= 3"
                    class="col-span-6 sm:col-span-3"
                  >
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
                    <InputLabel for="name" value="Diupload Oleh" />
                    <TextInput
                      id="name"
                      :model-value="$page.props.auth.user.name"
                      class="mt-1 opacity-30"
                      disabled
                      name="name"
                      type="text"
                    />
                    <InputError
                      v-if="form.errors.user_id"
                      :message="form.errors.user_id"
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
                    <InputError
                      v-if="form.errors.file"
                      :message="form.errors.file"
                    />
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                <PrimaryButton type="submit">Save</PrimaryButton>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
