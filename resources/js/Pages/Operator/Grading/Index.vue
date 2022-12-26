<template>
  <AppLayout title="Penilaian Dokumen">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Penilian Dokumen
      </h2>
    </template>
    <div>
      <div class="sm:flex sm:items-center">
        <div class="mt-4 sm:mt-0 sm:flex-none">
          <InputLabel for="major_id" value="Program Studi" />
          <SelectMenu
            id="major_id"
            v-model="selectedMajorId"
            :data-option="majors"
            name="major_id"
          />
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
                      Program Studi
                    </th>
                    <th
                      class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                      scope="col"
                    >
                      Upload Oleh
                    </th>
                    <th class="relative py-3.5 pl-3 pr-4 sm:pr-6" scope="col">
                      <span class="sr-only">Penilian</span>
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
                      {{ content.major_name }}
                    </td>
                    <td
                      class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                    >
                      {{ content.author }}
                    </td>
                    <td
                      class="relative space-x-3 whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                    >
                      <button
                        class="text-green-600 hover:text-green-900 hover:underline"
                        @click="
                          () => {
                            selectedContent = content.id;
                            open = !open;
                          }
                        "
                      >
                        Penilian<span class="sr-only"
                          >, {{ content.title }}</span
                        >
                      </button>
                      <a
                        :href="route('download.content', content.id)"
                        class="text-red-600 hover:text-red-900 hover:underline"
                        >Download<span class="sr-only"
                          >, {{ content.title }}</span
                        ></a
                      >
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <TransitionRoot :show="open" as="template">
      <Dialog
        as="div"
        class="fixed inset-0 z-10 overflow-hidden"
        @close="open = false"
      >
        <form
          method="PATCH"
          @submit.prevent="
            form.patch(
              route('operator.grading.store', objectSelectedContent.id)
            )
          "
        >
          <div class="absolute inset-0 overflow-hidden">
            <DialogOverlay class="absolute inset-0" />
            <div
              class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10"
            >
              <TransitionChild
                as="template"
                enter="transform transition ease-in-out duration-500 sm:duration-700"
                enter-from="translate-x-full"
                enter-to="translate-x-0"
                leave="transform transition ease-in-out duration-500 sm:duration-700"
                leave-from="translate-x-0"
                leave-to="translate-x-full"
              >
                <div class="pointer-events-auto w-screen max-w-md">
                  <div
                    class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl"
                  >
                    <div
                      class="flex min-h-0 flex-1 flex-col overflow-y-scroll py-6"
                    >
                      <div class="px-4 sm:px-6">
                        <div class="flex items-start justify-between">
                          <DialogTitle class="text-lg font-medium text-gray-900"
                            >Penilaian
                          </DialogTitle>
                          <div class="ml-3 flex h-7 items-center">
                            <button
                              class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                              type="button"
                              @click="open = false"
                            >
                              <span class="sr-only">Close panel</span>
                              <XIcon aria-hidden="true" class="h-6 w-6" />
                            </button>
                          </div>
                        </div>
                      </div>
                      <div class="relative mt-6 flex-1 px-4 sm:px-6">
                        <div>
                          <dl class="sm:divide-y sm:divide-gray-200">
                            <div
                              class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5"
                            >
                              <dt class="text-sm font-medium text-gray-500">
                                Butir
                              </dt>
                              <dd
                                class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                              >
                                {{ objectSelectedContent.number }}
                              </dd>
                            </div>
                            <div
                              class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5"
                            >
                              <dt class="text-sm font-medium text-gray-500">
                                Judul
                              </dt>
                              <dd
                                class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                              >
                                {{ objectSelectedContent.title }}
                              </dd>
                            </div>
                            <div
                              class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5"
                            >
                              <dt class="text-sm font-medium text-gray-500">
                                Upload oleh
                              </dt>
                              <dd
                                class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                              >
                                {{ objectSelectedContent.author }}
                              </dd>
                            </div>
                            <div
                              class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5"
                            >
                              <dt class="text-sm font-medium text-gray-500">
                                Program Studi
                              </dt>
                              <dd
                                class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                              >
                                {{ objectSelectedContent.major_name }}
                              </dd>
                            </div>
                            <div
                              class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5"
                            >
                              <dt class="text-sm font-medium text-gray-500">
                                Lampiran Dokumen
                              </dt>
                              <dd
                                class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                              >
                                <ul
                                  class="divide-y divide-gray-200 rounded-md border border-gray-200"
                                  role="list"
                                >
                                  <li
                                    class="flex items-center justify-between py-3 pl-3 pr-4 text-sm"
                                  >
                                    <div class="flex w-0 flex-1 items-center">
                                      <PaperClipIcon
                                        aria-hidden="true"
                                        class="h-5 w-5 flex-shrink-0 text-gray-400"
                                      />
                                      <span class="ml-2 w-0 flex-1 truncate">
                                        {{ objectSelectedContent.file }}
                                      </span>
                                    </div>
                                    <div class="ml-4 flex-shrink-0">
                                      <a
                                        :href="
                                          route(
                                            'download.content',
                                            objectSelectedContent.id
                                          )
                                        "
                                        class="font-medium text-indigo-600 hover:text-indigo-500"
                                      >
                                        Download
                                      </a>
                                    </div>
                                  </li>
                                </ul>
                              </dd>
                            </div>

                            <div
                              class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5"
                            >
                              <dt class="text-sm font-medium text-gray-500">
                                Penilian
                              </dt>
                              <dd
                                class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                              >
                                <TextInput
                                  v-model="form.grade"
                                  max="4"
                                  min="0"
                                  step="0.01"
                                  type="number"
                                />
                                <InputError
                                  v-if="form.errors.grade"
                                  :message="form.errors.grade"
                                />
                                <p class="mt-2 text-sm text-gray-800">
                                  Panduan penilian terdapat pada halaman
                                  referensi, untuk melihat lebih lanjut silahkan
                                  klik
                                  <Link
                                    :href="route('refferences.index')"
                                    class="text-indigo-500 hover:underline"
                                    method="GET"
                                    >disini.
                                  </Link>
                                </p>
                              </dd>
                            </div>
                          </dl>
                        </div>
                      </div>
                    </div>
                    <div class="flex flex-shrink-0 justify-end px-4 py-4">
                      <button
                        class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        type="button"
                        @click="open = false"
                      >
                        Cancel
                      </button>
                      <button
                        class="ml-4 inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        type="submit"
                      >
                        Save
                      </button>
                    </div>
                  </div>
                </div>
              </TransitionChild>
            </div>
          </div>
        </form>
      </Dialog>
    </TransitionRoot>
  </AppLayout>
</template>

<script setup>
import AppLayout from "../../../Layouts/AppLayout.vue";
import { computed, ref, watch } from "vue";
import {
  Dialog,
  DialogOverlay,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { PaperClipIcon, XIcon } from "@heroicons/vue/outline";
import TextInput from "../../../Components/TextInput.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import InputError from "../../../Components/InputError.vue";
import InputLabel from "../../../Components/InputLabel.vue";
import SelectMenu from "../../../Components/SelectMenu.vue";
import { Inertia } from "@inertiajs/inertia";

const props = defineProps(["contents", "majors"]);

const selectedMajorId = ref("");
const selectedContent = ref("");
const open = ref(false);

const form = useForm({
  grade: "",
});

watch(
  () => selectedMajorId.value,
  (newValue, oldValue) => {
    Inertia.get(
      route("operator.grading.index", { majorId: newValue }),
      {},
      { preserveState: true }
    );
  }
);

const objectSelectedContent = computed(() => {
  if (props.contents.length > 0) {
    return props.contents.filter(
      (content) => selectedContent.value === content.id
    )[0];
  }
});
</script>
