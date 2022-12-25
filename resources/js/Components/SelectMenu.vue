<template>
  <select
    id="location"
    class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 disabled:opacity-30 sm:text-sm"
    name="location"
    @change="$emit('update:modelValue', $event.target.value)"
  >
    <option :selected="modelValue === ''" value=""></option>
    <option
      v-for="option in dataOption"
      :key="option.id"
      :selected="modelValue === option.id"
      :value="option.id"
    >
      {{ option.value }}
    </option>
  </select>
</template>

<script setup>
defineProps(["dataOption", "modelValue"]);
defineEmits(["update:modelValue"]);
</script>
