<script setup lang="ts">
import type { UiColor } from "~~/types/ui/Color";

const {
  file,
  highlight = false,
  color = "primary",
  disabled = false,
} = defineProps<{
  file: Promise<File> | File;
  highlight?: boolean;
  color?: UiColor;
  disabled?: boolean;
}>();

const emit = defineEmits<{
  close: [event: Event];
}>();

const finalFile = ref<File | null>(null);
const previewUrl = ref<string | null>(null);
const openPreview = ref(false);
const isLoading = ref(false);

async function resolveFile() {
  isLoading.value = true;
  finalFile.value = await Promise.resolve(file);
  previewUrl.value = URL.createObjectURL(finalFile.value);
  isLoading.value = false;
}

function onClose(event: Event) {
  emit("close", event);
}

function showPreview() {
  openPreview.value = true;
}

resolveFile();
</script>

<template>
  <div
    class="flex flex-row justify-between gap-2 items-center w-full py-3 px-5 cursor-default rounded-lg"
    :class="{
      [`border-1 border-${color}`]: highlight,
      'border-1 border-transparent': !highlight,
    }"
    @click="showPreview"
  >
    <div class="flex flex-row gap-5 items-center">
      <UIcon
        :name="isLoading ? useLoadingIcon() : 'solar:file-bold-duotone'"
        class="h-8 w-8"
      />
      <div class="flex flex-col">
        <span class="text-sm font-normal truncate w-45">
          {{ isLoading ? "Carregando..." : finalFile?.name }}
        </span>
      </div>
    </div>
    <UButton
      v-if="(!isLoading && !disabled) || !disabled"
      type="button"
      color="neutral"
      size="xs"
      icon="lucide:x"
      @click="onClose"
      class="rounded-full"
    />
  </div>

  <BaseFilePreview
    v-if="finalFile"
    v-model:open="openPreview"
    :file="finalFile"
  />
</template>
