<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import ActionSection from "@/Components/ActionSection.vue";
import DangerButton from "@/Components/DangerButton.vue";
import DialogModal from "@/Components/DialogModal.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
  password: "",
});

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true;

  setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
  form.delete(route("current-user.destroy"), {
    preserveScroll: true,
    onSuccess: () => closeModal(),
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
};

const closeModal = () => {
  confirmingUserDeletion.value = false;

  form.reset();
};
</script>

<template>
  <ActionSection>
    <template #title> Hapus Akun</template>

    <template #description> Hapus akun anda secara permanen.</template>

    <template #content>
      <div class="max-w-xl text-sm text-gray-600">
        Setelah akun anda terhapus, seluruh sumber dan data anda akan ikut
        terhapus. Sebelum menghapus akun anda, mohon download data dan informasi
        apapun yang anda harap ingin disimpan.
      </div>

      <div class="mt-5">
        <DangerButton @click="confirmUserDeletion"> Hapus Akun </DangerButton>
      </div>

      <!-- Delete Account Confirmation Modal -->
      <DialogModal :show="confirmingUserDeletion" @close="closeModal">
        <template #title> Hapus akun anda secara permanen.</template>

        <template #content>
          Setelah akun anda terhapus, seluruh sumber dan data anda akan ikut
          terhapus. Sebelum menghapus akun anda, mohon download data dan
          informasi apapun yang anda harap ingin disimpan.

          <div class="mt-4">
            <TextInput
              ref="passwordInput"
              v-model="form.password"
              type="password"
              class="mt-1 block w-3/4"
              placeholder="Password"
              @keyup.enter="deleteUser"
            />

            <InputError :message="form.errors.password" class="mt-2" />
          </div>
        </template>

        <template #footer>
          <SecondaryButton @click="closeModal"> Kembali</SecondaryButton>

          <DangerButton
            class="ml-3"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
            @click="deleteUser"
          >
            Hapus Akun
          </DangerButton>
        </template>
      </DialogModal>
    </template>
  </ActionSection>
</template>
