<template>
  <div>
    <Head :title="title" />
    <TransitionRoot :show="sidebarOpen" as="template">
      <Dialog
        as="div"
        class="fixed inset-0 z-40 flex md:hidden"
        @close="sidebarOpen = false"
      >
        <TransitionChild
          as="template"
          enter="transition-opacity ease-linear duration-300"
          enter-from="opacity-0"
          enter-to="opacity-100"
          leave="transition-opacity ease-linear duration-300"
          leave-from="opacity-100"
          leave-to="opacity-0"
        >
          <DialogOverlay class="fixed inset-0 bg-gray-600 bg-opacity-75" />
        </TransitionChild>
        <TransitionChild
          as="template"
          enter="transition ease-in-out duration-300 transform"
          enter-from="-translate-x-full"
          enter-to="translate-x-0"
          leave="transition ease-in-out duration-300 transform"
          leave-from="translate-x-0"
          leave-to="-translate-x-full"
        >
          <div class="relative flex w-full max-w-xs flex-1 flex-col bg-white">
            <TransitionChild
              as="template"
              enter="ease-in-out duration-300"
              enter-from="opacity-0"
              enter-to="opacity-100"
              leave="ease-in-out duration-300"
              leave-from="opacity-100"
              leave-to="opacity-0"
            >
              <div class="absolute top-0 right-0 -mr-12 pt-2">
                <button
                  class="ml-1 flex h-10 w-10 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                  type="button"
                  @click="sidebarOpen = false"
                >
                  <span class="sr-only">Close sidebar</span>
                  <XIcon aria-hidden="true" class="h-6 w-6 text-white" />
                </button>
              </div>
            </TransitionChild>
            <div class="h-0 flex-1 overflow-y-auto pt-5 pb-4">
              <div class="flex flex-shrink-0 items-center px-4">
                <Link :href="route('dashboard')">
                  <ApplicationLogo />
                </Link>
              </div>
              <nav class="mt-5 space-y-1 px-2">
                <NavLinkNew
                  :active="route().current('dashboard')"
                  :href="route('dashboard')"
                  :icon="HomeIcon"
                >
                  Dashboard
                </NavLinkNew>
                <NavLinkNew
                  :active="route().current('subs.index')"
                  :href="route('subs.index')"
                  :icon="DocumentIcon"
                  v-if="
                    usePage().props.value.level > 0 &&
                    usePage().props.value.level < 3
                  "
                >
                  Dokumen
                </NavLinkNew>
                <NavLinkNew
                  v-if="usePage().props.value.level > 2"
                  :active="route().current('operator.contents.index')"
                  :href="route('operator.contents.index')"
                  :icon="DocumentIcon"
                >
                  Dokumen
                </NavLinkNew>
                <NavLinkNew
                  v-if="usePage().props.value.level > 2"
                  :active="route().current('operator.grading.index')"
                  :href="route('operator.grading.index')"
                  :icon="ClipboardListIcon"
                >
                  Penilaian Dokumen
                </NavLinkNew>
                <NavLinkNew
                  v-if="usePage().props.value.level > 2"
                  :active="route().current('users.index')"
                  :href="route('users.index')"
                  :icon="UserIcon"
                >
                  Pengguna
                </NavLinkNew>
                <NavLinkNew
                  v-if="usePage().props.value.level > 2"
                  :active="route().current('standards.index')"
                  :href="route('standards.index')"
                  :icon="DocumentIcon"
                >
                  Standar
                </NavLinkNew>
                <NavLinkNew
                  v-if="usePage().props.value.level > 2"
                  :active="route().current('operator.subs.index')"
                  :href="route('operator.subs.index')"
                  :icon="DocumentDuplicateIcon"
                >
                  Sub
                </NavLinkNew>
                <NavLinkNew
                  v-if="usePage().props.value.level > 2"
                  :active="route().current('operator.majors.index')"
                  :href="route('operator.majors.index')"
                  :icon="OfficeBuildingIcon"
                >
                  Program Studi
                </NavLinkNew>
                <NavLinkNew
                  :active="route().current('refferences.index')"
                  :href="route('refferences.index')"
                  :icon="InformationCircleIcon"
                >
                  Referensi
                </NavLinkNew>
              </nav>
            </div>
            <div
              class="flex flex-shrink-0 flex-col space-y-2 border-t border-gray-200 p-4"
            >
              <Link
                :href="route('profile.show')"
                class="group block flex-shrink-0"
              >
                <div class="flex items-center">
                  <div v-if="$page.props.jetstream.managesProfilePhotos">
                    <img
                      :alt="$page.props.user.name"
                      :src="$page.props.user.profile_photo_url"
                      class="h-8 w-8 rounded-full object-cover"
                    />
                  </div>
                  <div class="ml-3">
                    <p
                      class="text-base font-medium text-gray-700 group-hover:text-gray-900"
                    >
                      {{ $page.props.user.name }}
                    </p>
                    <p
                      class="text-sm font-medium text-gray-500 group-hover:text-gray-700"
                    >
                      View profile
                    </p>
                  </div>
                </div>
              </Link>
              <LinkIcon
                :href="route('logout')"
                :icon="LogoutIcon"
                method="POST"
                variant="danger"
              >
                Logout
              </LinkIcon>
            </div>
          </div>
        </TransitionChild>
        <div class="w-14 flex-shrink-0">
          <!-- Force sidebar to shrink to fit close icon -->
        </div>
      </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div class="hidden md:fixed md:inset-y-0 md:flex md:w-64 md:flex-col">
      <!-- Sidebar component, swap this element with another sidebar if you like -->
      <div
        class="flex min-h-0 flex-1 flex-col border-r border-gray-200 bg-white"
      >
        <div class="flex flex-1 flex-col overflow-y-auto pt-5 pb-4">
          <div class="flex flex-shrink-0 items-center px-4">
            <Link :href="route('dashboard')">
              <ApplicationLogo />
            </Link>
          </div>
          <nav class="mt-5 flex-1 space-y-1 bg-white px-2">
            <NavLinkNew
              :active="route().current('dashboard')"
              :href="route('dashboard')"
              :icon="HomeIcon"
              >Dashboard
            </NavLinkNew>
            <NavLinkNew
              :active="route().current('subs.index')"
              :href="route('subs.index')"
              :icon="DocumentIcon"
              v-if="
                usePage().props.value.level > 0 &&
                usePage().props.value.level < 3
              "
            >
              Dokumen
            </NavLinkNew>
            <NavLinkNew
              v-if="usePage().props.value.level > 2"
              :active="route().current('operator.contents.index')"
              :href="route('operator.contents.index')"
              :icon="DocumentIcon"
            >
              Dokumen
            </NavLinkNew>
            <NavLinkNew
              v-if="usePage().props.value.level > 2"
              :active="route().current('operator.grading.index')"
              :href="route('operator.grading.index')"
              :icon="ClipboardListIcon"
            >
              Penilaian Dokumen
            </NavLinkNew>
            <NavLinkNew
              v-if="usePage().props.value.level > 2"
              :active="route().current('users.index')"
              :href="route('users.index')"
              :icon="UserIcon"
            >
              Pengguna
            </NavLinkNew>
            <NavLinkNew
              v-if="usePage().props.value.level > 2"
              :active="route().current('standards.index')"
              :href="route('standards.index')"
              :icon="DocumentIcon"
            >
              Standar
            </NavLinkNew>
            <NavLinkNew
              v-if="usePage().props.value.level > 2"
              :active="route().current('operator.subs.index')"
              :href="route('operator.subs.index')"
              :icon="DocumentDuplicateIcon"
            >
              Sub
            </NavLinkNew>
            <NavLinkNew
              v-if="usePage().props.value.level > 2"
              :active="route().current('operator.majors.index')"
              :href="route('operator.majors.index')"
              :icon="OfficeBuildingIcon"
            >
              Program Studi
            </NavLinkNew>
            <NavLinkNew
              :active="route().current('refferences.index')"
              :href="route('refferences.index')"
              :icon="InformationCircleIcon"
            >
              Referensi
            </NavLinkNew>
          </nav>
        </div>
        <div
          class="flex flex-shrink-0 flex-col space-y-2 border-t border-gray-200 p-4"
        >
          <Link
            :href="route('profile.show')"
            class="group block w-full flex-shrink-0"
          >
            <div class="flex items-center">
              <div>
                <img
                  :alt="$page.props.user.name"
                  :src="$page.props.user.profile_photo_url"
                  class="inline-block h-9 w-9 rounded-full"
                />
              </div>
              <div class="ml-3">
                <p
                  class="text-sm font-medium text-gray-700 group-hover:text-gray-900"
                >
                  {{ $page.props.user.name }}
                </p>
                <p
                  class="text-xs font-medium text-gray-500 group-hover:text-gray-700"
                >
                  Lihat profile
                </p>
              </div>
            </div>
          </Link>
          <LinkIcon
            :href="route('logout')"
            :icon="LogoutIcon"
            method="POST"
            variant="danger"
          >
            Keluar
          </LinkIcon>
        </div>
      </div>
    </div>
    <div class="flex flex-1 flex-col md:pl-64">
      <div
        class="sticky top-0 z-10 bg-white pl-1 pt-1 sm:pl-3 sm:pt-3 md:hidden"
      >
        <button
          class="-ml-0.5 -mt-0.5 inline-flex h-12 w-12 items-center justify-center rounded-md text-gray-500 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
          type="button"
          @click="sidebarOpen = true"
        >
          <span class="sr-only">Open sidebar</span>
          <MenuIcon aria-hidden="true" class="h-6 w-6" />
        </button>
      </div>
      <main class="flex-1">
        <div class="py-6">
          <div
            class="max-w-8xl mx-auto px-2 text-center sm:px-4 md:px-6 md:text-left"
          >
            <slot name="header" />
          </div>
          <div class="max-w-8xl mx-auto mt-10 px-2 sm:px-4 md:px-6">
            <!-- Replace with your content -->
            <slot />
            <!-- /End replace -->
          </div>
        </div>
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import {
  Dialog,
  DialogOverlay,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import {
  DocumentIcon,
  HomeIcon,
  LogoutIcon,
  MenuIcon,
  XIcon,
} from "@heroicons/vue/outline";
import ApplicationLogo from "../Components/ApplicationLogo.vue";
import LinkIcon from "../Components/LinkIcon.vue";
import NavLinkNew from "../Components/NavLinkNew.vue";
import {
  ClipboardListIcon,
  DocumentDuplicateIcon,
  InformationCircleIcon,
  OfficeBuildingIcon,
  UserIcon,
} from "@heroicons/vue/solid";

defineProps(["title"]);

const sidebarOpen = ref(false);
</script>
