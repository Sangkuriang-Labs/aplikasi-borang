<template>
  <Link
    v-if="variant === 'danger'"
    as="button"
    class="inline-flex items-center justify-center rounded-md border border-transparent bg-red-600 px-3 py-2 text-sm font-medium leading-4 text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
  >
    <component :is="icon" class="mr-0.5 h-4 w-4" />
    <slot />
  </Link>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";

defineProps(["variant", "icon"]);
</script>
