<template>
  <div class="bg-white">
    <div
      class="mx-auto max-w-7xl py-8 px-4 sm:py-16 sm:px-6 lg:flex lg:items-center lg:justify-between lg:px-8"
    >
      <div class="max-w-xl">
        <h2
          class="text-2xl font-extrabold text-gray-900 sm:text-3xl sm:tracking-tight lg:text-4xl"
        >
          <slot name="title" />
        </h2>
        <p class="mt-5 text-lg text-gray-500">
          <slot name="desc" />
        </p>
      </div>
      <div class="mt-10 w-full max-w-xs">
        <slot name="right-content" />
      </div>
    </div>
  </div>
</template>

<script setup></script>
