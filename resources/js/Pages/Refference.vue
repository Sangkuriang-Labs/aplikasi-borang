<template>
  <AppLayout title="Referensi">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Referensi
      </h2>
    </template>

    <div class="overflow-hidden bg-white shadow sm:rounded-md">
      <ul class="divide-y divide-gray-200" role="list">
        <li v-for="refference in refferences" :key="refference.id">
          <a
            :href="route('download.refference', refference.id)"
            class="block hover:bg-gray-50"
          >
            <div class="px-4 py-4 sm:px-6">
              <div class="flex items-center justify-between">
                <p class="truncate text-sm font-medium text-indigo-600">
                  {{ refference.name }}
                </p>
              </div>
            </div>
          </a>
        </li>
      </ul>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "../Layouts/AppLayout.vue";

defineProps(["refferences"]);
</script>
