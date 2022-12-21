<template>
  <Link
    :class="classesLink"
    class="group flex items-center rounded-md px-2 py-2 text-base font-medium"
  >
    <component
      :is="icon"
      :class="classesComponent"
      aria-hidden="true"
      class="mr-4 h-6 w-6 flex-shrink-0"
    />
    <slot />
  </Link>
</template>

<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps(["active", "icon"]);

const classesLink = computed(() => {
  return props.active
    ? "bg-gray-100 text-gray-900"
    : "text-gray-600 hover:bg-gray-50 hover:text-gray-900";
});

const classesComponent = computed(() => {
  return props.active
    ? "text-gray-500"
    : "text-gray-400 group-hover:text-gray-500";
});
</script>
