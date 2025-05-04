<script setup lang="ts">
const { file } = defineProps<{
  file: File;
}>();

const open = defineModel<boolean>("open", { required: true });

const isPdf = computed(() => file.type === "application/pdf");
const url = computed(() => URL.createObjectURL(file));

function handleOpenPdf() {
  console.log("openad");
  const blobUrl = URL.createObjectURL(file);
  window.open(blobUrl, "_blank");
  open.value = false;
}

function handleOpenModal(modalOpen: boolean) {
  if (isPdf.value && modalOpen) {
    handleOpenPdf();
    open.value = false;
  }
}

watch(open, (value) => {
  if (value) {
    handleOpenModal(value);
  }
});
</script>

<template>
  <UModal
    v-model:open="open"
    class="max-w-[70dvw] p-0 w-fit"
    @update:open="handleOpenModal"
  >
    <template #content>
      <div class="flex flex-col items-center justify-center w-full mx-auto">
        <img
          v-if="!isPdf"
          :src="url"
          alt="Preview"
          class="object-contain max-h-[60dvh] border-1 border-primary rounded-lg"
        />
      </div>
    </template>
  </UModal>
</template>
