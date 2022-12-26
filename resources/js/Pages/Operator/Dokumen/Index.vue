<script setup>
import AppLayout from "../../../Layouts/AppLayout.vue";
import { onMounted, ref, watch } from "vue";
import InputLabel from "../../../Components/InputLabel.vue";
import SelectMenu from "../../../Components/SelectMenu.vue";
import { Inertia } from "@inertiajs/inertia";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import "dayjs/locale/id";

dayjs.extend(relativeTime);

const props = defineProps(["majors", "standards", "subs", "contents"]);

const selectedMajor = ref("");
const selectedStandard = ref("");
const selectedSub = ref("");

onMounted(() => {
  selectedMajor.value = props.majors[0].id;
  selectedStandard.value = props.standards[0].id;
});

watch(
  () => selectedMajor.value,
  (newValue, oldValue) => {
    Inertia.get(
      route("operator.contents.index", {
        selectedMajor: newValue,
        selectedStandard: selectedStandard.value,
        selectedSub: selectedSub.value,
      }),
      {},
      { preserveState: true }
    );
    selectedSub.value = "";
  }
);

watch(
  () => selectedStandard.value,
  (newValue, oldValue) => {
    Inertia.get(
      route("operator.contents.index", {
        selectedMajor: selectedMajor.value,
        selectedStandard: newValue,
        selectedSub: selectedSub.value,
      }),
      {},
      { preserveState: true }
    );
    selectedSub.value = "";
  }
);

watch(
  () => selectedSub.value,
  (newValue, oldValue) => {
    Inertia.get(
      route("operator.contents.index", {
        selectedMajor: selectedMajor.value,
        selectedStandard: selectedStandard.value,
        selectedSub: newValue,
      }),
      {},
      { preserveState: true }
    );
  }
);
</script>

<template>
  <AppLayout title="Dokumen">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Dokumen</h2>
    </template>

    <div class="overflow-hidden rounded-lg bg-white shadow">
      <div class="px-4 py-4 sm:p-6">
        <!-- Content goes here -->
        <div class="grid grid-cols-6 gap-5">
          <div class="col-span-6 sm:col-span-3">
            <InputLabel for="major_id" value="Program Studi" />
            <SelectMenu
              id="major_id"
              v-model="selectedMajor"
              :data-option="majors"
              name="major_id"
            />
          </div>
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
            <InputLabel for="major_id" value="Sub" />
            <SelectMenu
              id="standard_id"
              v-model="selectedSub"
              :data-option="subs"
              name="standard_id"
            />
          </div>
        </div>
      </div>
      <div class="p-5">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Dokumen</h1>
            <p class="mt-2 text-sm text-gray-700">
              Seluruh dokumen yang telah diupload dari berbagai program studi.
            </p>
          </div>
          <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <Link
              :href="route('operator.contents.create')"
              class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
              type="button"
            >
              Tambahkan Dokumen
            </Link>
          </div>
        </div>
        <div class="mt-8 flex flex-col">
          <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div
              class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
            >
              <div
                class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
              >
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      <th
                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                        scope="col"
                      >
                        Butir
                      </th>
                      <th
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        scope="col"
                      >
                        Judul
                      </th>
                      <th
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        scope="col"
                      >
                        Status Dokumen
                      </th>
                      <th
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        scope="col"
                      >
                        Nilai Dokumen
                      </th>
                      <th
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        scope="col"
                      >
                        Diupload Oleh
                      </th>
                      <th
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        scope="col"
                      >
                        Terakhir Update
                      </th>
                      <th class="relative py-3.5 pl-3 pr-4 sm:pr-6" scope="col">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="content in contents" :key="content.id">
                      <td
                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                      >
                        {{ content.number }}
                      </td>
                      <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                      >
                        {{ content.title }}
                      </td>
                      <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                      >
                        <span
                          v-if="!content.approved"
                          class="inline-flex items-center rounded-md bg-indigo-100 px-2 py-0.5 text-sm font-medium text-indigo-800"
                        >
                          <svg
                            class="mr-1.5 h-2 w-2 animate-ping text-indigo-400"
                            fill="currentColor"
                            viewBox="0 0 8 8"
                          >
                            <circle cx="4" cy="4" r="3" />
                          </svg>
                          Proses Verifikasi
                        </span>
                        <span
                          v-if="content.approved && content.graded === false"
                          class="inline-flex items-center rounded-md bg-green-100 px-2 py-0.5 text-sm font-medium text-green-800"
                        >
                          <svg
                            class="mr-1.5 h-2 w-2 animate-ping text-green-400"
                            fill="currentColor"
                            viewBox="0 0 8 8"
                          >
                            <circle cx="4" cy="4" r="3" />
                          </svg>
                          Proses Penilaian
                        </span>
                        <span
                          v-if="content.approved && content.graded"
                          class="inline-flex items-center rounded-md bg-green-100 px-2 py-0.5 text-sm font-medium text-green-800"
                        >
                          <svg
                            class="mr-1.5 h-2 w-2 text-green-400"
                            fill="currentColor"
                            viewBox="0 0 8 8"
                          >
                            <circle cx="4" cy="4" r="3" />
                          </svg>
                          Terverifikasi & Ternilai
                        </span>
                      </td>
                      <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                      >
                        {{ content.grade }}
                      </td>
                      <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                      >
                        {{ content.author }}
                      </td>
                      <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                      >
                        {{ dayjs(content.updated_at).locale("id").fromNow() }}
                      </td>
                      <td
                        class="relative space-x-2 whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                      >
                        <Link
                          v-if="
                            content.user_id ===
                              usePage().props.value.auth.user.id ||
                            usePage().props.value.level >= 2
                          "
                          :href="route('contents.destroy', content.id)"
                          as="button"
                          class="font-medium text-red-600 hover:text-red-500 hover:underline"
                          method="DELETE"
                        >
                          Delete
                        </Link>
                        <Link
                          v-if="
                            usePage().props.value.level >= 2 &&
                            content.approved !== true
                          "
                          :href="route('operator.contents.approve', content.id)"
                          class="font-medium text-green-600 hover:text-green-500 hover:underline"
                          method="PATCH"
                        >
                          Approve
                        </Link>
                        <a
                          :href="route('download.content', content.id)"
                          class="font-medium text-blue-600 hover:text-blue-500 hover:underline"
                        >
                          Download
                        </a>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
