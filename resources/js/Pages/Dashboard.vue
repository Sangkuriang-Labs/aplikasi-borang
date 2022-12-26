<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps(["standards", "majors"]);
</script>

<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Dashboard
      </h2>
    </template>

    <div v-for="major in majors" :key="major.id" class="mb-6">
      <h3 class="text-lg font-medium leading-6 text-gray-900">
        {{ major.name }}
      </h3>
      <dl
        class="mt-5 grid grid-cols-1 overflow-hidden rounded-lg bg-white md:grid-cols-4"
      >
        <div
          v-for="standard in major.contents"
          :key="standard.id"
          class="flex flex-col justify-between border px-4 py-5 sm:p-6"
        >
          <dt class="text-base font-normal text-gray-900">
            {{ standard.title }}
          </dt>
          <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
            <div
              class="flex items-baseline text-2xl font-semibold text-indigo-600"
            >
              {{
                isNaN(standard.total_grade / standard.count_sub)
                  ? "0.00"
                  : (standard.total_grade / standard.count_sub).toFixed(2)
              }}
              <span class="ml-2 text-sm font-medium text-gray-500">
                dari 4.00
              </span>
            </div>
          </dd>
        </div>
      </dl>
    </div>
  </AppLayout>
</template>
