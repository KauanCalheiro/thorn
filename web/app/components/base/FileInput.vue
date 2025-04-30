<template>
  <label
    :for="inputId"
    class="border-2 border-neutral-700 rounded-2xl flex items-center justify-center relative cursor-pointer group bg-transparent"
    :class="{
      'py-6': !previewUrl,
      'border-dashed': !previewUrl,
      'cursor-not-allowed': previewUrl,
    }"
    :disabled="previewUrl"
  >
    <input
      :id="inputId"
      ref="fileInput"
      type="file"
      :accept="acceptedFiles.join(',')"
      class="hidden"
      @change="onFileChange"
      :disabled="(previewUrl?.length ?? 0) > 0"
    />

    <div
      v-if="!previewUrl"
      class="flex flex-col items-center text-center pointer-events-none transition-opacity duration-300 gap-2"
    >
      <Icon name="lucide:upload" class="h-12 w-12 mb-2 bg-neutral-700" />
      <p class="text-base font-semibold text-neutral-400 flex flex-col gap-2">
        <span class="text-xs text-neutral-500 flex flex-col gap-0">
          <div>Escolha ou arraste um arquivo</div>
          <div v-if="acceptedFiles.length > 0">
            ( {{ acceptedFiles.join(", ") }} )
          </div>
        </span>
      </p>
    </div>

    <div v-if="previewUrl" class="relative w-full h-full">
      <img
        :src="previewUrl"
        alt="Preview"
        class="inset-0 w-full h-full object-cover rounded-2xl"
      />
      <UButton
        type="button"
        variant="soft"
        color="neutral"
        size="xs"
        icon="lucide:x"
        @click="clearFile"
        class="absolute top-2 right-2 rounded-full opacity-50"
      />
    </div>
  </label>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import type { InputFileTypes } from "~~/types/InputFileTypes";

const uid = useId();
const inputId = `upload-input-${uid}`;

const { modelValue, acceptedFiles = ["image/png", "image/jpeg"] } =
  defineProps<{
    modelValue: File | null;
    acceptedFiles: InputFileTypes[];
  }>();
const emit = defineEmits<{
  (e: "update:modelValue", value: File | null): void;
}>();

const fileInput = ref<HTMLInputElement | null>(null);
const previewUrl = ref<string | null>(null);

function isAccepted(file: File): boolean {
  return acceptedFiles.includes(file.type as InputFileTypes);
}

function onFileChange(event: Event) {
  const file = (event.target as HTMLInputElement).files?.[0] || null;
  if (file && isAccepted(file)) {
    emit("update:modelValue", file);
    if (file.type.startsWith("image/")) {
      const reader = new FileReader();
      reader.onload = () => {
        previewUrl.value = reader.result as string;
      };
      reader.readAsDataURL(file);
    } else {
      previewUrl.value = null;
    }
  } else {
    emit("update:modelValue", null);
    previewUrl.value = null;
  }
}

function clearFile(event: Event) {
  event.preventDefault();
  previewUrl.value = null;
  emit("update:modelValue", null);
}

watch(
  () => modelValue,
  (file) => {
    if (file && file.type.startsWith("image/")) {
      const reader = new FileReader();
      reader.onload = () => {
        previewUrl.value = reader.result as string;
      };
      reader.readAsDataURL(file);
    } else {
      previewUrl.value = null;
    }
  }
);
</script>
