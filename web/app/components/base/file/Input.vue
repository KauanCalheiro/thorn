<script setup lang="ts">
import type { Form } from "@nuxt/ui";
import type { ShallowUnwrapRef } from "vue";
import { ref, computed, watch } from "vue";
import type { InputFileTypes } from "~~/types/InputFileTypes";
import type { UiColor } from "~~/types/ui/Color";

const uid = useId();
const inputId = `upload-input-${uid}`;

const {
  modelValue,
  acceptedFiles = ["*/*"],
  error,
  disabled = false,
  form,
  name,
} = defineProps<{
  modelValue?: Promise<File> | File | undefined;
  acceptedFiles?: InputFileTypes[];
  error?: string | boolean;
  disabled?: boolean;
  form?: Form<any> | null;
  name: string;
}>();
const emit = defineEmits<{
  (e: "update:modelValue", value: File | undefined): void;
}>();

const highlight = computed(() => !!error);
const color = computed<UiColor>(() => (!!error ? "error" : "primary"));

const fileInput = ref<HTMLInputElement>();
const uploadedFile = ref<Promise<File> | File | undefined>(
  modelValue || undefined
);

const isUploaded = computed(() => !!uploadedFile.value);
const acceptString = computed(() => (acceptedFiles || []).join(","));
const hasAcceptedTypes = computed(() => (acceptedFiles || []).length > 0);

function onFileChange(e: Event) {
  const file = (e.target as HTMLInputElement).files?.[0] ?? undefined;
  if (
    file &&
    (!acceptedFiles ||
      acceptedFiles.includes(file.type as InputFileTypes) ||
      acceptedFiles.includes("*/*"))
  ) {
    uploadedFile.value = file;
    emit("update:modelValue", file);
    form?.validate({ name: name });
  } else {
    clearAll();
  }
}

function clearFile(e: Event) {
  e.preventDefault();
  clearAll();
}

function clearAll() {
  uploadedFile.value = undefined;
  emit("update:modelValue", undefined);
  form?.setErrors([], name);
  if (fileInput.value) fileInput.value.value = "";
}

watch(
  () => modelValue,
  (file) => {
    uploadedFile.value = file || undefined;
  }
);
</script>

<template>
  <label
    :for="inputId"
    class="rounded-lg flex relative bg-elevated/50 hover:bg-elevated disabled:bg-elevated/30"
    :class="
      isUploaded
        ? 'border-none cursor-not-allowed'
        : 'border-dashed py-6 items-center justify-center cursor-pointer'
    "
    :disabled="isUploaded"
    v-auto-animate
  >
    <input
      ref="fileInput"
      :id="inputId"
      type="file"
      :accept="acceptString"
      class="hidden"
      @change="onFileChange"
      :disabled="isUploaded"
    />

    <div
      v-if="!isUploaded"
      class="flex flex-col items-center text-center pointer-events-none gap-2"
    >
      <Icon name="solar:cloud-upload-bold" class="h-12 w-12 bg-neutral-700" />
      <div class="text-xs text-neutral-500">
        Escolha ou arraste um arquivo <br />
        <span v-if="hasAcceptedTypes">( {{ acceptString }} )</span>
      </div>
    </div>

    <div v-else class="flex items-center w-full">
      <BaseFileInputCard
        :highlight="highlight"
        :color="color"
        :disabled="disabled"
        v-if="uploadedFile"
        :file="uploadedFile"
        @close="clearFile"
      />
    </div>
  </label>
</template>
