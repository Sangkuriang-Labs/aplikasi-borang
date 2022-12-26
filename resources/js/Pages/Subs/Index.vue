<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { computed, onMounted, ref, watch } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import "dayjs/locale/id";

dayjs.extend(relativeTime);

const props = defineProps(["standards", "contents"]);

const selectedStandard = ref(null);

const objectSelectedStandard = computed(() => {
  const filteredStandard = props.standards.filter(
    (standard) => standard.id === selectedStandard.value
  );
  return filteredStandard[0];
});

onMounted(() => {
  selectedStandard.value = props.standards[0].id;
});

watch(selectedStandard, (newValue, oldValue) => {
  newValue = parseInt(newValue);
  Inertia.get(
    route("subs.index", { standardId: newValue }),
    {},
    { preserveState: true }
  );
});
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Dokumen</h2>
    </template>

    <div
      class="divide-y divide-gray-200 overflow-hidden rounded-md border bg-white"
    >
      <div class="px-4 py-5 sm:px-6">
        <!-- Content goes here -->
        <!-- We use less vertical padding on card headers on desktop than on body sections -->
        <div class="relative border-b border-gray-200 pb-5 sm:pb-0">
          <div
            class="flex flex-col items-center justify-between space-y-2 sm:flex-row sm:space-y-0"
          >
            <h3 class="text-lg font-medium leading-6 text-gray-900">
              Seluruh Dokumen
            </h3>
            <Link
              :href="route('contents.create')"
              class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:ml-3"
              type="button"
            >
              Tambahkan Dokumen
            </Link>
          </div>
          <div class="mt-4">
            <div class="md:hidden">
              <label class="sr-only" for="current-tab">Select a tab</label>
              <select
                id="current-tab"
                class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                name="current-tab"
              >
                <option
                  v-for="standard in standards"
                  :key="standard.id"
                  :selected="standard.id === selectedStandard"
                  @click="() => (selectedStandard = standard.id)"
                >
                  {{ standard.value }}
                </option>
              </select>
            </div>
            <div class="hidden md:block">
              <nav class="-mb-px flex space-x-2">
                <button
                  v-for="standard in standards"
                  :key="standard.id"
                  :class="[
                    standard.id === selectedStandard
                      ? 'border-indigo-500 text-indigo-600'
                      : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700',
                    'whitespace-nowrap border-b-2 px-1 pb-4 text-sm font-medium',
                  ]"
                  @click="() => (selectedStandard = standard.id)"
                >
                  Standar {{ standard.id }}
                </button>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <div class="grid grid-cols-6 gap-5 px-4 py-5 sm:p-6">
        <!-- Content goes here -->
        <div class="col-span-6 flex flex-col">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h3 class="text-lg font-medium leading-6 text-gray-900">
                {{ objectSelectedStandard ? objectSelectedStandard.value : "" }}
              </h3>
              <p class="mt-2 text-sm text-gray-700">
                {{ objectSelectedStandard ? objectSelectedStandard.desc : "" }}
              </p>
            </div>
          </div>
          <!--Data Table-->
          <div class="-my-2 -mx-4 mt-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
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
                        Total Dokumen
                      </th>
                      <th
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        scope="col"
                      >
                        Terakhir Update
                      </th>
                      <th
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        scope="col"
                      >
                        Oleh
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
                        {{ content.contents.length }}
                      </td>
                      <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                      >
                        {{ dayjs(content.updated.time).locale("id").fromNow() }}
                      </td>
                      <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                      >
                        {{ content.updated.author }}
                      </td>
                      <td
                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                      >
                        <Link
                          :href="route('subs.show', content.id)"
                          class="text-indigo-600 hover:text-indigo-900"
                          >Detail<span class="sr-only"
                            >, {{ content.title }}</span
                          ></Link
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
    </div>
  </AppLayout>
</template>
