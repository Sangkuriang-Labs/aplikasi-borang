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
import SelectMenu from "../../../Components/SelectMenu.vue";

const props = defineProps(["subs", "standards"]);

const openAdd = ref(false);
const formAdd = useForm({
  standard_id: "",
  title: "",
  number: "",
  child: false,
  desc: "",
});

const openEdit = ref(false);
const selectedEdit = ref(null);
const formEdit = useForm({
  id: 0,
  standard_id: "",
  title: "",
  number: "",
  child: false,
  desc: "",
});

watch(
  () => selectedEdit.value,
  (newValue, oldValue) => {
    const selectedObject = props.subs.filter((sub) => sub.id === newValue);
    formEdit.id = selectedObject[0].id;
    formEdit.standard_id = selectedObject[0].standard_id;
    formEdit.title = selectedObject[0].title;
    formEdit.number = selectedObject[0].number_sub;
    formEdit.child = selectedObject[0].type;
    formEdit.desc = selectedObject[0].desc;
  }
);
</script>

<template>
  <AppLayout title="Pengguna">
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Sub</h2>
    </template>
    <div class="overflow-hidden rounded-lg bg-white shadow">
      <div class="px-4 py-5 sm:p-6">
        <div class="sm:flex sm:items-center">
          <div class="sm:flex-auto">
            <h1 class="text-xl font-semibold text-gray-900">Sub</h1>
            <p class="mt-2 text-sm text-gray-700">
              Seluruh sub standar yang tersedia di dalam sistem.
            </p>
          </div>
          <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <button
              class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
              type="button"
              @click="openAdd = true"
            >
              Tambahkan Sub
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
                        Nomor Standar
                      </th>
                      <th
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        scope="col"
                      >
                        Nomor Sub
                      </th>
                      <th
                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        scope="col"
                      >
                        Jenis
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
                        Keterangan
                      </th>
                      <th class="relative py-3.5 pl-3 pr-4 sm:pr-6" scope="col">
                        <span class="sr-only">Edit</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="sub in subs" :key="sub.id">
                      <td
                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-500 sm:pl-6"
                      >
                        {{ sub.number_standard }}
                      </td>
                      <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-900"
                      >
                        {{ sub.number_sub }}
                      </td>
                      <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-900"
                      >
                        {{ sub.type ? "Sub" : "Butir" }}
                      </td>
                      <td
                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-900"
                      >
                        {{ sub.title }}
                      </td>
                      <td
                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-500"
                      >
                        {{ sub.desc.slice(0, 20) + "..." }}
                      </td>
                      <td
                        class="relative space-x-3 whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                      >
                        <button
                          class="text-indigo-600 hover:text-indigo-900"
                          @click="
                            () => {
                              selectedEdit = sub.id;
                              openEdit = true;
                            }
                          "
                        >
                          Edit
                          <span class="sr-only">
                            {{ sub.title }}
                          </span>
                        </button>
                        <Link
                          :href="route('operator.subs.destroy', sub.id)"
                          as="button"
                          class="text-red-600 hover:text-red-900"
                          method="DELETE"
                          >Delete
                          <span class="sr-only">
                            {{ sub.title }}
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
                    formAdd.post(route('operator.subs.store'), {
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
                          >Tambahkan Sub Baru
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
                        <InputLabel for="standard_id" value="Standar" />
                        <SelectMenu
                          id="standard_id"
                          v-model="formAdd.standard_id"
                          :data-option="standards"
                          name="standard_id"
                        />
                        <InputError
                          v-if="formAdd.errors.standard_id"
                          :message="formAdd.errors.standard_id"
                        />
                      </div>
                      <div>
                        <InputLabel for="title" value="Nama" />
                        <TextInput
                          id="title"
                          v-model="formAdd.title"
                          class="mt-2"
                          name="title"
                          type="text"
                        />
                        <InputError
                          v-if="formAdd.errors.title"
                          :message="formAdd.errors.title"
                        />
                      </div>
                      <div>
                        <InputLabel for="number" value="Nomor Standar" />
                        <TextInput
                          id="number"
                          v-model="formAdd.number"
                          class="mt-2"
                          name="number"
                          type="text"
                        />
                        <InputError
                          v-if="formAdd.errors.number"
                          :message="formAdd.errors.number"
                        />
                      </div>
                      <div>
                        <InputLabel for="child" value="Jenis" />
                        <select
                          v-model="formAdd.child"
                          class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 disabled:opacity-30 sm:text-sm"
                        >
                          <option value=""></option>
                          <option :value="true">Sub</option>
                          <option :value="false">Butir</option>
                        </select>
                        <InputError
                          v-if="formAdd.errors.child"
                          :message="formAdd.errors.child"
                        />
                      </div>
                      <div>
                        <InputLabel for="desc" value="Keterangan Sub" />
                        <textarea
                          id="desc"
                          v-model="formAdd.desc"
                          class="mt-2 block h-52 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                          name="desc"
                        />
                        <InputError
                          v-if="formAdd.errors.desc"
                          :message="formAdd.errors.desc"
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
                    formEdit.patch(route('operator.subs.update', formEdit.id), {
                      onSuccess: () => {
                        formEdit.reset();
                        formEdit.clearErrors();
                        openEdit = false;
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
                          >Edit Sub
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
                        <InputLabel for="standard_id" value="Standar" />
                        <SelectMenu
                          id="standard_id"
                          v-model="formEdit.standard_id"
                          :data-option="standards"
                          name="standard_id"
                        />
                        <InputError
                          v-if="formEdit.errors.standard_id"
                          :message="formEdit.errors.standard_id"
                        />
                      </div>
                      <div>
                        <InputLabel for="title" value="Nama" />
                        <TextInput
                          id="title"
                          v-model="formEdit.title"
                          class="mt-2"
                          name="title"
                          type="text"
                        />
                        <InputError
                          v-if="formEdit.errors.title"
                          :message="formEdit.errors.title"
                        />
                      </div>
                      <div>
                        <InputLabel for="number" value="Nomor Standar" />
                        <TextInput
                          id="number"
                          v-model="formEdit.number"
                          class="mt-2"
                          name="number"
                          type="text"
                        />
                        <InputError
                          v-if="formEdit.errors.number"
                          :message="formEdit.errors.number"
                        />
                      </div>
                      <div>
                        <InputLabel for="child" value="Jenis" />
                        <select
                          id="child"
                          v-model="formEdit.child"
                          class="mt-1 block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 disabled:opacity-30 sm:text-sm"
                          name="child"
                        >
                          <option value=""></option>
                          <option :value="true">Sub</option>
                          <option :value="false">Butir</option>
                        </select>
                        <InputError
                          v-if="formEdit.errors.child"
                          :message="formEdit.errors.child"
                        />
                      </div>
                      <div>
                        <InputLabel for="desc" value="Keterangan Standar" />
                        <textarea
                          id="desc"
                          v-model="formEdit.desc"
                          class="mt-2 block h-52 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                          name="desc"
                        />
                        <InputError
                          v-if="formEdit.errors.desc"
                          :message="formEdit.errors.desc"
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
