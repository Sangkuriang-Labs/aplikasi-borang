<script setup>
import AppLayout from "../../../Layouts/AppLayout.vue";
import { Link, useForm } from "@inertiajs/inertia-vue3";
import { ref, watch } from "vue";
import {
  Dialog,
  DialogOverlay,
  DialogTitle,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import { XIcon } from "@heroicons/vue/outline";
import InputLabel from "../../../Components/InputLabel.vue";
import TextInput from "../../../Components/TextInput.vue";
import InputError from "../../../Components/InputError.vue";

const props = defineProps(["subs", "standards", "majors"]);

const openAdd = ref(false);
const formAdd = useForm({
  name: "",
});

const openEdit = ref(false);
const selectedEdit = ref(null);
const formEdit = useForm({
  id: 0,
  name: "",
});

watch(
  () => selectedEdit.value,
  (newValue, oldValue) => {
    const selectedObject = props.majors.filter(
      (major) => major.id === newValue
    );
    formEdit.id = selectedObject[0].id;
    formEdit.name = selectedObject[0].name;
  }
);
</script>

<template>
  <AppLayout title="Pengguna">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">
        Program Studi
      </h2>
    </template>
    <div class="overflow-hidden rounded-lg bg-white shadow">
      <div class="px-4 py-5 sm:p-6">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Program Studi</h1>
            <p class="mt-2 text-sm text-gray-700">
              Seluruh program studi yang tersedia di dalam sistem.
            </p>
          </div>
          <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <button
              class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
              type="button"
              @click="openAdd = true"
            >
              Tambahkan Program Studi
            </button>
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
                        Id
                      </th>
                      <th
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        scope="col"
                      >
                        Nama Program Studi
                      </th>
                      <th class="relative py-3.5 pl-3 pr-4 sm:pr-6" scope="col">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="major in majors" :key="major.id">
                      <td
                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-500 sm:pl-6"
                      >
                        {{ major.id }}
                      </td>
                      <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-900"
                      >
                        {{ major.name }}
                      </td>
                      <td
                        class="relative space-x-3 whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                      >
                        <button
                          class="text-indigo-600 hover:text-indigo-900"
                          @click="
                            () => {
                              selectedEdit = major.id;
                              openEdit = true;
                            }
                          "
                        >
                          Edit
                          <span class="sr-only">
                            {{ major.name }}
                          </span>
                        </button>
                        <Link
                          :href="route('operator.majors.destroy', major.id)"
                          as="button"
                          class="text-red-600 hover:text-red-900"
                          method="DELETE"
                          >Delete
                          <span class="sr-only">
                            {{ major.name }}
                          </span>
                        </Link>
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
    <!--  ADD  -->
    <TransitionRoot :show="openAdd" as="template" class="z-10">
      <Dialog
        as="div"
        class="fixed inset-0 overflow-hidden"
        @close="openAdd = false"
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
                <form
                  class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl"
                  @submit.prevent="
                    formAdd.post(route('operator.majors.store'), {
                      onSuccess: () => {
                        formAdd.reset();
                        formAdd.clearErrors();
                        openAdd = false;
                      },
                    })
                  "
                >
                  <div
                    class="flex min-h-0 flex-1 flex-col overflow-y-scroll py-6"
                  >
                    <div class="px-4 sm:px-6">
                      <div class="flex items-start justify-between">
                        <DialogTitle class="text-lg font-medium text-gray-900"
                          >Tambahkan Program Studi Baru
                        </DialogTitle>
                        <div class="ml-3 flex h-7 items-center">
                          <button
                            class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            type="button"
                            @click="openAdd = false"
                          >
                            <span class="sr-only">Close panel</span>
                            <XIcon aria-hidden="true" class="h-6 w-6" />
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="relative mt-6 flex-1 space-y-2 px-4 sm:px-6">
                      <div>
                        <InputLabel for="name" value="Nama Program Studi" />
                        <TextInput
                          id="name"
                          v-model="formAdd.name"
                          class="mt-2"
                          name="name"
                          type="text"
                        />
                        <InputError
                          v-if="formAdd.errors.name"
                          :message="formAdd.errors.name"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="flex flex-shrink-0 justify-end px-4 py-4">
                    <div>
                      <button
                        class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        type="button"
                        @click="openAdd = false"
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
                </form>
              </div>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
    <!-- EDIT -->
    <TransitionRoot :show="openEdit" as="template" class="z-10">
      <Dialog
        as="div"
        class="fixed inset-0 overflow-hidden"
        @close="openEdit = false"
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
                <form
                  class="flex h-full flex-col divide-y divide-gray-200 bg-white shadow-xl"
                  @submit.prevent="
                    formEdit.patch(
                      route('operator.majors.update', formEdit.id),
                      {
                        onSuccess: () => {
                          formEdit.reset();
                          formEdit.clearErrors();
                          openEdit = false;
                        },
                      }
                    )
                  "
                >
                  <div
                    class="flex min-h-0 flex-1 flex-col overflow-y-scroll py-6"
                  >
                    <div class="px-4 sm:px-6">
                      <div class="flex items-start justify-between">
                        <DialogTitle class="text-lg font-medium text-gray-900"
                          >Edit Program Studi
                        </DialogTitle>
                        <div class="ml-3 flex h-7 items-center">
                          <button
                            class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            type="button"
                            @click="openEdit = false"
                          >
                            <span class="sr-only">Close panel</span>
                            <XIcon aria-hidden="true" class="h-6 w-6" />
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="relative mt-6 flex-1 space-y-2 px-4 sm:px-6">
                      <div>
                        <InputLabel for="name" value="Nama Program Studi" />
                        <TextInput
                          id="name"
                          v-model="formEdit.name"
                          class="mt-2"
                          name="name"
                          type="text"
                        />
                        <InputError
                          v-if="formEdit.errors.name"
                          :message="formEdit.errors.name"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="flex flex-shrink-0 justify-end px-4 py-4">
                    <div>
                      <button
                        class="rounded-md border border-gray-300 bg-white py-2 px-4 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        type="button"
                        @click="openEdit = false"
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
                </form>
              </div>
            </TransitionChild>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </AppLayout>
</template>
