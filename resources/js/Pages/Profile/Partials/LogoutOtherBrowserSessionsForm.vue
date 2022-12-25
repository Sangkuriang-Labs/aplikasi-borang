<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import ActionMessage from "@/Components/ActionMessage.vue";
import ActionSection from "@/Components/ActionSection.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

defineProps({
  sessions: Array,
});

const confirmingLogout = ref(false);
const passwordInput = ref(null);

const form = useForm({
  password: "",
});

const confirmLogout = () => {
  confirmingLogout.value = true;

  setTimeout(() => passwordInput.value.focus(), 250);
};

const logoutOtherBrowserSessions = () => {
  form.delete(route("other-browser-sessions.destroy"), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingLogout.value = false;

  form.reset();
};
</script>

<template>
  <ActionSection>
    <template #title> Sesi Browser</template>

    <template #description>
      Kelola dan keluar kan sesi aktif anda di browser atau perangkat lainnya.
    </template>

    <template #content>
      <div class="max-w-xl text-sm text-gray-600">
        Jika dibutuhkan, anda mungkin mengeluarkan sesi aktif browser di seluruh
        perangkat anda. Beberapa riwayat sesi aktif anda terlihat dibawah;
        namun, list dibawah ini tidak lengkap. Jika anda merasa akun anda tidak
        aman, anda harus juga harus mengubah password anda.
      </div>

      <!-- Other Browser Sessions -->
      <div v-if="sessions.length > 0" class="mt-5 space-y-6">
        <div
          v-for="(session, i) in sessions"
          :key="i"
          class="flex items-center"
        >
          <div>
            <svg
              v-if="session.agent.is_desktop"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              viewBox="0 0 24 24"
              stroke="currentColor"
              class="h-8 w-8 text-gray-500"
            >
              <path
                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
              />
            </svg>

            <svg
              v-else
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="currentColor"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
              class="h-8 w-8 text-gray-500"
            >
              <path d="M0 0h24v24H0z" stroke="none" />
              <rect height="16" rx="1" width="10" x="7" y="4" />
              <path d="M11 5h2M12 17v.01" />
            </svg>
          </div>

          <div class="ml-3">
            <div class="text-sm text-gray-600">
              {{ session.agent.platform ? session.agent.platform : "Unknown" }}
              -
              {{ session.agent.browser ? session.agent.browser : "Unknown" }}
            </div>

            <div>
              <div class="text-xs text-gray-500">
                {{ session.ip_address }},

                <span
                  v-if="session.is_current_device"
                  class="font-semibold text-green-500"
                  >This device</span
                >
                <span v-else>Last active {{ session.last_active }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-5 flex items-center">
        <PrimaryButton @click="confirmLogout">
          Keluarkan Seluruh Sesi Browser
        </PrimaryButton>

        <ActionMessage :on="form.recentlySuccessful" class="ml-3">
          Selesai.
        </ActionMessage>
      </div>

      <!-- Log Out Other Devices Confirmation Modal -->
      <DialogModal :show="confirmingLogout" @close="closeModal">
        <template #title>Keluarkan Seluruh Sesi Browser Lainnya</template>

        <template #content>
          Mohon masukan password anda untuk mengkonfirmasi bahwa anda ingin
          mengeluarkan seluruh sesi browser diseluruh perangkat.

          <div class="mt-4">
            <TextInput
              ref="passwordInput"
              v-model="form.password"
              type="password"
              class="mt-1 block w-3/4"
              placeholder="Password"
              @keyup.enter="logoutOtherBrowserSessions"
            />

            <InputError :message="form.errors.password" class="mt-2" />
          </div>
        </template>

        <template #footer>
          <SecondaryButton @click="closeModal"> Kembali</SecondaryButton>

          <PrimaryButton
            class="ml-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="logoutOtherBrowserSessions"
          >
            Keluarkan Seluruh Sesi Browser
          </PrimaryButton>
        </template>
      </DialogModal>
    </template>
  </ActionSection>
</template>
