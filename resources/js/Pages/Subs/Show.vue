<script setup>
import AppLayout from "../../Layouts/AppLayout.vue";
import { PaperClipIcon, PlusIcon, TrashIcon } from "@heroicons/vue/solid";
import { Link, usePage } from "@inertiajs/inertia-vue3";
import { computed } from "vue";
import dayjs from "dayjs";
import relativeTime from "dayjs/plugin/relativeTime";
import "dayjs/locale/id";

dayjs.extend(relativeTime);

const props = defineProps(["sub", "contents", "histories"]);

const historyData = computed(() => {
  return props.histories.map((history) => ({
    id: history.id,
    author: history.author,
    content: operationText(history.operation),
    target: history.title,
    time: dayjs(history.updated_at).locale("id").fromNow(),
    icon: operationIcon(history.operation),
    iconBackground: operationBg(history.operation),
  }));
});

function operationText(operation) {
  if (operation === "ADD") {
    return "menambahkan dokumen baru pada";
  } else if (operation === "DELETE") {
    return "menghapus dokumen pada";
  }
}

function operationIcon(operation) {
  if (operation === "ADD") {
    return PlusIcon;
  } else if (operation === "DELETE") {
    return TrashIcon;
  }
}

function operationBg(operation) {
  if (operation === "ADD") {
    return "bg-gray-400";
  } else if (operation === "DELETE") {
    return "bg-red-400";
  }
}
</script>

<template>
  <AppLayout title="Detail Dokumen">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Detail Dokumen
      </h2>
    </template>

    <main>
      <div
        class="mx-auto mt-8 grid grid-cols-1 gap-6 lg:grid-flow-col-dense lg:grid-cols-3"
      >
        <div class="space-y-6 lg:col-span-2 lg:col-start-1">
          <!-- Description list-->
          <section aria-labelledby="applicant-information-title">
            <div class="bg-white shadow sm:rounded-lg">
              <div class="px-4 py-5 sm:px-6">
                <h2
                  id="applicant-information-title"
                  class="text-lg font-medium leading-6 text-gray-900"
                >
                  Informasi Dokumen
                </h2>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                  Seluruh detail informasi mengenai dokumen yang telah terupload
                  pada {{ sub.title }}
                </p>
              </div>
              <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                  <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                      Judul Dokumen
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      {{ sub.title }}
                    </dd>
                  </div>
                  <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                      Nomor Butir
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      {{ sub.number }}
                    </dd>
                  </div>
                  <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                      Terakhir pembaharuan
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      {{ dayjs(contents[0].created_at).locale("id").fromNow() }}
                    </dd>
                  </div>
                  <div class="sm:col-span-1">
                    <dt class="text-sm font-medium text-gray-500">
                      Terakhir diperbaharui oleh
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      {{ contents[0].user.name }}
                    </dd>
                  </div>
                  <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">
                      Tentang dokumen
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      {{ sub.desc }}
                    </dd>
                  </div>
                  <div class="sm:col-span-2">
                    <dt class="text-sm font-medium text-gray-500">
                      Lampiran dokumen
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      <ul
                        class="divide-y divide-gray-200 rounded-md border border-gray-200"
                        role="list"
                      >
                        <li
                          v-for="dokumen in contents"
                          :key="dokumen.id"
                          class="flex items-center justify-between py-3 pl-3 pr-4 text-sm"
                        >
                          <div class="flex w-0 flex-1 items-center">
                            <PaperClipIcon
                              aria-hidden="true"
                              class="h-5 w-5 flex-shrink-0 text-gray-400"
                            />
                            <span class="ml-2 w-0 flex-1 truncate">
                              {{ dokumen.file.split("/")[1] }}
                            </span>
                          </div>
                          <div class="ml-4 flex-shrink-0 space-x-3">
                            <Link
                              v-if="
                                dokumen.user_id ===
                                usePage().props.value.auth.user.id
                              "
                              :href="route('contents.destroy', dokumen.id)"
                              class="font-medium text-red-600 hover:text-red-500"
                              method="DELETE"
                            >
                              Delete
                            </Link>
                            <a
                              :href="route('download', dokumen.id)"
                              class="font-medium text-blue-600 hover:text-blue-500"
                            >
                              Download
                            </a>
                          </div>
                        </li>
                      </ul>
                    </dd>
                  </div>
                </dl>
              </div>
            </div>
          </section>
        </div>

        <section
          aria-labelledby="timeline-title"
          class="lg:col-span-1 lg:col-start-3"
        >
          <div class="bg-white px-4 py-5 shadow sm:rounded-lg sm:px-6">
            <h2 id="timeline-title" class="text-lg font-medium text-gray-900">
              Riwayat
            </h2>

            <!-- Activity Feed -->
            <div class="mt-6 flow-root">
              <ul v-if="historyData.length > 0" class="-mb-8" role="list">
                <li
                  v-for="(history, historyIdx) in historyData"
                  :key="history.id"
                >
                  <div class="relative pb-8">
                    <span
                      v-if="historyIdx !== historyData.length - 1"
                      aria-hidden="true"
                      class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200"
                    />
                    <div class="relative flex space-x-3">
                      <div>
                        <span
                          :class="[
                            history.iconBackground,
                            'flex h-8 w-8 items-center justify-center rounded-full ring-8 ring-white',
                          ]"
                        >
                          <component
                            :is="history.icon"
                            aria-hidden="true"
                            class="h-5 w-5 text-white"
                          />
                        </span>
                      </div>
                      <div
                        class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5"
                      >
                        <div>
                          <p class="text-sm text-gray-500">
                            {{ history.author }} {{ history.content }}
                            {{ history.target }}
                          </p>
                        </div>
                        <div
                          class="whitespace-nowrap text-right text-sm text-gray-500"
                        >
                          <span>{{ history.time }}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </section>
      </div>
    </main>
  </AppLayout>
</template>
